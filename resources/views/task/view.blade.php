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
                        <i class="fas fa-list text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">All Tasks</h1>
                        <p class="text-sm text-gray-500">Complete overview of all project tasks</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('project.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-project-diagram mr-2"></i>
                        Projects
                    </a>
                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white text-sm font-medium rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-200 shadow-sm">
                        <i class="fas fa-th-large mr-2"></i>
                        Board View
                    </a>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-medium rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Create Task
                    </a>
                    <button onclick="openTransferModal()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-sm">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Transfer Task
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200" data-aos="fade-up">
        <div class="p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Search Bar -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="searchInput" placeholder="Search tasks, projects, or assignees..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterTasks('all')" class="filter-btn active" data-filter="all">
                        <i class="fas fa-list mr-1"></i>
                        All Tasks
                    </button>
                    <button onclick="filterTasks('todo')" class="filter-btn" data-filter="todo">
                        <i class="fas fa-circle text-red-500 mr-1"></i>
                        To Do
                    </button>
                    <button onclick="filterTasks('in_progress')" class="filter-btn" data-filter="in_progress">
                        <i class="fas fa-circle text-orange-500 mr-1"></i>
                        In Progress
                    </button>
                    <button onclick="filterTasks('review')" class="filter-btn" data-filter="review">
                        <i class="fas fa-circle text-purple-500 mr-1"></i>
                        Review
                    </button>
                    <button onclick="filterTasks('complete')" class="filter-btn" data-filter="complete">
                        <i class="fas fa-circle text-green-500 mr-1"></i>
                        Complete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200" data-aos="fade-up">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-table text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Tasks Overview</h2>
                        <p class="text-sm text-gray-500">Total: <span id="taskCount">{{ $tasks->count() }}</span> tasks</p>
                    </div>
                </div>

                <!-- View Options -->
                <div class="flex items-center space-x-2">
                    <button onclick="toggleCompactView()" id="viewToggle" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors" title="Toggle compact view">
                        <i class="fas fa-compress-alt"></i>
                    </button>
                    <button onclick="exportTasks()" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors" title="Export tasks">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="tasksTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(0)">
                            <div class="flex items-center space-x-1">
                                <span>#</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(1)">
                            <div class="flex items-center space-x-1">
                                <span>Task Name</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(2)">
                            <div class="flex items-center space-x-1">
                                <span>Project</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(3)">
                            <div class="flex items-center space-x-1">
                                <span>Assigned To</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(4)">
                            <div class="flex items-center space-x-1">
                                <span>Priority</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(5)">
                            <div class="flex items-center space-x-1">
                                <span>Status</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(6)">
                            <div class="flex items-center space-x-1">
                                <span>Created</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @foreach($tasks as $index => $task)
                    <tr class="hover:bg-gray-50 transition-colors task-row" data-status="{{ $task->status }}" data-priority="{{ strtolower($task->priority) }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-medium">
                                    {{ $task->id }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 hover:text-blue-600 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $task->id) }}'">
                                        {{ $task->title }}
                                    </div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($task->description ?? 'No description', 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-project-diagram text-indigo-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-900">{{ $task->project->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                @foreach ($task->assignedUsers as $user)
                                    <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-gray-200 inline-block mr-1">
                                        <img src="{{ $user->avatar ?? asset('logo.png') }}"
                                             alt="{{ $user->name ?? 'Unassigned' }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $task->assignedUsers->pluck('name')->join(', ') ?: 'Unassigned' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $task->assignedUsers->pluck('divisi')->filter()->join(', ') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="priority-badge priority-{{ strtolower($task->priority) }}">
                                <i class="fas fa-flag mr-1"></i>
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusConfig = [
                                    'complete' => ['color' => 'bg-green-100 text-green-800 border-green-200', 'icon' => 'fa-check-circle'],
                                    'in_progress' => ['color' => 'bg-orange-100 text-orange-800 border-orange-200', 'icon' => 'fa-clock'],
                                    'review' => ['color' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'fa-eye'],
                                    'todo' => ['color' => 'bg-red-100 text-red-800 border-red-200', 'icon' => 'fa-list'],
                                ];
                                $config = $statusConfig[$task->status] ?? $statusConfig['todo'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $config['color'] }}">
                                <i class="fas {{ $config['icon'] }} mr-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                                <span>{{ $task->created_at ? $task->created_at->format('M j, Y') : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button onclick="window.location.href='{{ route('tasks.show', $task->id) }}'" class="action-btn bg-blue-500 hover:bg-blue-600" title="View Task">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(auth()->user()->role === 'admin')
                                <button onclick="editTask({{ $task->id }})" class="action-btn bg-green-500 hover:bg-green-600" title="Edit Task">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteTask({{ $task->id }})" class="action-btn bg-red-500 hover:bg-red-600" title="Delete Task">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
            <p class="text-gray-500 text-sm">Try adjusting your search or filter criteria</p>
        </div>
    </div>

    <!-- Task Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" data-aos="fade-up">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-list text-red-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900" id="todoCount">{{ $tasks->where('status', 'todo')->count() }}</div>
                    <div class="text-xs text-gray-500">To Do</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-orange-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900" id="inProgressCount">{{ $tasks->where('status', 'in_progress')->count() }}</div>
                    <div class="text-xs text-gray-500">In Progress</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-eye text-purple-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900" id="reviewCount">{{ $tasks->where('status', 'review')->count() }}</div>
                    <div class="text-xs text-gray-500">Review</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-green-600 text-sm"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900" id="completeCount">{{ $tasks->where('status', 'complete')->count() }}</div>
                    <div class="text-xs text-gray-500">Complete</div>
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
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
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

