<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $userRepo;
    protected $permissionRepo;

    public function __construct(UserRepository $userRepo, PermissionRepository $permissionRepo)
    {
        $this->userRepo = $userRepo;
        $this->permissionRepo = $permissionRepo;
    }

    public function login(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            if (Auth::check() && Auth::guard('web')) {
                return redirect()->route('dashboard');
            }
            return view('login');
        }

        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect('/');
        } else {
            return redirect('login')->with('login_error', 'Incorrect email or password');
        }
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);

        
        $user = $this->userRepo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $permissions = $this->permissionRepo->getPermissionByName(['create_post', 'create_comment']);
        if($permissions) {
            $user->syncPermissions($permissions);
        }

        Auth::login($user);

        return redirect('/');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session::flush();
        
        return redirect('/login');
    }
}
