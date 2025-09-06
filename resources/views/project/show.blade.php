@extends('layouts.app')

@section('title', 'Project Detail')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-lg shadow p-8 mb-8">
        <h1 class="text-3xl font-bold mb-2">{{ $project->name }}</h1>
        <div class="text-gray-500 mb-4">Status: <span class="font-semibold">{{ ucfirst($project->status) }}</span></div>
        <div class="mb-2"><span class="font-semibold">Manager:</span> {{ $project->manager->name ?? '-' }}</div>
        <div class="mb-2"><span class="font-semibold">Start Date:</span> {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</div>
        <div class="mb-2"><span class="font-semibold">End Date:</span> {{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}</div>
        <div class="mb-2"><span class="font-semibold">Level:</span> {{ ucfirst($project->level ?? '-') }}</div>
        <div class="mb-4"><span class="font-semibold">Description:</span> {{ $project->description }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4">SDM (Team Members)</h2>
        @php $sdm = $project->sdm; @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="mb-2"><span class="font-semibold">Project Director:</span> {{ $sdm?->projectDirector?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Backend Dev:</span> {{ $sdm?->backendDev?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Frontend Dev:</span> {{ $sdm?->frontendDev?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Android Dev:</span> {{ $sdm?->engineerAndroid?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">IOS Dev:</span> {{ $sdm?->engineerIos?->name ?? '-' }}</div>
            </div>
            <div>
                <div class="mb-2"><span class="font-semibold">UI UX:</span> {{ $sdm?->uiux?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Analis:</span> {{ $sdm?->analis?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Content Creator:</span> {{ $sdm?->contentCreator?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Copywriter:</span> {{ $sdm?->copywriter?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Tester:</span> {{ $sdm?->tester?->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-semibold mb-4">Tasks</h2>
        @if($project->tasks->count())
        <ul class="divide-y">
            @foreach($project->tasks as $task)
            <li class="py-2 flex justify-between items-center">
                <div>
                    <div class="font-semibold">{{ $task->title }}</div>
                    <div class="text-sm text-gray-500">{{ $task->description }}</div>
                </div>
                <div class="text-xs text-gray-700">Assigned to: {{ $task->assignedUsers->pluck('name')->join(', ') ?: '-' }}</div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="text-gray-500">No tasks for this project.</div>
        @endif
    </div>
</div>
@endsection
