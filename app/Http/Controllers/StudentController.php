<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
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
    public function index()
    {
        $users = User::all();
        return view('student.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
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
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

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
}
