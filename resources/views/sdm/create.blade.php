@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<div class="max-w-lg mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Add New User</h1>
    <form method="POST" action="{{ route('sdm.store') }}" class="space-y-6 bg-white rounded-lg shadow p-6">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
    <label class="block text-gray-700 font-medium mb-2">Divisi</label>
                <select name="divisi" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="Backend Dev">Backend Dev</option>
                    <option value="Frontend Dev">Frontend Dev</option>
                    <option value="UI UX">UI UX</option>
                    <option value="Android Dev">Android Dev</option>
                    <option value="IOS Dev">IOS Dev</option>
                    <option value="Analis">Analis</option>
                    <option value="Content Creator">Content Creator</option>
                    <option value="Tester">Tester</option>
                    <option value="Copywriter">Copywriter</option>

                </select>
            </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Add User</button>
    </form>
</div>
@endsection
