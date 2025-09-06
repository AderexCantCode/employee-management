@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="modal-card">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Task</h4>
                    <a href="{{ route('tasks.index') }}" class="close-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </a>
                </div>

                <div class="modal-body">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title" class="form-label">Task</label>
                            <input type="text"
                                   class="form-input @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   placeholder="Task name..."
                                   value="{{ old('title', $task->title) }}">
                            @error('title')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-input @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="2"
                                      placeholder="Task description...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-input @error('project_id') is-invalid @enderror"
                                    id="project_id"
                                    name="project_id">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                            {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="assigned_users" class="form-label">Assigned To</label>
                            <select class="form-input @error('assigned_users') is-invalid @enderror" id="assigned_users" name="assigned_users[]" multiple required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ (collect(old('assigned_users', $task->assignedUsers->pluck('id')->toArray()))->contains($user->id)) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_users')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date"
                                       class="form-input @error('start_date') is-invalid @enderror"
                                       id="start_date"
                                       name="start_date"
                                       value="{{ old('start_date', $task->start_date ? $task->start_date->format('Y-m-d') : '') }}">
                                @error('start_date')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date"
                                       class="form-input @error('due_date') is-invalid @enderror"
                                       id="due_date"
                                       name="due_date"
                                       value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
                                @error('due_date')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Task Level</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="priority" value="low"
                                           {{ old('priority', $task->priority) == 'low' ? 'checked' : '' }}>
                                    <span class="radio-custom"></span>
                                    Low
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="priority" value="medium"
                                           {{ old('priority', $task->priority) == 'medium' ? 'checked' : '' }}>
                                    <span class="radio-custom"></span>
                                    Medium
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="priority" value="high"
                                           {{ old('priority', $task->priority) == 'high' ? 'checked' : '' }}>
                                    <span class="radio-custom"></span>
                                    High
                                </label>
                            </div>
                            @error('priority')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="submit-btn">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
* {
    box-sizing: border-box;
}

body {
    background-color: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.modal-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
    max-width: 480px;
    margin: 0 auto;
}

.modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
}

.modal-title {
    font-size: 16px;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    text-decoration: none;
    transition: color 0.15s ease;
}

.close-btn:hover {
    color: #495057;
}

.modal-body {
    padding: 20px;
}

.form-group {
    margin-bottom: 16px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
}

.form-input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    background-color: #f9fafb;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    background-color: #ffffff;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}

.form-input.is-invalid {
    border-color: #ef4444;
}

.error-message {
    color: #ef4444;
    font-size: 11px;
    margin-top: 3px;
}

.radio-group {
    display: flex;
    gap: 18px;
    margin-top: 6px;
}

.radio-option {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 13px;
    color: #374151;
    font-weight: 400;
}

.radio-option input[type="radio"] {
    display: none;
}

.radio-custom {
    width: 18px;
    height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    margin-right: 6px;
    position: relative;
    transition: border-color 0.15s ease;
}

.radio-option input[type="radio"]:checked + .radio-custom {
    border-color: #f59e0b;
}

.radio-option input[type="radio"]:checked + .radio-custom::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background-color: #f59e0b;
    border-radius: 50%;
}

.submit-btn {
    width: 100%;
    padding: 12px;
    background-color: #1f2937;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.15s ease;
    margin-top: 4px;
}

.submit-btn:hover {
    background-color: #111827;
}

@media (max-width: 768px) {
    .modal-card {
        margin: 0 12px;
        max-width: none;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .radio-group {
        flex-direction: column;
        gap: 8px;
    }

    .modal-header {
        padding: 14px 16px;
    }

    .modal-body {
        padding: 16px;
    }
}
</style>
@endsection
