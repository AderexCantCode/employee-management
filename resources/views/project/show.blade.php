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
                <div class="mb-2"><span class="font-semibold">Project Director:</span> {{ optional($sdm && $sdm->project_director ? \App\Models\User::find($sdm->project_director) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Backend Engineer:</span> {{ optional($sdm && $sdm->engineer_backend ? \App\Models\User::find($sdm->engineer_backend) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Frontend Engineer:</span> {{ optional($sdm && $sdm->engineer_frontend ? \App\Models\User::find($sdm->engineer_frontend) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Engineer Android:</span> {{ optional($sdm && $sdm->engineer_android ? \App\Models\User::find($sdm->engineer_android) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Engineer iOS:</span> {{ optional($sdm && $sdm->engineer_ios ? \App\Models\User::find($sdm->engineer_ios) : null)?->name ?? '-' }}</div>
            </div>
            <div>
                <div class="mb-2"><span class="font-semibold">UI/UX Designer:</span> {{ optional($sdm && $sdm->uiux ? \App\Models\User::find($sdm->uiux) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Analyst:</span> {{ optional($sdm && $sdm->analis ? \App\Models\User::find($sdm->analis) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Content Creator:</span> {{ optional($sdm && $sdm->content_creator ? \App\Models\User::find($sdm->content_creator) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Copywriter:</span> {{ optional($sdm && $sdm->copywriter ? \App\Models\User::find($sdm->copywriter) : null)?->name ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Tester:</span> {{ optional($sdm && $sdm->tester ? \App\Models\User::find($sdm->tester) : null)?->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-semibold mb-4">Tasks</h2>
        <!-- Transfer Task (custom UI button) -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('task.transfer.form', ['project' => $project->id]) }}" class="bg-[#111111] text-white px-6 py-2 rounded-lg text-lg font-medium shadow hover:bg-[#222] transition">Transfer Task</a>
        </div>
        @if($project->tasks->count())
        <ul class="divide-y">
            @foreach($project->tasks as $task)
            <li class="py-2 flex justify-between items-center">
                <div>
                    <div class="font-semibold">{{ $task->title }}</div>
                    <div class="text-sm text-gray-500">{{ $task->description }}</div>
                </div>
                <div class="text-xs text-gray-700">Assigned to: {{ $task->assignedUser->name ?? '-' }}</div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="text-gray-500">No tasks for this project.</div>
        @endif
    </div>
</div>
@endsection
