<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recruitment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function userStats(Request $request)
    {
        $totalUsers = Cache::remember('stats.total_users', now()->addMinutes(5), function () {
        return User::whereIn('role', ['jobber','provider','education'])->count();
    });
        $totalCourses = Cache::remember('stats.total_courses', now()->addMinutes(5), function () {
            return Course::count();
        });
        $openRecruitments = Cache::remember('stats.open_recruitments', now()->addMinutes(5), function () {
            return Recruitment::open()->count();
        });
        $totalRecruitments = Cache::remember('stats.total_recruitments', now()->addMinutes(5), function () {
            return Recruitment::count();
        });
        // ค่าตั้งต้นหน้า UI
        return view('admin.dashboard', [
            'defaultFrom' => now('Asia/Bangkok')->startOfMonth()->toDateString(),
            'defaultTo'   => now('Asia/Bangkok')->toDateString(),
            'totalUsers'  => $totalUsers,
            'totalCourses' => $totalCourses,
            'openRecruitments' => $openRecruitments,
            'totalRecruitments' => $totalRecruitments,
        ]);
    }

    public function userStatsData(Request $request)
    {
        $tz = 'Asia/Bangkok';
        $allowedRoles = ['jobber','provider','education','admin'];

        $roles = $request->input('roles', $allowedRoles);
        if (!is_array($roles) || empty($roles)) $roles = $allowedRoles;
        $roles = array_values(array_intersect($roles, $allowedRoles));
        if (empty($roles)) $roles = $allowedRoles;

        $interval = $request->input('interval', 'day'); // day|week|month
        if (!in_array($interval, ['day','week','month'], true)) $interval = 'day';

        // range (ตีเป็นโซนไทย แล้ว where ด้วย UTC)
        $fromLocal = Carbon::parse($request->input('from', now($tz)->subDays(29)->toDateString()), $tz);
        $toLocal   = Carbon::parse($request->input('to',   now($tz)->toDateString()),               $tz);
        if ($interval === 'day')  { $fromLocal->startOfDay();                $toLocal->endOfDay(); }
        if ($interval === 'week') { $fromLocal->startOfWeek(Carbon::MONDAY); $toLocal->endOfWeek(Carbon::MONDAY)->endOfDay(); }
        if ($interval === 'month'){ $fromLocal->startOfMonth();              $toLocal->endOfMonth()->endOfDay(); }

        $fromUtc = $fromLocal->clone()->setTimezone('UTC');
        $toUtc   = $toLocal->clone()->setTimezone('UTC');

        // labels
        [$labels] = $this->makeLabels($fromLocal->clone(), $toLocal->clone(), $interval);

        $datasets = [];            // ผู้ใช้ใหม่ต่อช่วงเวลา
        $cumDatasets = [];         // ผู้ใช้สะสม
        $summaryByRole = [];       // รวมตาม role (ใช้ทำ doughnut)
        foreach ($roles as $role) {
            $rows = DB::table('users')
                ->selectRaw("
                    date_trunc('{$interval}', (created_at AT TIME ZONE '{$tz}')) AS bucket,
                    COUNT(*)::int AS cnt
                ")
                ->where('role', $role)
                ->whereBetween('created_at', [$fromUtc, $toUtc])
                ->groupBy('bucket')
                ->orderBy('bucket')
                ->get();

            // map -> series (เติมศูนย์)
            $map = [];
            $sum = 0;
            foreach ($rows as $r) {
                $key = $this->formatBucketLabel(Carbon::parse($r->bucket, $tz), $interval);
                $map[$key] = (int)$r->cnt;
                $sum += (int)$r->cnt;
            }
            $summaryByRole[$role] = $sum;

            $series = [];
            foreach ($labels as $lb) $series[] = $map[$lb] ?? 0;

            // cumulative
            $running = 0; $cumu = [];
            foreach ($series as $v) { $running += $v; $cumu[] = $running; }

            $datasets[]    = ['label'=>$role,'data'=>$series];
            $cumDatasets[] = ['label'=>$role,'data'=>$cumu];
        }

        return response()->json([
            'labels'       => $labels,
            'datasets'     => $datasets,     // line: ผู้ใช้ใหม่
            'cumulative'   => $cumDatasets,  // line: ผู้ใช้สะสม
            'distribution' => $summaryByRole, // doughnut
            'summary'      => [
                'total'    => array_sum($summaryByRole),
                'byRole'   => $summaryByRole,
                'interval' => $interval,
                'from'     => $fromLocal->toDateString(),
                'to'       => $toLocal->toDateString(),
            ],
        ]);
    }

    private function makeLabels(Carbon $from, Carbon $to, string $interval): array
    {
        $labels = [];
        if ($interval === 'day') {
            while ($from <= $to) { $labels[] = $from->format('Y-m-d'); $from->addDay(); }
            return [$labels];
        }
        if ($interval === 'week') {
            $from->startOfWeek(\Carbon\CarbonInterface::MONDAY);
            while ($from <= $to) { $labels[] = $from->format('o-\WW'); $from->addWeek(); }
            return [$labels];
        }
        $from->startOfMonth();
        while ($from <= $to) { $labels[] = $from->format('Y-m'); $from->addMonthNoOverflow(); }
        return [$labels];
    }

    private function formatBucketLabel(Carbon $dt, string $interval): string
    {
        return $interval === 'day' ? $dt->format('Y-m-d') :
               ($interval === 'week' ? $dt->format('o-\WW') : $dt->format('Y-m'));
    }
}
