<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $todoTasks = Task::where('status', 'todo')->with(['project', 'assignedUser'])->get();
        $inProgressTasks = Task::where('status', 'in_progress')->with(['project', 'assignedUser'])->get();
        $reviewTasks = Task::where('status', 'review')->with(['project', 'assignedUser'])->get();
        $completeTasks = Task::where('status', 'complete')->with(['project', 'assignedUser'])->get();

        return view('task.index', compact(
            'todoTasks', 'inProgressTasks', 'reviewTasks', 'completeTasks'
        ));
    }

    public function create(Request $request)
    {
        $projects = Project::all();
        $users = collect();
        $selectedProject = null;

        if ($request->has('project_id')) {
            $selectedProject = Project::with('sdm')->find($request->project_id);
            if ($selectedProject && $selectedProject->sdm) {
                $userIds = collect([
                    $selectedProject->sdm->project_director,
                    $selectedProject->sdm->engineer_web,
                    $selectedProject->sdm->engineer_android,
                    $selectedProject->sdm->engineer_ios,
                    $selectedProject->sdm->uiux,
                    $selectedProject->sdm->analis,
                    $selectedProject->sdm->content_creator,
                    $selectedProject->sdm->copywriter,
                    $selectedProject->sdm->tester,
                ])->filter()->unique();
                $users = User::whereIn('id', $userIds)->get();
            }
        } else {
            $users = User::all();
        }

        return view('task.create', compact('projects', 'users', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date|after_or_equal:today',
            'start_date' => 'nullable|date|before_or_equal:due_date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'due_date' => $request->due_date,
            'start_date' => $request->start_date,
            'priority' => $request->priority,
            'status' => 'todo', // Set default status
            'work_hours' => Task::getWorkHoursByPriority($request->priority), // set otomatis
        ]);

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'created_task',
            'description' => 'Created task: ' . $task->title,
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load(['project', 'assignedUser', 'createdBy']);
        return view('task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();

        return view('task.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date|after_or_equal:today',
            'start_date' => 'nullable|date|before_or_equal:due_date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
            'start_date' => $request->start_date,
            'priority' => $request->priority,
            'work_hours' => Task::getWorkHoursByPriority($request->priority), // update otomatis jika priority berubah
        ]);

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'updated_task',
            'description' => 'Updated task: ' . $task->title,
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $taskTitle = $task->title;
        $task->delete();

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_task',
            'description' => 'Deleted task: ' . $taskTitle,
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function transfer(Request $request, Task $task)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $oldUser = $task->assignedUser;
        $task->update(['assigned_to' => $request->assigned_to]);
        $newUser = $task->assignedUser;

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'transferred_task',
            'description' => "Transferred task '{$task->title}' from {$oldUser->name} to {$newUser->name}",
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);

        return back()->with('success', 'Task transferred successfully!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,review,complete',
        ]);

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        // Jika status berubah ke complete, tambahkan work_hours ke user
        if ($oldStatus !== 'complete' && $request->status === 'complete') {
            $user = $task->assignedUser;
            if ($user) {
                $user->recalculateWorkHours(); // lebih aman dan konsisten
            }
        }

        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'updated_task_status',
            'description' => "Updated task '{$task->title}' status from {$oldStatus} to {$request->status}",
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully!',
                'task' => $task->load(['project', 'assignedUser'])
            ]);
        }

        return back()->with('success', 'Task status updated successfully!');
    }

    // Show transfer form for a project
    public function showTransferForm(Project $project)
    {
        $tasks = $project->tasks;
        $sdm = $project->sdm;
        $userIds = collect([
            $sdm->project_director ?? null,
            $sdm->engineer_backend ?? $sdm->engineer_web ?? null,
            $sdm->engineer_frontend ?? null,
            $sdm->engineer_android ?? null,
            $sdm->engineer_ios ?? null,
            $sdm->uiux ?? null,
            $sdm->analis ?? null,
            $sdm->content_creator ?? null,
            $sdm->copywriter ?? null,
            $sdm->tester ?? null,
        ])->filter()->unique();
        $employees = User::whereIn('id', $userIds)->get();
        $projects = collect([$project]);
        return view('task.transfer', compact('tasks', 'projects', 'employees'));
    }

    // Handle transfer form submission
    public function submitTransfer(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'level' => 'required|in:low,medium,high',
        ]);
        $task = Task::findOrFail($request->task_id);
        $oldUser = $task->assignedUser;
        $task->assigned_to = $request->user_id;
        $task->priority = $request->level;
        $task->save();
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'transferred_task',
            'description' => "Transferred task '{$task->title}' from {$oldUser->name} to ".$task->assignedUser->name,
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);
        return redirect()->route('project.show', $request->project_id)->with('success', 'Task transferred successfully!');
    }
}
