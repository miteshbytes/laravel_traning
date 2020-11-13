<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('user.users');
    }

    public function search(Request $request)
    {

        if($request->isMethod('POST'))
        {
            $request->session()->put('search_data', $request->all());
            $users = User::where('name', 'LIKE', '%'.$request->input('fullName').'%')
                        ->where('role_id', 'LIKE', '%'.$request->input('selectRole').'%')->paginate(5);
            $roles = Role::all();

            return view('user.index', compact(['users', 'roles']))->with('i', (request()->input('page', 1) - 1) * 5);
        }
        else
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
        }


        return view('user.index', compact(['users', 'roles']))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
