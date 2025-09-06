@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex justify-between items-center" data-aos="fade-down">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Project Management</h1>
            <p class="text-sm text-gray-600">Manage your projects efficiently</p>
        </div>
        <div class="flex space-x-3">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('project.create') }}" class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 flex items-center shadow-md text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Create Project</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mb-4">
        <div class="bg-white shadow-sm rounded-lg p-3 flex items-center gap-2 inline-flex border">
            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-600 font-medium text-sm">Filter</span>
        </div>
    </div>

    <!-- Project Table Container -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border" data-aos="fade-up">
        <!-- Table Header -->
        <div class="bg-gray-50 px-4 py-3 border-b">
            <div class="grid grid-cols-12 gap-3 items-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                <div class="col-span-1">#</div>
                <div class="col-span-3">Project Name</div>
                <div class="col-span-2 text-center">Start Date</div>
                <div class="col-span-2 text-center">Deadline</div>
                <div class="col-span-2 text-center">Director</div>
                <div class="col-span-1 text-center">Priority</div>
                <div class="col-span-1 text-center">Status</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-100">
            @forelse($projects as $index => $project)
            <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-150 project-row">
                <div class="grid grid-cols-12 gap-3 items-center">
                    <!-- Number -->
                    <div class="col-span-1">
                        <span class="text-gray-800 font-medium text-sm">{{ $index + 1 }}</span>
                    </div>

                    <!-- Project Name -->
                    <div class="col-span-3">
                        <h3 class="text-gray-900 font-medium text-sm truncate">{{ $project->name }}</h3>
                    </div>

                    <!-- Start Date -->
                    <div class="col-span-2 text-center">
                        <span class="text-gray-700 text-sm">{{ \Carbon\Carbon::parse($project->start_date)->format('M j, Y') }}</span>
                    </div>

                    <!-- Deadline -->
                    <div class="col-span-2 text-center">
                        <span class="text-gray-700 text-sm">{{ \Carbon\Carbon::parse($project->end_date)->format('M j, Y') }}</span>
                    </div>

                    <!-- Project Director -->
                    <div class="col-span-2 text-center">
                        <span class="text-gray-700 text-sm truncate">{{ $project->manager->name ?? 'Unassigned' }}</span>
                    </div>

                    <!-- Priority Level -->
                    <div class="col-span-1 text-center">
                        @php
                            $totalTasks = $project->tasks->count();
                            $completedTasks = $project->tasks->where('status', 'completed')->count();
                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                            if ($progress >= 80) {
                                $levelClass = 'bg-red-100 text-red-700 border-red-200';
                                $levelText = 'High';
                            } elseif ($progress >= 50) {
                                $levelClass = 'bg-orange-100 text-orange-700 border-orange-200';
                                $levelText = 'Med';
                            } else {
                                $levelClass = 'bg-green-100 text-green-700 border-green-200';
                                $levelText = 'Low';
                            }
                        @endphp
                        <span class="px-2 py-1 rounded-md text-xs font-medium border {{ $levelClass }}">
                            {{ $levelText }}
                        </span>
                    </div>

                    <!-- Status -->
                    <div class="col-span-1 text-center">
                        @php
                            switch($project->status) {
                                case 'active':
                                    $statusClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                    $statusText = 'Running';
                                    break;
                                case 'completed':
                                    $statusClass = 'bg-green-100 text-green-700 border-green-200';
                                    $statusText = 'Done';
                                    break;
                                case 'on-hold':
                                    $statusClass = 'bg-orange-100 text-orange-700 border-orange-200';
                                    $statusText = 'Hold';
                                    break;
                                case 'pending':
                                    $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
                                    $statusText = 'Todo';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
                                    $statusText = 'Unknown';
                            }
                        @endphp
                        <span class="px-2 py-1 rounded-md text-xs font-medium border {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center">
                <div class="text-gray-300 mb-3">
                    <i class="fas fa-folder-open text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No projects found</h3>
                <p class="text-gray-500 text-sm mb-4">Get started by creating your first project</p>
                <a href="{{ route('project.create') }}" class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-cyan-600 hover:to-blue-600 transition-all duration-200 inline-flex items-center text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Project
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Enhanced project row styles */
.project-row {
    transition: all 0.15s ease;
}

.project-row:hover {
    background-color: #f8fafc;
}

/* Responsive adjustments for mobile */
@media (max-width: 768px) {
    .grid-cols-12 {
        grid-template-columns: 0.5fr 2fr 1fr 1fr 1.5fr 0.8fr 0.8fr;
        gap: 0.5rem;
    }

    .col-span-1 { grid-column: span 1; }
    .col-span-2 { grid-column: span 1; }
    .col-span-3 { grid-column: span 1; }

    .truncate {
        max-width: 100px;
    }

    .text-sm {
        font-size: 0.75rem;
    }

    .text-xs {
        font-size: 0.625rem;
    }
}

/* Status and priority badge improvements */
.status-badge, .priority-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 60px;
}

/* Smooth animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.project-row {
    animation: slideIn 0.3s ease-out;
}

/* Custom scrollbar for overflow content */
.truncate:hover {
    overflow: visible;
    white-space: normal;
    position: relative;
    z-index: 10;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add staggered animation to rows
    const rows = document.querySelectorAll('.project-row');
    rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 50}ms`;
    });

    // Add click functionality to rows (optional)
    rows.forEach(row => {
        row.addEventListener('click', function() {
            // Add any row click functionality here
            console.log('Row clicked');
        });
    });
});
</script>
@endsection
