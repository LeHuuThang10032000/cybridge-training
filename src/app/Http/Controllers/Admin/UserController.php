<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->simplePaginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $rules = Permission::all();
        return view('admin.users.edit', compact('rules', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncPermissions($request->permissions);

        return back();
    }

    public function export(Request $request)
    {
        return Excel::download(new UsersExport, 'users.' . $request->type);
    }

    public function import(Request $request) 
    {
        Excel::import(new UsersImport, $request->file('user_file')->store('files'));
        
        return back();
    }
}
