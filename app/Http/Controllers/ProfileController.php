<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // Project total: project yang user terlibat sebagai anggota
        $projects_count = $user->projects()->count();
        // Task done: task yang assigned ke user dan status complete
        $tasks_done = $user->tasks()->where('status', 'complete')->count();
        // Total leave: jumlah absences yang status approved
        $leave_days = $user->absences()->where('status', 'approved')->count();

        return view('profile.edit', compact('user', 'projects_count', 'tasks_done', 'leave_days'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:ready,standby,not_ready',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->status = $request->status;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->birth = $request->birth_date;
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }
            $file = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatar'), $filename);
            $user->avatar = 'avatar/' . $filename;
        }
        if ($request->filled('password')) {
            $user->password = $request->password; // will be hashed automatically by model cast
        }
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
