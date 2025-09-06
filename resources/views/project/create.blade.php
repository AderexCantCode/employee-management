@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New Project</h1>
                    <p class="text-gray-600 mt-2">Set up your project details and assign team members</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-home"></i>
                    <span>/</span>
                    <a href="{{ route('project.index') }}" class="hover:text-cyan-600 transition-colors">Projects</a>
                    <span>/</span>
                    <span class="text-gray-900">Create</span>
                </div>
            </div>
        </div>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg shadow-sm" data-aos="fade-down">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Form -->
        <form method="POST" action="{{ route('project.store') }}" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Left Panel - Project Information -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-shadow border border-gray-100" data-aos="fade-right">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-project-diagram text-white text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">Project Details</h2>
                            <p class="text-gray-600 text-sm">Basic information about your project</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Project Name -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-tag text-gray-400 mr-2"></i>Project Name
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Enter project name..."
                                       class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-asterisk text-red-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Date Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>Start Date
                                </label>
                                <input type="date"
                                       name="start_date"
                                       value="{{ old('start_date') }}"
                                       class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300"
                                       required>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-calendar-check text-gray-400 mr-2"></i>End Date
                                </label>
                                <input type="date"
                                       name="end_date"
                                       value="{{ old('end_date') }}"
                                       class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300"
                                       required>
                            </div>
                        </div>

                        <!-- Project Level -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-layer-group text-gray-400 mr-2"></i>Project Level
                            </label>
                            <div class="relative">
                                <select name="level"
                                        class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300 appearance-none"
                                        required>
                                    <option value="low" {{ old('level') == 'low' ? 'selected' : '' }}>
                                        🟢 Low Priority
                                    </option>
                                    <option value="medium" {{ old('level') == 'medium' || old('level') == null ? 'selected' : '' }}>
                                        🟡 Medium Priority
                                    </option>
                                    <option value="high" {{ old('level') == 'high' ? 'selected' : '' }}>
                                        🔴 High Priority
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- About Project -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-align-left text-gray-400 mr-2"></i>Project Description
                            </label>
                            <textarea name="description"
                                      rows="6"
                                      placeholder="Describe your project goals, objectives, and key features..."
                                      class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-gray-300 resize-none"
                                      required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Team Members -->
                <div class="bg-white rounded-2xl shadow-lg p-8 card-shadow border border-gray-100" data-aos="fade-left">
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">Team Assignment</h2>
                            <p class="text-gray-600 text-sm">Assign team members to your project</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Project Director -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-crown text-yellow-500 mr-2"></i>Project Director
                            </label>
                            <div class="relative">
                                <select name="project_director"
                                        class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 group-hover:border-gray-300 appearance-none">
                                    <option value="">Select Project Director</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('project_director') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} - {{ $employee->divisi }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Development Team -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-code text-blue-500 mr-2"></i>Development Team
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Backend Engineer -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-server text-gray-400 mr-2 text-xs"></i>Backend Engineer
                                    </label>
                                    <div class="relative">
                                        <select name="engineer_backend"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select Backend Engineer</option>
                                            @foreach($employees->where('divisi', 'Backend Dev') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('engineer_backend') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Frontend Engineer -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-palette text-gray-400 mr-2 text-xs"></i>Frontend Engineer
                                    </label>
                                    <div class="relative">
                                        <select name="engineer_frontend"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select Frontend Engineer</option>
                                            @foreach($employees->where('divisi', 'Frontend Dev') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('engineer_frontend') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Android Engineer -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fab fa-android text-gray-400 mr-2 text-xs"></i>Android Engineer
                                    </label>
                                    <div class="relative">
                                        <select name="engineer_android"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select Android Engineer</option>
                                            @foreach($employees->where('divisi', 'Android Dev') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('engineer_android') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- iOS Engineer -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fab fa-apple text-gray-400 mr-2 text-xs"></i>iOS Engineer
                                    </label>
                                    <div class="relative">
                                        <select name="engineer_ios"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select iOS Engineer</option>
                                            @foreach($employees->where('divisi', 'IOS Dev') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('engineer_ios') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Design & Content Team -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-pencil-ruler text-purple-500 mr-2"></i>Design & Content
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- UI/UX Designer -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-paint-brush text-gray-400 mr-2 text-xs"></i>UI/UX Designer
                                    </label>
                                    <div class="relative">
                                        <select name="uiux"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select UI/UX Designer</option>
                                            @foreach($employees->where('divisi', 'UI UX') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('uiux') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Creator -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-camera text-gray-400 mr-2 text-xs"></i>Content Creator
                                    </label>
                                    <div class="relative">
                                        <select name="content_creator"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select Content Creator</option>
                                            @foreach($employees->where('divisi', 'Content Creator') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('content_creator') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Copywriter -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-pen-fancy text-gray-400 mr-2 text-xs"></i>Copywriter
                                    </label>
                                    <div class="relative">
                                        <select name="copywriter"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select Copywriter</option>
                                            @foreach($employees->where('divisi', 'Copywriter') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('copywriter') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Analyst -->
                                <div class="group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-chart-bar text-gray-400 mr-2 text-xs"></i>Analyst
                                    </label>
                                    <div class="relative">
                                        <select name="analis"
                                                class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                            <option value="">Select Analyst</option>
                                            @foreach($employees->where('divisi', 'Analis') as $employee)
                                            <option value="{{ $employee->id }}" {{ old('analis') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quality Assurance -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-shield-alt text-green-500 mr-2"></i>Quality Assurance
                            </h3>
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-bug text-gray-400 mr-2 text-xs"></i>Tester
                                </label>
                                <div class="relative">
                                    <select name="tester"
                                            class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-sm appearance-none">
                                        <option value="">Select Tester</option>
                                        @foreach($employees->where('divisi', 'Tester') as $employee)
                                        <option value="{{ $employee->id }}" {{ old('tester') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-8" data-aos="fade-up">
                <a href="{{ route('project.index') }}"
                   class="px-8 py-4 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200 flex items-center space-x-2 border border-gray-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>Cancel</span>
                </a>
                <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus"></i>
                    <span>Create Project</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom scrollbar for better aesthetics */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Enhanced focus states */
.group:focus-within label {
    color: #0ea5e9;
}

/* Smooth transitions for all interactive elements */
select, input, textarea {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom select arrow styling */
select {
    background-image: none;
}

/* Enhanced hover effects */
.group:hover input,
.group:hover select,
.group:hover textarea {
    border-color: #d1d5db;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}
</style>
@endsection
