<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected $userRepo;
    protected $permissionRepo;

    public function __construct(UserRepository $userRepo, PermissionRepository $permissionRepo)
    {
        $this->userRepo = $userRepo;
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        $page = request()->has('page') ? request()->get('page') : 1;

        if (Cache::has('users_page_' . $page)) {
            $users = Cache::get('users_page_' . $page);
            return view('admin.users.index', compact('users'));
        }
        
        $users = Cache::tags('users')->rememberForever('users_page_' . $page, function () {
            return $this->userRepo->getUser(20);
        });

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $rules = $this->permissionRepo->getAll();
        return view('admin.users.edit', compact('rules', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepo->update($id, [
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