/* Filter Buttons */
.filter-btn {
    display: inline-flex;
    items-center: center;
    padding: 6px 12px;
    text-sm;
    font-medium;
    border: 1px solid #d1d5db;
    rounded: 6px;
    background: white;
    color: #374151;
    transition: all 0.2s;
    cursor: pointer;
}

.filter-btn:hover {
    background-color: #f9fafb;
    border-color: #9ca3af;
}

.filter-btn.active {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border-color: #3b82f6;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

/* Action Buttons */
.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    items-center: center;
    justify-content: center;
    color: white;
    transition: all 0.2s;
    cursor: pointer;
    border: none;
}

.action-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Table Enhancements */
.task-row:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

/* Compact View */
.compact-view .task-row td {
    padding: 8px 16px;
}

.compact-view .priority-badge {
    padding: 2px 8px;
    font-size: 10px;
}

.compact-view .action-btn {
    width: 28px;
    height: 28px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hidden-mobile {
        display: none;
    }

    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .py-4 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
}

/* Loading Animation */
.loading-row {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 37%, #f0f0f0 63%);
    background-size: 400% 100%;
    animation: shimmer 1.5s ease-in-out infinite;
}

@keyframes shimmer {
    0% { background-position: 100% 0; }
    100% { background-position: -100% 0; }
}
</style>

<script>
let currentSort = { column: 0, ascending: true };
let currentFilter = 'all';

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    filterAndSearchTasks(searchTerm, currentFilter);
});

// Filter tasks by status
function filterTasks(status) {
    currentFilter = status;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();

    // Update filter button states
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-filter="${status}"]`).classList.add('active');

    filterAndSearchTasks(searchTerm, status);
}

// Combined filter and search function
function filterAndSearchTasks(searchTerm, status) {
    const rows = document.querySelectorAll('.task-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const taskName = row.cells[1].textContent.toLowerCase();
        const projectName = row.cells[2].textContent.toLowerCase();
        const assigneeName = row.cells[3].textContent.toLowerCase();
        const taskStatus = row.dataset.status;

        const matchesSearch = taskName.includes(searchTerm) ||
                            projectName.includes(searchTerm) ||
                            assigneeName.includes(searchTerm);
        const matchesFilter = status === 'all' || taskStatus === status;

        if (matchesSearch && matchesFilter) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Update task count
    document.getElementById('taskCount').textContent = visibleCount;

    // Show/hide empty state
    const emptyState = document.getElementById('emptyState');
    const tableBody = document.getElementById('tableBody');

    if (visibleCount === 0) {
        emptyState.classList.remove('hidden');
        tableBody.style.display = 'none';
    } else {
        emptyState.classList.add('hidden');
        tableBody.style.display = '';
    }
}

// Sort table functionality
function sortTable(columnIndex) {
    const table = document.getElementById('tasksTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');

    // Toggle sort direction if same column
    if (currentSort.column === columnIndex) {
        currentSort.ascending = !currentSort.ascending;
    } else {
        currentSort.column = columnIndex;
        currentSort.ascending = true;
    }

    rows.sort((a, b) => {
        let aVal = a.cells[columnIndex].textContent.trim();
        let bVal = b.cells[columnIndex].textContent.trim();

        // Handle numeric values (like ID)
        if (columnIndex === 0) {
            aVal = parseInt(aVal);
            bVal = parseInt(bVal);
        }

        // Handle dates
        if (columnIndex === 6) {
            aVal = new Date(aVal);
            bVal = new Date(bVal);
        }

        if (aVal < bVal) return currentSort.ascending ? -1 : 1;
        if (aVal > bVal) return currentSort.ascending ? 1 : -1;
        return 0;
    });

    // Reattach sorted rows
    rows.forEach(row => tbody.appendChild(row));

    // Update sort indicators
    updateSortIndicators(columnIndex);
}

// Update sort direction indicators
function updateSortIndicators(activeColumn) {
    const headers = document.querySelectorAll('th i.fa-sort, th i.fa-sort-up, th i.fa-sort-down');
    headers.forEach((icon, index) => {
        if (index === activeColumn) {
            icon.className = currentSort.ascending ? 'fas fa-sort-up text-blue-500' : 'fas fa-sort-down text-blue-500';
        } else {
            icon.className = 'fas fa-sort text-gray-400';
        }
    });
}

// Toggle compact view
function toggleCompactView() {
    const table = document.getElementById('tasksTable');
    const button = document.getElementById('viewToggle');

    table.classList.toggle('compact-view');

    if (table.classList.contains('compact-view')) {
        button.innerHTML = '<i class="fas fa-expand-alt"></i>';
        button.title = 'Toggle expanded view';
    } else {
        button.innerHTML = '<i class="fas fa-compress-alt"></i>';
        button.title = 'Toggle compact view';
    }
}

// Export tasks functionality
function exportTasks() {
    // This would typically integrate with a backend export function
    alert('Export functionality would be implemented here');
}

// Task management functions
function editTask(taskId) {
    window.location.href = `/tasks/${taskId}/edit`;
}

function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        // Implementation for task deletion
        fetch(`/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to delete task');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the task');
        });
    }
}

function openTransferModal() {
    alert('Transfer task functionality would be implemented here');
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set initial task count
    const totalTasks = document.querySelectorAll('.task-row').length;
    document.getElementById('taskCount').textContent = totalTasks;
});
</script>
@endsection
