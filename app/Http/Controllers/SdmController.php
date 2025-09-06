<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SdmController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->get();
        return view('sdm.index', compact('users'));
    }

    public function create()
    {
        return view('sdm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:employee,admin',
            'divisi' => 'required|in:Backend Dev,Frontend Dev,UI UX,Android Dev,IOS Dev,Analis,Content Creator,Tester,Copywriter',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'divisi' => $request->divisi,
            'status' => 'ready',
        ]);

        return redirect()->route('sdm.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('sdm.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:employee,admin',
            'divisi' => 'required|in:Backend Dev,Frontend Dev,UI UX,Android Dev,IOS Dev,Analis,Content Creator,Tester,Copywriter',
        ]);

        $user->update($request->only('name', 'email', 'role', 'divisi'));

        return redirect()->route('sdm.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('sdm.index')->with('success', 'User deleted successfully.');
    }
}
