@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tasks Management</h1>
            <p class="text-gray-600">Manage your project tasks efficiently</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('project.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-project-diagram mr-2"></i>Project
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('tasks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Create Task
            </a>
            <button class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors" onclick="openTransferModal()">
                <i class="fas fa-exchange-alt mr-2"></i>Transfer Task
            </button>
            @endif
        </div>
    </div>

    <!-- Task Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6" data-aos="fade-up">

        <!-- To Do Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-red-500 h-2"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-list mr-2 text-red-500"></i>
                        To Do
                    </h2>
                    <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">{{ $todoTasks->count() }}</span>
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($todoTasks as $task)
                    <a href="{{ route('tasks.show', $task->id) }}" class="block bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $task->title }}</h3>
                            <span class="priority-tag priority-{{ strtolower($task->priority) }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">{{ $task->project->name }}</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                <span class="text-xs text-gray-500">{{ $task->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <img src="{{ $task->assignedUser->avatar ?? 'https://via.placeholder.com/24' }}"
                                     alt="{{ $task->assignedUser->name }}"
                                     class="w-6 h-6 rounded-full border-2 border-gray-200">
                                <button type="button" onclick="event.stopPropagation(); updateTaskStatus({{ $task->id }}, 'in_progress')"
                                        class="w-8 h-8 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-play text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                        <p class="text-sm">No tasks in To-Do</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- In Progress Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-orange-500 h-2"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-clock mr-2 text-orange-500"></i>
                        In Progress
                    </h2>
                    <span class="bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">{{ $inProgressTasks->count() }}</span>
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($inProgressTasks as $task)
                    <a href="{{ route('tasks.show', $task->id) }}" class="block bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $task->title }}</h3>
                            <span class="priority-tag priority-{{ strtolower($task->priority) }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">{{ $task->project->name }}</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                <span class="text-xs text-gray-500">{{ $task->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <img src="{{ $task->assignedUser->avatar ?? 'https://via.placeholder.com/24' }}"
                                     alt="{{ $task->assignedUser->name }}"
                                     class="w-6 h-6 rounded-full border-2 border-gray-200">
                                <button type="button" onclick="event.stopPropagation(); updateTaskStatus({{ $task->id }}, 'review')"
                                        class="w-8 h-8 bg-purple-500 text-white rounded-full hover:bg-purple-600 transition-colors">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-clock text-3xl mb-2 opacity-50"></i>
                        <p class="text-sm">No tasks in progress</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Review Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-purple-500 h-2"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-purple-500"></i>
                        Review
                    </h2>
                    <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full">{{ $reviewTasks->count() }}</span>
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($reviewTasks as $task)
                    <a href="{{ route('tasks.show', $task->id) }}" class="block bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $task->title }}</h3>
                            <span class="priority-tag priority-{{ strtolower($task->priority) }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">{{ $task->project->name }}</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                <span class="text-xs text-gray-500">{{ $task->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <img src="{{ $task->assignedUser->avatar ?? 'https://via.placeholder.com/24' }}"
                                     alt="{{ $task->assignedUser->name }}"
                                     class="w-6 h-6 rounded-full border-2 border-gray-200">
                                <button type="button" onclick="event.stopPropagation(); updateTaskStatus({{ $task->id }}, 'complete')"
                                        class="w-8 h-8 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-eye text-3xl mb-2 opacity-50"></i>
                        <p class="text-sm">No tasks under review</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Completed Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-green-500 h-2"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        Completed
                    </h2>
                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $completeTasks->count() }}</span>
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($completeTasks as $task)
                    <a href="{{ route('tasks.show', $task->id) }}" class="block bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $task->title }}</h3>
                            <span class="priority-tag priority-{{ strtolower($task->priority) }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">{{ $task->project->name }}</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                <span class="text-xs text-gray-500">{{ $task->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <img src="{{ $task->assignedUser->avatar ?? 'https://via.placeholder.com/24' }}"
                                     alt="{{ $task->assignedUser->name }}"
                                     class="w-6 h-6 rounded-full border-2 border-gray-200">
                                <span class="text-xs text-green-600 font-medium flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Done
                                </span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-check-circle text-3xl mb-2 opacity-50"></i>
                        <p class="text-sm">No completed tasks</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Priority Tags */
.priority-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    color: white;
    white-space: nowrap;
}

.priority-high {
    background: #EF4444;
}

.priority-medium {
    background: #F59E0B;
}

.priority-low {
    background: #6B7280;
}

/* Custom Scrollbar */
.max-h-96::-webkit-scrollbar {
    width: 4px;
}

.max-h-96::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.max-h-96::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.max-h-96::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .grid.grid-cols-1.lg\\:grid-cols-2.xl\\:grid-cols-4 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .max-h-96 {
        max-height: 24rem;
    }
}

@media (min-width: 1024px) and (max-width: 1279px) {
    .grid.grid-cols-1.lg\\:grid-cols-2.xl\\:grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>

<script>
function updateTaskStatus(taskId, status) {
    console.log("Updating task:", taskId, "to status:", status);

    if (confirm('Are you sure you want to update this task status?')) {
        fetch(`/tasks/${taskId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('HTML response instead of JSON:', text);
                    throw new Error(`HTTP error ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Status update failed.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the task status.');
        });
    }
}

function openTransferModal() {
    alert('Transfer task functionality would be implemented here');
}
</script>
@endsection
