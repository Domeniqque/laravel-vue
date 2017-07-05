<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json(compact('users'));
    }

    public function store()
    {
        $this->validate(request(), [
            'username' => 'required',
            'email' => 'required|unique:users|email',
        ]);

        $user = User::create([
            'username' => request('username'),
            'email' => request('email'),
        ]);

        return response()->json([
           'message' => 'User created successfully',
           'user' => $user
        ]);
    }

    public function update(User $user)
    {
        $this->validate(request(), [
            'username' => 'required',
            'email' => 'required|email',
        ]);

        $user->update(
            request()->only(['username', 'email'])
        );

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
