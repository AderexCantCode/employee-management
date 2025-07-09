@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-lg mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>
    <form method="POST" action="{{ route('sdm.update', $user) }}" class="space-y-6 bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Divisi</label>
            <select name="divisi" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="Backend Dev" {{ $user->divisi == 'Backend Dev' ? 'selected' : '' }}>Backend Dev</option>
                <option value="Frontend Dev" {{ $user->divisi == 'Frontend Dev' ? 'selected' : '' }}>Frontend Dev</option>
                <option value="UI UX" {{ $user->divisi == 'UI UX' ? 'selected' : '' }}>UI UX</option>
                <option value="Android Dev" {{ $user->divisi == 'Android Dev' ? 'selected' : '' }}>Android Dev</option>
                <option value="IOS Dev" {{ $user->divisi == 'IOS Dev' ? 'selected' : '' }}>IOS Dev</option>
                <option value="Analis" {{ $user->divisi == 'Analis' ? 'selected' : '' }}>Analis</option>
                <option value="Content Creator" {{ $user->divisi == 'Content Creator' ? 'selected' : '' }}>Content Creator</option>
                <option value="Tester" {{ $user->divisi == 'Tester' ? 'selected' : '' }}>Tester</option>
                <option value="Copywriter" {{ $user->divisi == 'Copywriter' ? 'selected' : '' }}>Copywriter</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Update User</button>
    </form>
</div>
@endsection
