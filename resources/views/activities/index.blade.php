@extends('layouts.app')

@section('title', 'Employee Stats')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Employee Statistics</h1>
        <p class="text-gray-600">Monitor team performance and activity</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <form method="GET" action="{{ route('activities.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex items-center space-x-3">
                <label class="text-sm font-semibold text-gray-700">Filter Priority:</label>
                <select name="priority" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50">
                    <option value="">All Priorities</option>
                    @foreach($priorities as $prio)
                        <option value="{{ $prio }}" {{ $priority == $prio ? 'selected' : '' }}>
                            {{ ucfirst($prio) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-all hover:shadow-md">
                    Apply Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Employee Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach($users as $user)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <!-- Employee Header -->
            <div class="flex items-center space-x-4 mb-6">
                <div class="relative">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 overflow-hidden flex items-center justify-center">
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="text-center">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="text-xl font-bold text-gray-900">{{ $user->projects_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500 mt-1">Projects</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <div class="text-xl font-bold text-green-600">{{ $user->tasks_done_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500 mt-1">Tasks Done</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="text-xl font-bold text-blue-600">{{ $user->leave_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500 mt-1">Leave Days</div>
                    </div>
                </div>
            </div>

            <!-- Work Hours Progress -->
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-700">Work Hours</span>
                    <span class="text-sm font-bold text-gray-900">
                        {{ $user->work_hours_percent ?? 0 }}%
                        <span class="text-xs text-gray-500 ml-2">({{ $user->work_hours_total ?? 0 }} / 40 jam)</span>
                        @if($user->is_overwork ?? false)
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Over Work</span>
                        @endif
                    </span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                         style="width: {{ min($user->work_hours_percent ?? 0, 100) }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Activities Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Recent Activities</h2>
            <p class="text-gray-600">Latest team activities and updates</p>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($activities as $activity)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $activity->icon ?? 'fa-tasks' }} text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">
                                    {{ $activity->user->name ?? 'Unknown User' }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $activity->formatted_action ?? $activity->action }}
                                </p>
                                <div class="mt-2 text-sm text-gray-600">
                                    {!! $activity->description !!}
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-xs text-gray-500">
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>
                                @if($activity->project)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-2
                                        @if($activity->project->status == 'active') bg-green-100 text-green-700
                                        @elseif($activity->project->status == 'completed') bg-purple-100 text-purple-700
                                        @elseif($activity->project->status == 'on_hold') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ ucfirst($activity->project->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No activities found</h3>
                <p class="text-gray-600">Activities will appear here once team members start working.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
