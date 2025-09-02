<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseMember;
use App\Models\Recruitment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function admin()
    {
        return view('admin.provider');
    }

    public function education()
    {
        $uid = Auth::id();

        $coursesQ = Course::query()->where('c_create_by_id', $uid);
        $totals = [
            'all'    => (clone $coursesQ)->count(),
            'open'   => (clone $coursesQ)->where('c_status','open')->count(),
            'draft'  => (clone $coursesQ)->where('c_status','draft')->count(),
            'closed' => (clone $coursesQ)->where('c_status','closed')->count(),
            'pending'=> (clone $coursesQ)->where('c_status','pending')->count(),
        ];

        $courseIds = (clone $coursesQ)->pluck('c_id');
        $participants = $courseIds->isEmpty()
            ? 0
            : CourseMember::whereIn('cm_c_id', $courseIds)->count();

        $recentCourses = Course::where('c_create_by_id', $uid)
            ->orderByDesc('c_id')
            ->take(5)
            ->get();

        return view('education.dashboard', compact('totals', 'participants', 'recentCourses'));
    }

    public function provider()
    {
        $uid = Auth::id();

        $jobsQ = Recruitment::ownedBy($uid);
        $totals = [
            'all'    => (clone $jobsQ)->count(),
            'open'   => (clone $jobsQ)->where('rc_status','open')->count(),
            'draft'  => (clone $jobsQ)->where('rc_status','draft')->count(),
            'closed' => (clone $jobsQ)->where('rc_status','closed')->count(),
        ];

        $views = (clone $jobsQ)->sum('rc_views');

        $recentJobs = Recruitment::ownedBy($uid)
            ->orderByDesc('rc_posted_at')
            ->orderByDesc('rc_id')
            ->take(6)
            ->get();

        return view('provider.dashboard', compact('totals', 'views', 'recentJobs'));
    }

    public function jobber()
    {
        return view('jobber.dashboard');
    }
}
