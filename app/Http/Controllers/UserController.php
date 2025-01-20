<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNot('id', Auth::id())->with('roles')->get();
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required|string|in:admin,user',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $imageName = $request->file('photo')->store('images/users', 'public');
        } else {
            $imageName = 'images/users/defaultUser.png';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $imageName,
        ]);
        $user->assignRole($request->role);
        return redirect()->route('users.index');
    }

    /**
     * Block user
     */
    public function block(User $user)
    {
        $user->update(['is_blocked' => true]);
        return redirect()->route('users.index');
    }

    /**
     * Unblock user
     */
    public function unblock(User $user)
    {
        $user->update(['is_blocked' => false]);
        return redirect()->route('users.index');
    }
}
