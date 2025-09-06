@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200" data-aos="fade-down">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-tasks text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tasks Management</h1>
                        <p class="text-sm text-gray-500">Manage your project tasks efficiently</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('project.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-project-diagram mr-2"></i>
                        Projects
                    </a>
                    <a href="{{ route('tasks.view') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white text-sm font-medium rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-list mr-2"></i>
                        View All Tasks
                    </a>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-medium rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Create Task
                    </a>
                    <button onclick="window.location.href='{{ route('task.transfer.form', [isset($projects) && $projects->count() ? $projects->first()->id : 1]) }}'" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Transfer Task
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Task Board -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6" data-aos="fade-up">

        <!-- To Do Column -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-600 h-1"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-red-600 text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">To Do</h2>
                    </div>
                    <span class="bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $todoTasks->count() }}</span>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                    @forelse($todoTasks as $task)
                    <div class="task-card group bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md hover:bg-white transition-all duration-200 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $task->id) }}'">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $task->title }}</h3>
                            <span class="priority-badge priority-{{ strtolower($task->priority) }} ml-2 flex-shrink-0">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 mb-3">
                            <i class="fas fa-folder text-gray-400 text-xs"></i>
                            <span class="text-xs text-gray-600 truncate">{{ $task->project->name }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                <span class="text-xs text-gray-500">{{ $task->created_at->format('M j') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($task->assignedUsers->count())
                                    @foreach($task->assignedUsers as $user)
                                        @if($user->avatar)
                                            <div class="w-6 h-6 rounded-full overflow-hidden border-2 border-gray-200 inline-block mr-1">
                                                <img src="{{ $user->avatar }}"
                                                     alt="{{ $user->name }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gradient-to-r from-blue-500 to-cyan-500 inline-block mr-1">
                                                <span class="text-xs font-semibold text-white">
                                                    {{ strtoupper(Str::substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gray-200">
                                        <i class="fas fa-user text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                                @if(auth()->id() === $task->assigned_to)
                                <button type="button" onclick="event.stopPropagation(); updateTaskStatus({{ $task->id }}, 'in_progress')"
                                        class="action-btn bg-blue-500 hover:bg-blue-600" title="Start Task">
                                    <i class="fas fa-play text-xs"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">No tasks in To-Do</p>
                        <p class="text-xs text-gray-400">Tasks will appear here when created</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-1"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-orange-600 text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">In Progress</h2>
                    </div>
                    <span class="bg-orange-100 text-orange-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $inProgressTasks->count() }}</span>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                    @forelse($inProgressTasks as $task)
                    <div class="task-card group bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md hover:bg-white transition-all duration-200 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $task->id) }}'">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $task->title }}</h3>
                            <span class="priority-badge priority-{{ strtolower($task->priority) }} ml-2 flex-shrink-0">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 mb-3">
                            <i class="fas fa-folder text-gray-400 text-xs"></i>
                            <span class="text-xs text-gray-600 truncate">{{ $task->project->name }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-orange-600 font-medium">Active</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($task->assignedUsers->count())
                                    @foreach($task->assignedUsers as $user)
                                        @if($user->avatar)
                                            <div class="w-6 h-6 rounded-full overflow-hidden border-2 border-gray-200 inline-block mr-1">
                                                <img src="{{ $user->avatar }}"
                                                     alt="{{ $user->name }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gradient-to-r from-blue-500 to-cyan-500 inline-block mr-1">
                                                <span class="text-xs font-semibold text-white">
                                                    {{ strtoupper(Str::substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gray-200">
                                        <i class="fas fa-user text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                                @if(auth()->id() === $task->assigned_to)
                                <button type="button" onclick="event.stopPropagation(); updateTaskStatus({{ $task->id }}, 'review')"
                                        class="action-btn bg-purple-500 hover:bg-purple-600" title="Send for Review">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-clock text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">No tasks in progress</p>
                        <p class="text-xs text-gray-400">Start working on tasks from To-Do</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Review Column -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-1"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-purple-600 text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Review</h2>
                    </div>
                    <span class="bg-purple-100 text-purple-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $reviewTasks->count() }}</span>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                    @forelse($reviewTasks as $task)
                    <div class="task-card group bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md hover:bg-white transition-all duration-200 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $task->id) }}'">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $task->title }}</h3>
                            <span class="priority-badge priority-{{ strtolower($task->priority) }} ml-2 flex-shrink-0">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 mb-3">
                            <i class="fas fa-folder text-gray-400 text-xs"></i>
                            <span class="text-xs text-gray-600 truncate">{{ $task->project->name }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-purple-600 font-medium">Review</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($task->assignedUser && $task->assignedUser->avatar)
                                    <div class="w-6 h-6 rounded-full overflow-hidden border-2 border-gray-200">
                                        <img src="{{ $task->assignedUser->avatar }}"
                                             alt="{{ $task->assignedUser->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @elseif($task->assignedUser)
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gradient-to-r from-blue-500 to-cyan-500">
                                        <span class="text-xs font-semibold text-white">
                                            {{ strtoupper(Str::substr($task->assignedUser->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gray-200">
                                        <i class="fas fa-user text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                                @if(auth()->id() === $task->assigned_to)
                                <button type="button" onclick="event.stopPropagation(); updateTaskStatus({{ $task->id }}, 'complete')"
                                        class="action-btn bg-green-500 hover:bg-green-600" title="Mark Complete">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-eye text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">No tasks under review</p>
                        <p class="text-xs text-gray-400">Completed tasks will appear here</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Completed Column -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Completed</h2>
                    </div>
                    <span class="bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $completeTasks->count() }}</span>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                    @forelse($completeTasks as $task)
                    <div class="task-card group bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md hover:bg-white transition-all duration-200 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $task->id) }}'">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $task->title }}</h3>
                            <span class="priority-badge priority-{{ strtolower($task->priority) }} ml-2 flex-shrink-0">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 mb-3">
                            <i class="fas fa-folder text-gray-400 text-xs"></i>
                            <span class="text-xs text-gray-600 truncate">{{ $task->project->name }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                    <span class="text-xs text-green-600 font-medium">Complete</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($task->assignedUser && $task->assignedUser->avatar)
                                    <div class="w-6 h-6 rounded-full overflow-hidden border-2 border-gray-200">
                                        <img src="{{ $task->assignedUser->avatar }}"
                                             alt="{{ $task->assignedUser->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @elseif($task->assignedUser)
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gradient-to-r from-blue-500 to-cyan-500">
                                        <span class="text-xs font-semibold text-white">
                                            {{ strtoupper(Str::substr($task->assignedUser->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gray-200">
                                        <i class="fas fa-user text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-trophy text-green-600 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-check-circle text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">No completed tasks</p>
                        <p class="text-xs text-gray-400">Finished tasks will appear here</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Priority Badges */
.priority-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.priority-high {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
}

.priority-medium {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
}

.priority-low {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(107, 114, 128, 0.2);
}

/* Task Cards */
.task-card {
    position: relative;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.task-card:hover {
    transform: translateY(-1px);
    border-color: #e5e7eb;
}

.task-card:hover .priority-badge {
    transform: scale(1.05);
}

/* Action Buttons */
.action-btn {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    items-center: center;
    justify-content: center;
    color: white;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.action-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    opacity: 0.8;
}

.empty-state i {
    display: block;
    margin: 0 auto 0.75rem;
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
    border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
}

/* Line Clamp Utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive Design */
@media (max-width: 768px) {
    .grid.grid-cols-1.md\\:grid-cols-2.xl\\:grid-cols-4 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1rem;
    }

    .max-h-96 {
        max-height: 20rem;
    }

    .task-card {
        padding: 1rem;
    }

    .priority-badge {
        font-size: 9px;
        padding: 1px 6px;
    }
}

@media (min-width: 769px) and (max-width: 1279px) {
    .grid.grid-cols-1.md\\:grid-cols-2.xl\\:grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

/* Animation for pulse effects */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<script>
function updateTaskStatus(taskId, status) {
    console.log("Updating task:", taskId, "to status:", status);

    // Show loading state
    const button = event.target.closest('button');
    if (button) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';
    }

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
                // Show success feedback
                const card = button.closest('.task-card');
                if (card) {
                    card.style.transform = 'scale(0.95)';
                    card.style.opacity = '0.5';
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            } else {
                alert('Status update failed.');
                // Reset button state
                if (button) {
                    button.disabled = false;
                    restoreButtonIcon(button, status);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the task status.');
            // Reset button state
            if (button) {
                button.disabled = false;
                restoreButtonIcon(button, status);
            }
        });
    } else {
        // Reset button state if cancelled
        if (button) {
            button.disabled = false;
            restoreButtonIcon(button, status);
        }
    }
}

function restoreButtonIcon(button, status) {
    const icons = {
        'in_progress': 'fa-play',
        'review': 'fa-eye',
        'complete': 'fa-check'
    };
    button.innerHTML = `<i class="fas ${icons[status]} text-xs"></i>`;
}

// Add smooth transitions for task movements
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to task cards
    const taskCards = document.querySelectorAll('.task-card');
    taskCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection
