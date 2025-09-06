<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('manager')->get();
        return view('project.index', compact('projects'));
    }

    public function create()
    {
        $managers = User::where('role', 'admin')->orWhere('role', 'manager')->get();
        $employees = User::all();
        return view('project.create', compact('managers', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'level' => 'required|in:low,medium,high',
            // SDM validations (optional)
            'project_director' => 'nullable|exists:users,id',
            'backend_dev' => 'nullable|exists:users,id',
            'frontend_dev' => 'nullable|exists:users,id',
            'engineer_android' => 'nullable|exists:users,id',
            'engineer_ios' => 'nullable|exists:users,id',
            'uiux' => 'nullable|exists:users,id',
            'analis' => 'nullable|exists:users,id',
            'content_creator' => 'nullable|exists:users,id',
            'copywriter' => 'nullable|exists:users,id',
            'tester' => 'nullable|exists:users,id',
        ]);

        try {
            // Create the project
            $project = Project::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'level' => $request->input('level'),
                'status' => 'active', // default status
                'manager_id' => $request->input('project_director') ?? Auth::id(), // use project director as manager, or current user
            ]);

            // Create SDM record if any SDM fields are provided
            if ($request->hasAny(['project_director','backend_dev','frontend_dev','analis','engineer_android','engineer_ios','copywriter','uiux','content_creator','tester'])) {
                $project->sdm()->create([
                    'project_director' => $request->input('project_director'),
                    'backend_dev' => $request->input('backend_dev'),
                    'frontend_dev' => $request->input('frontend_dev'),
                    'analis' => $request->input('analis'),
                    'engineer_android' => $request->input('engineer_android'),
                    'engineer_ios' => $request->input('engineer_ios'),
                    'copywriter' => $request->input('copywriter'),
                    'uiux' => $request->input('uiux'),
                    'content_creator' => $request->input('content_creator'),
                    'tester' => $request->input('tester'),
                ]);
            }

            return redirect()->route('project.index')->with('success', 'Project and team members assigned successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    public function show(Project $project)
    {
        $project->load([
            'manager',
            'sdm.projectDirector',
            'sdm.backendDev',
            'sdm.frontendDev',
            'sdm.analis',
            'sdm.engineerAndroid',
            'sdm.engineerIos',
            'sdm.copywriter',
            'sdm.uiux',
            'sdm.contentCreator',
            'sdm.tester',
        ]);
        return view('project.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $managers = User::where('role', 'admin')->orWhere('role', 'manager')->get();
        $employees = User::all();
        $project->load('sdm');
        return view('project.edit', compact('project', 'managers', 'employees'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'level' => 'required|in:low,medium,high',
            'status' => 'required|in:active,completed,on_hold',
            'manager_id' => 'required|exists:users,id',
            // SDM validations (optional)
            'project_director' => 'nullable|exists:users,id',
            'backend_dev' => 'nullable|exists:users,id',
            'frontend_dev' => 'nullable|exists:users,id',
            'engineer_android' => 'nullable|exists:users,id',
            'engineer_ios' => 'nullable|exists:users,id',
            'uiux' => 'nullable|exists:users,id',
            'analis' => 'nullable|exists:users,id',
            'content_creator' => 'nullable|exists:users,id',
            'copywriter' => 'nullable|exists:users,id',
            'tester' => 'nullable|exists:users,id',
        ]);

        try {
            // Update project
            $project->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'level' => $request->input('level'),
                'status' => $request->input('status'),
                'manager_id' => $request->input('manager_id'),
            ]);

            // Update or create SDM record
            if ($request->hasAny(['project_director','engineer_web','analis','engineer_android','engineer_ios','copywriter','uiux','content_creator','tester'])) {
                $project->sdm()->updateOrCreate(
                    ['project_id' => $project->id],
                    [
                        'project_director' => $request->input('project_director'),
                        'backend_dev' => $request->input('backend_dev'),
                        'frontend_dev' => $request->input('frontend_dev'),
                        'analis' => $request->input('analis'),
                        'engineer_android' => $request->input('engineer_android'),
                        'engineer_ios' => $request->input('engineer_ios'),
                        'copywriter' => $request->input('copywriter'),
                        'uiux' => $request->input('uiux'),
                        'content_creator' => $request->input('content_creator'),
                        'tester' => $request->input('tester'),
                    ]
                );
            }

            return redirect()->route('project.index')->with('success', 'Project updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update project: ' . $e->getMessage());
        }
    }

    public function destroy(Project $project)
    {
        try {
            // Delete SDM first (if exists)
            $project->sdm()->delete();

            // Delete project
            $project->delete();

            return redirect()->route('project.index')->with('success', 'Project deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    public function view()
    {
        $projects = Project::with('tasks')->orderBy('created_at', 'desc')->get();
        return view('project.view', compact('projects'));
    }
}
