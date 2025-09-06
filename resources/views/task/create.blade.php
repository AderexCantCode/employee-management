@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6" data-aos="fade-down">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Create New Task</h1>
                        <p class="text-sm text-gray-500">Add a new task to your project workspace</p>
                    </div>
                </div>
                <a href="{{ route('tasks.index') }}" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-times text-gray-600 text-sm"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Create Task Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200" data-aos="fade-up">
        <form method="POST" action="{{ route('tasks.store') }}" class="p-6">
            @csrf

            <!-- Task Basic Information -->
            <div class="mb-8">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Task Title -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tasks text-gray-400 mr-2"></i>
                            Task Title *
                        </label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200"
                               placeholder="Enter a clear and descriptive task title">
                        @error('title')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Task Description -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-align-left text-gray-400 mr-2"></i>
                            Description *
                        </label>
                        <textarea name="description" rows="4" required
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 resize-none"
                                  placeholder="Provide detailed information about the task requirements, objectives, and any important notes">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Assignment & Project -->
            <div class="mb-8">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-purple-600 text-sm"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Assignment & Project</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Project Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-project-diagram text-gray-400 mr-2"></i>
                            Project *
                        </label>
                        <select name="project_id" required onchange="this.form.submit()"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200">
                            <option value="">Choose a project</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ (request('project_id') == $project->id || old('project_id') == $project->id) ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- User Assignment -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-user text-gray-400 mr-2"></i>
                            Assign To *
                        </label>
                        <select name="assigned_users[]" multiple required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (collect(old('assigned_users'))->contains($user->id)) ? 'selected' : '' }}>
                                {{ $user->name }}{{ $user->divisi ? ' (' . $user->divisi . ')' : '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('assigned_users')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Task Settings -->
            <div class="mb-8">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-orange-600 text-sm"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Task Settings</h2>
                </div>

                <!-- Priority Selection -->
                <div class="space-y-4 mb-6">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-flag text-gray-400 mr-2"></i>
                        Priority Level *
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Low Priority -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="priority" value="low" class="sr-only" {{ old('priority', 'low') == 'low' ? 'checked' : '' }} required>
                            <div class="priority-card border-2 border-gray-200 rounded-lg p-4 hover:border-green-300 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="priority-indicator w-4 h-4 rounded-full bg-green-100 border-2 border-green-400"></div>
                                    <div>
                                        <div class="font-medium text-gray-900">Low Priority</div>
                                        <div class="text-xs text-gray-500">Non-urgent tasks</div>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Medium Priority -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="priority" value="medium" class="sr-only" {{ old('priority') == 'medium' ? 'checked' : '' }} required>
                            <div class="priority-card border-2 border-gray-200 rounded-lg p-4 hover:border-yellow-300 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="priority-indicator w-4 h-4 rounded-full bg-yellow-100 border-2 border-yellow-400"></div>
                                    <div>
                                        <div class="font-medium text-gray-900">Medium Priority</div>
                                        <div class="text-xs text-gray-500">Standard tasks</div>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- High Priority -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="priority" value="high" class="sr-only" {{ old('priority') == 'high' ? 'checked' : '' }} required>
                            <div class="priority-card border-2 border-gray-200 rounded-lg p-4 hover:border-red-300 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="priority-indicator w-4 h-4 rounded-full bg-red-100 border-2 border-red-400"></div>
                                    <div>
                                        <div class="font-medium text-gray-900">High Priority</div>
                                        <div class="text-xs text-gray-500">Urgent tasks</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('priority')
                        <p class="text-sm text-red-600 flex items-center mt-2">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Date Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-plus text-gray-400 mr-2"></i>
                            Start Date
                        </label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200">
                        @error('start_date')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-times text-gray-400 mr-2"></i>
                            Due Date *
                        </label>
                        <input type="date" name="due_date" required value="{{ old('due_date') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200">
                        @error('due_date')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('tasks.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 flex items-center space-x-2 shadow-sm">
                    <i class="fas fa-check"></i>
                    <span>Create Task</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Helper Information -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4" data-aos="fade-up" data-aos-delay="200">
        <div class="flex items-start space-x-3">
            <i class="fas fa-lightbulb text-blue-500 mt-0.5"></i>
            <div class="text-sm text-blue-700">
                <div class="font-medium mb-1">Task Creation Tips:</div>
                <ul class="space-y-1 text-xs">
                    <li>• Use clear and specific task titles that describe the expected outcome</li>
                    <li>• Include detailed requirements and acceptance criteria in the description</li>
                    <li>• Set realistic due dates considering task complexity and team availability</li>
                    <li>• Choose appropriate priority levels to help team members focus on important work</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
/* Priority Selection Styles */
input[type="radio"]:checked + .priority-card {
    border-color: #3b82f6;
    background-color: #eff6ff;
}

input[type="radio"][value="low"]:checked + .priority-card {
    border-color: #22c55e;
    background-color: #f0fdf4;
}

input[type="radio"][value="medium"]:checked + .priority-card {
    border-color: #eab308;
    background-color: #fefce8;
}

input[type="radio"][value="high"]:checked + .priority-card {
    border-color: #ef4444;
    background-color: #fef2f2;
}

input[type="radio"]:checked + .priority-card .priority-indicator {
    background-color: currentColor;
}

input[type="radio"][value="low"]:checked + .priority-card .priority-indicator {
    background-color: #22c55e;
    border-color: #22c55e;
}

input[type="radio"][value="medium"]:checked + .priority-card .priority-indicator {
    background-color: #eab308;
    border-color: #eab308;
}

input[type="radio"][value="high"]:checked + .priority-card .priority-indicator {
    background-color: #ef4444;
    border-color: #ef4444;
}

/* Focus styles for accessibility */
input[type="radio"]:focus + .priority-card {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Form Field Enhancements */
.form-field {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-field:focus-within {
    transform: translateY(-1px);
}

/* Custom Date Input Styling */
input[type="date"]::-webkit-calendar-picker-indicator {
    color: #6b7280;
    cursor: pointer;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
    color: #374151;
}

/* Section Headers */
.section-header {
    position: relative;
    padding-left: 2rem;
}

.section-header::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 2px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .grid.grid-cols-1.sm\\:grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 0.75rem;
    }

    .priority-card {
        padding: 1rem;
    }

    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .space-x-3 > * + * {
        margin-left: 0.5rem;
    }
}

/* Enhanced Error States */
.error-field {
    border-color: #ef4444;
    background-color: #fef2f2;
}

.error-field:focus {
    ring-color: #ef4444;
    border-color: #ef4444;
}

/* Loading State for Submit Button */
.loading {
    opacity: 0.7;
    cursor: not-allowed;
}

.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add form validation enhancements
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function() {
        // Add loading state to submit button
        submitButton.classList.add('loading');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner"></i><span>Creating Task...</span>';
    });

    // Enhanced date validation
    const startDateInput = document.querySelector('input[name="start_date"]');
    const dueDateInput = document.querySelector('input[name="due_date"]');

    function validateDates() {
        if (startDateInput.value && dueDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const dueDate = new Date(dueDateInput.value);

            if (startDate > dueDate) {
                dueDateInput.setCustomValidity('Due date must be after start date');
            } else {
                dueDateInput.setCustomValidity('');
            }
        }
    }

    startDateInput.addEventListener('change', validateDates);
    dueDateInput.addEventListener('change', validateDates);

    // Auto-focus on title field when page loads
    const titleInput = document.querySelector('input[name="title"]');
    if (titleInput) {
        titleInput.focus();
    }

    // Enhanced textarea auto-resize
    const textarea = document.querySelector('textarea[name="description"]');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>
@endsection
