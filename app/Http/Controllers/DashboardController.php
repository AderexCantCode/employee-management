<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $readyUsers = User::where('status', 'ready')->get();
        $standbyUsers = User::where('status', 'standby')->get();
        $notReadyUsers = User::where('status', operator: 'not_ready')->get();
        $completeTasks = Task::where('status', 'complete')->get();

        $user = Auth::user();
        $userTasks = $user->tasks()->get();
        $userProjects = Project::with('members')->where('manager_id', $user->id)->get();
        // Semua project beserta anggota
        $allProjects = Project::with('members')->get();
        $userTasksCount = $userTasks->count();
        $userProjectsCount = $userProjects->count();

        // Activity untuk 5 bulan terakhir
        $activities = Activity::with('user')
            ->where('created_at', '>=', Carbon::now()->subMonths(5))
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // chart data untuk jumlah project yang dibuat 5 bulan terakhir
        $months = collect(range(0, 4))->map(function ($i) {
            return now()->subMonths(4 - $i)->format('Y-m');
        });

        $projectCounts = Project::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        $projectChartLabels = $months->map(function ($month) {
            return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
        });

        $projectChartData = $months->map(function ($month) use ($projectCounts) {
            return $projectCounts->get($month, 0);
        });

        // mengambil data user yang sedang absent
        $absentUsers = User::whereHas('absences', function($query) {
            $query->where('status', 'approved')
                  ->whereDate('start_date', '<=', Carbon::today())
                  ->whereDate('end_date', '>=', Carbon::today());
        })->get();

        return view('dashboard', compact(
            'readyUsers', 'standbyUsers', 'notReadyUsers',
            'completeTasks', 'absentUsers', 'userTasksCount',
            'userProjectsCount', 'activities',
            'projectChartLabels', 'projectChartData',
            'userTasks', 'userProjects', 'allProjects'
        ));
    }
}
