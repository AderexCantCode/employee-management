@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Project Management</h1>
            <p class="text-gray-600">Manage your projects efficiently</p>
        </div>
        <div class="flex space-x-3">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('project.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors flex items-center shadow-md">
                    <i class="fas fa-plus mr-2"></i> Create Project
                </a>
            @endif
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-2xl shadow-lg p-6" data-aos="fade-up">
        <div class="flex flex-wrap gap-2 mb-6">
            <button onclick="filterProjects('all')" class="filter-btn active px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-indigo-600 text-white">
                <i class="fas fa-list mr-2"></i>All Projects
                <span class="ml-2 bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs" id="count-all">{{ $projects->count() }}</span>
            </button>
            <button onclick="filterProjects('pending')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700">
                <i class="fas fa-clock mr-2"></i>Pending
                <span class="ml-2 bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs" id="count-pending">{{ $projects->where('status', 'pending')->count() }}</span>
            </button>
            <button onclick="filterProjects('active')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-green-50 hover:text-green-700">
                <i class="fas fa-play-circle mr-2"></i>Active
                <span class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs" id="count-active">{{ $projects->where('status', 'active')->count() }}</span>
            </button>
            <button onclick="filterProjects('completed')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                <i class="fas fa-check-circle mr-2"></i>Completed
                <span class="ml-2 bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs" id="count-completed">{{ $projects->where('status', 'completed')->count() }}</span>
            </button>
            <button onclick="filterProjects('on-hold')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-700">
                <i class="fas fa-pause-circle mr-2"></i>On Hold
                <span class="ml-2 bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs" id="count-on-hold">{{ $projects->where('status', 'on-hold')->count() }}</span>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Search projects..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <!-- Project Grid -->
        <div id="projectGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
            <div class="project-card bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:border-indigo-200" data-status="{{ $project->status }}">
                <!-- Project Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $project->name }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($project->description ?? 'No description available', 100) }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <span class="
                            px-3 py-1 rounded-full text-xs font-semibold
                            @if($project->status == 'active') bg-green-100 text-green-800
                            @elseif($project->status == 'completed') bg-blue-100 text-blue-800
                            @elseif($project->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif
                        ">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="space-y-3 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-user w-4 mr-2"></i>
                        <span>{{ $project->manager->name ?? 'No manager assigned' }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar w-4 mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-tasks w-4 mr-2"></i>
                        <span>{{ $project->tasks->count() ?? 0 }} Tasks</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                @php
                    $totalTasks = $project->tasks->count();
                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                    $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                @endphp
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress</span>
                        <span class="text-sm text-gray-600">{{ round($progress) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <div class="flex space-x-3">
                        <a href="{{ route('project.show', $project->id) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors p-2 rounded-lg hover:bg-indigo-50" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('project.edit', $project->id) }}" class="text-yellow-600 hover:text-yellow-800 transition-colors p-2 rounded-lg hover:bg-yellow-50" title="Edit Project">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('project.destroy', $project->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-2 rounded-lg hover:bg-red-50" title="Delete Project">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">
                        Updated {{ \Carbon\Carbon::parse($project->updated_at)->diffForHumans() }}
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-folder-open text-6xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No projects found</h3>
                <p class="text-gray-600 mb-6">Get started by creating your first project</p>
                <a href="{{ route('project.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Create Your First Project
                </a>
            </div>
            @endforelse
        </div>


        <div id="noResults" class="hidden text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-search text-6xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No projects found</h3>
            <p class="text-gray-600">Try adjusting your search or filter criteria</p>
        </div>
    </div>
</div>

<script>
let currentFilter = 'all';

function filterProjects(status) {
    currentFilter = status;
    const cards = document.querySelectorAll('.project-card');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const noResults = document.getElementById('noResults');
    let visibleCount = 0;

    // Update filter button states
    filterBtns.forEach(btn => {
        btn.classList.remove('active', 'bg-indigo-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });

    // Set active button
    const activeBtn = document.querySelector(`[onclick="filterProjects('${status}')"]`);
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
        activeBtn.classList.add('active', 'bg-indigo-600', 'text-white');
    }

    // Filter cards
    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        if (status === 'all' || cardStatus === status) {
            card.style.display = 'block';
            card.classList.add('fade-in');
            visibleCount++;
        } else {
            card.style.display = 'none';
            card.classList.remove('fade-in');
        }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }

    // Apply search filter if there's a search term
    const searchTerm = document.getElementById('searchInput').value;
    if (searchTerm) {
        searchProjects(searchTerm);
    }
}

function searchProjects(searchTerm) {
    const cards = document.querySelectorAll('.project-card');
    const noResults = document.getElementById('noResults');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        const projectName = card.querySelector('h3').textContent.toLowerCase();
        const projectDescription = card.querySelector('p').textContent.toLowerCase();
        const managerName = card.querySelector('.fas.fa-user').nextElementSibling.textContent.toLowerCase();

        const matchesSearch = projectName.includes(searchTerm.toLowerCase()) ||
                            projectDescription.includes(searchTerm.toLowerCase()) ||
                            managerName.includes(searchTerm.toLowerCase());

        const matchesFilter = currentFilter === 'all' || cardStatus === currentFilter;

        if (matchesSearch && matchesFilter) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
}

// Search input event listener
document.getElementById('searchInput').addEventListener('input', function() {
    searchProjects(this.value);
});

// Add fade-in animation
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .project-card {
            transition: all 0.3s ease;
        }

        .project-card:hover {
            transform: translateY(-2px);
        }

        .filter-btn {
            transition: all 0.2s ease;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
