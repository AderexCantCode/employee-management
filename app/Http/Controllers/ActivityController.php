<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Filter priority: medium/high/low
        $priority = $request->get('priority');

        // Ambil semua user
        $users = User::withCount([
            // Total project
            'projects as projects_count',
            // Total tasks done (status = completed)
            'tasks as tasks_done_count' => function ($q) use ($priority) {
                $q->where('status', 'completed');
                if ($priority) {
                    $q->where('priority', $priority);
                }
            },
            // Total leave
            'leaves as leave_count'
        ])->get();

        //  work hours calculation
        foreach ($users as $user) {
            // Ambil work_hours dari kolom user
            $totalWorkHours = $user->work_hours ?? 0;
            $user->work_hours_percent = min(100, round(($totalWorkHours / 40) * 100));
            $user->work_hours_total = $totalWorkHours;
            $user->is_overwork = $totalWorkHours > 40;
        }

        $priorities = ['medium', 'high', 'low'];

        // aktivitas dalam 7 hari terakhir
        $activities = Activity::with(['user', 'project'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('created_at')
            ->get();

        return view('activities.index', compact('users', 'priority', 'priorities', 'activities'));
    }

    private function formatAction($action)
    {
        return ucfirst(str_replace('_', ' ', $action));
    }

    private function getActionIcon($action)
    {
        $map = [
            'created' => 'fa-plus',
            'completed' => 'fa-check',
            'updated' => 'fa-edit',
            'deleted' => 'fa-trash',
        ];

        foreach ($map as $key => $icon) {
            if (stripos($action, $key) !== false) {
                return $icon;
            }
        }

        return 'fa-tasks'; // default
    }

    private function getActivityStats()
    {
        $currentUser = auth()->user();

        // Statistik semua proyek
        $projectStats = Project::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Statistik proyek milik user
        $userProjects = Project::where('manager_id', $currentUser->id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Aktivitas terbaru 7 hari terakhir
        $recentActivities = Activity::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        return [
            'total_projects'      => array_sum($projectStats),
            'active_projects'     => $projectStats['active'] ?? 0,
            'completed_projects'  => $projectStats['completed'] ?? 0,
            'on_hold_projects'    => $projectStats['on_hold'] ?? 0,
            'user_active'         => $userProjects['active'] ?? 0,
            'user_completed'      => $userProjects['completed'] ?? 0,
            'user_on_hold'        => $userProjects['on_hold'] ?? 0,
            'recent_activities'   => $recentActivities,
        ];
    }
}
