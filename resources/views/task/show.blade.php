@extends('layouts.app')

@section('title', 'Task Detail')

@section('content')
<div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow-lg p-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Task Detail</h1>
        <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:underline">&larr; Back to Tasks</a>
    </div>
    <div class="space-y-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h2>
            <span class="priority-tag priority-{{ strtolower($task->priority) }} ml-2">{{ ucfirst($task->priority) }}</span>
        </div>
        <div class="text-gray-600">{{ $task->description }}</div>
        <div class="flex flex-wrap gap-4 mt-4">
            <div>
                <span class="font-semibold text-gray-700">Project:</span>
                <span>{{ $task->project->name ?? '-' }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Assigned To:</span>
                <span class="inline-flex items-center">
                    <img src="{{ $task->assignedUser->avatar ?? 'https://via.placeholder.com/24' }}" alt="{{ $task->assignedUser->name }}" class="w-6 h-6 rounded-full border-2 border-gray-200 mr-1">
                    {{ $task->assignedUser->name ?? '-' }}
                </span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Created By:</span>
                <span>{{ $task->createdBy->name ?? '-' }}</span>
            </div>
        </div>
        <div class="flex flex-wrap gap-4">
            <div>
                <span class="font-semibold text-gray-700">Status:</span>
                <span>{{ ucfirst($task->status) }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Work Hours:</span>
                <span>{{ $task->work_hours }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Due Date:</span>
                <span>{{ $task->due_date ? $task->due_date->format('M j, Y') : '-' }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Start Date:</span>
                <span>{{ $task->start_date ? $task->start_date->format('M j, Y') : '-' }}</span>
            </div>
        </div>
    </div>
</div>
<style>
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
</style>
@endsection
