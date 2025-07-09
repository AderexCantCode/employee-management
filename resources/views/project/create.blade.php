@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Please fix the following errors:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Single Combined Form -->
        <form method="POST" action="{{ route('project.store') }}" class="space-y-8">
            @csrf

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Panel - Project Form -->
                <div class="bg-white rounded-lg shadow-md p-8 flex-1">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">New Project</h2>

                    <div class="space-y-6">
                        <!-- Project Name -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Project Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Project name..."
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <!-- Date Fields -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">Start Date</label>
                                <input type="date"
                                       name="start_date"
                                       value="{{ old('start_date') }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            <div>
                                <label class="block text-gray-600 font-medium mb-2">End Date</label>
                                <input type="date"
                                       name="end_date"
                                       value="{{ old('end_date') }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                        </div>

                        <!-- Project Level -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Project Level</label>
                            <select name="level"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="low" {{ old('level') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('level') == 'medium' || old('level') == null ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('level') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <!-- About Project -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">About Project</label>
                            <textarea name="description"
                                      rows="6"
                                      placeholder="About project..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Team Members (SDM) -->
                <div class="bg-white rounded-lg shadow-md p-8 flex-1">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">SDM (Team Members)</h2>

                    <div class="space-y-6">
                        <!-- Project Director -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2">Project Director</label>
                            <select name="project_director" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Project Director</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('project_director') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->divisi }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Backend Engineer</label>
                                    <select name="engineer_backend" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Backend Engineer</option>
                                        @foreach($employees->where('divisi', 'Backend Dev') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('engineer_backend') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Frontend Engineer</label>
                                    <select name="engineer_frontend" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Frontend Engineer</option>
                                        @foreach($employees->where('divisi', 'Frontend Dev') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('engineer_frontend') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Engineer Android</label>
                                    <select name="engineer_android" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Engineer Android</option>
                                        @foreach($employees->where('divisi', 'Android Dev') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('engineer_android') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Engineer iOS</label>
                                    <select name="engineer_ios" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Engineer iOS</option>
                                        @foreach($employees->where('divisi', 'IOS Dev') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('engineer_ios') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">UI/UX Designer</label>
                                    <select name="uiux" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select UI/UX Designer</option>
                                        @foreach($employees->where('divisi', 'UI UX') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('uiux') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Analyst</label>
                                    <select name="analis" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Analyst</option>
                                        @foreach($employees->where('divisi', 'Analis') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('analis') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Content Creator</label>
                                    <select name="content_creator" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Content Creator</option>
                                        @foreach($employees->where('divisi', 'Content Creator') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('content_creator') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Copywriter</label>
                                    <select name="copywriter" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Copywriter</option>
                                        @foreach($employees->where('divisi', 'Copywriter') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('copywriter') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-600 font-medium mb-2">Tester</label>
                                    <select name="tester" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Tester</option>
                                        @foreach($employees->where('divisi', 'Tester') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('tester') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} ({{ $employee->divisi }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('project.index') }}"
                   class="px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
