<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Events\SendMail;
use App\Jobs\SendMailQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // check is Teacher
        if($request->session()->get('user_data')['role_id'] == 2)
        {
            $users = User::where('id', '!=', '1')->paginate(5);
            $roles = Role::where('id', '!=', 1)->get();
        }
        // check is Admin
        else if($request->session()->get('user_data')['role_id'] == 1)
        {
            //$users = User::all();
            $users = User::paginate(5);
            $roles = Role::all();
        }
        // check is Student
        else
        {
            $users = User::where('id', '=', $request->session()->get('user_data')['id'])->paginate(5);
        }

        return view('student.index', compact(['users', 'roles']))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // if logged user teacher who can create only student
        if($request->session()->get('user_data')['role_id'] == 2)
        {
            $roles = Role::where('id', '=', 6)->get();
        }
        else
        {
            $roles = Role::all();
        }
        return view('student.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns|unique:users,email',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $filename = sprintf('profile_%s.jpg', random_int(1, 1000));
        if($request->hasFile('image'))
        {
            $filename = $request->file('image')->storeAs('profiles', $filename, 'public');
        }
        else
        {
            $filename = "profiles/dummy.jpg";
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make("welcome123");
        $user->gender = $request->gender;
        $user->birth_date = date("Y-m-d", strtotime($request->birth_date));
        $user->role_id = $request->role;
        $user->image = $filename;

        $result = $user->save();
        // use Event & Listener
        SendMail::dispatch($user);
        // Use Queue
        //SendMailQueue::dispatch($user)->delay(now());
        if($result)
        {
            return redirect()->route('students.index')->with('success','Employee created successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        // if logged user teacher who can edit only teacher/student
        if($request->session()->get('user_data')['role_id'] == 2)
        {
            $roles = Role::where('id', '!=', 1)->get();
        }
        else
        {
            $roles = Role::all();
        }

        return view('student.create', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'gender' => 'required',
            'birth_date' => 'required|date',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $user = User::find($id);
        $filename = sprintf('profile_%s.jpg', random_int(1, 1000));
        if($request->hasFile('image'))
        {
            // remove from folder
            $image_path = public_path('storage').'/'.$user->image;
            unlink($image_path);

            $filename = $request->file('image')->storeAs('profiles', $filename, 'public');
        }
        else
        {
            $filename = $user->image;
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->birth_date = date("Y-m-d", strtotime($request->birth_date));
        $user->role_id = $request->role;
        $user->image = $filename;

        $result = $user->save();
        if($result)
        {
            return redirect()->route('students.index')->with('success','Student updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $image_path = public_path('storage').'/'.$user->image;
        unlink($image_path);

        $user->delete();

        return redirect()->route('students.index')->with('success','Student deleted successfully.');
    }

    // Search by name and role
    public function search(Request $request)
    {
        //dd($request->all());
        $users = User::where('name', 'LIKE', '%'.$request->input('fullName').'%')
        ->where('role_id', 'LIKE', '%'.$request->input('role').'%')->paginate(5);

        return view('student.searchtemplate', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
