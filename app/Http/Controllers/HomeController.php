<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Division;
use App\Models\ComplaintType;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $tanggal = now()->format('d-m-Y');

        $totalComplaints = Complaint::count();

        // 1. Complaints by Division
        $filterUnit = request('filter_unit', 'all');
        $complaintsByDivision = Complaint::selectRaw('division_id, count(*) as total')
            ->groupBy('division_id')
            ->with('division')
            ->orderByDesc('total')
            ->get();

        $divisionData = [];
        $divisionLabels = [];
        $divisionSeries = [];
        
        $bsColors = ['text-primary', 'text-info', 'text-success', 'text-secondary', 'text-danger', 'text-warning'];
        // Extended palette of ~50 distinct colors for charts
        $hexColors = [
            '#696cff', '#03c3ec', '#71dd37', '#8592a3', '#ff3e1d', '#ffab00',
            '#e83e8c', '#6f42c1', '#20c997', '#fd7e14', '#0dcaf0', '#198754',
            '#d63384', '#17a2b8', '#28a745', '#ffc107', '#dc3545', '#343a40',
            '#6610f2', '#f83600', '#f9d423', '#8e44ad', '#2c3e50', '#e67e22',
            '#1abc9c', '#3498db', '#9b59b6', '#34495e', '#16a085', '#27ae60',
            '#2980b9', '#f39c12', '#d35400', '#c0392b', '#bdc3c7', '#7f8c8d',
            '#ff9ff3', '#feca57', '#ff6b6b', '#48dbfb', '#1dd1a1', '#5f27cd',
            '#c8d6e5', '#576574', '#222f3e', '#ff9f43', '#0abde3', '#10ac84'
        ];

        foreach ($complaintsByDivision as $index => $c) {
            $divName = $c->division ? $c->division->name : 'Unknown';
            $percentage = $totalComplaints > 0 ? round(($c->total / $totalComplaints) * 100) : 0;
            
            if ($filterUnit === 'highest' && $percentage < 50) {
                continue;
            }

            $divisionLabels[] = $divName;
            $divisionSeries[] = $percentage;
            $divisionData[] = [
                'name' => $divName,
                'percentage' => $percentage,
                'count' => $c->total,
                'bs_color' => $bsColors[$index % count($bsColors)],
                'hex_color' => $hexColors[$index % count($hexColors)],
            ];
        }

        // 2. Types of Complaints
        $filterType = request('filter_type', 'all');
        $complaintsByType = Complaint::selectRaw('complaint_type_id, count(*) as total')
            ->groupBy('complaint_type_id')
            ->with('complaintType')
            ->orderByDesc('total')
            ->get();

        $typeData = [];
        $typeLabels = [];
        $typeSeries = [];
        $typeColors = ['#28c76f', '#42d881', '#72e3a1', '#b9f4ce', '#a0e8be', '#88e0a9']; // Shades of green

        foreach ($complaintsByType as $index => $c) {
            $typeName = $c->complaintType ? $c->complaintType->name : 'Unknown';
            $percentage = $totalComplaints > 0 ? round(($c->total / $totalComplaints) * 100) : 0;
            
            if ($filterType === 'highest' && $percentage < 50) {
                continue;
            }

            $typeLabels[] = $typeName;
            $typeSeries[] = $percentage; // or $c->total, but user wants %
            $typeData[] = [
                'name' => $typeName,
                'percentage' => $percentage,
                'count' => $c->total,
                'hex_color' => $typeColors[$index % count($typeColors)],
            ];
        }

        // 3. Weekly Complaints (Last 7 Days)
        $last7DaysLabels = [];
        $last7DaysSeries = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i);
            $last7DaysLabels[] = $date->format('D d');
            
            $count = Complaint::whereDate('date', $date->format('Y-m-d'))->count();
            $last7DaysSeries[] = $count;
        }

        // 4. Weekly Growth
        $thisWeekCount = array_sum($last7DaysSeries);
        $lastWeekCount = Complaint::whereDate('date', '>=', \Carbon\Carbon::now()->subDays(13)->format('Y-m-d'))
                                  ->whereDate('date', '<', \Carbon\Carbon::now()->subDays(6)->format('Y-m-d'))->count();

        $growthPercentage = 0;
        if ($lastWeekCount > 0) {
            $growthPercentage = round((($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100);
        } else if ($thisWeekCount > 0) {
            $growthPercentage = 100;
        }

        return view('home.index', compact(
            'user', 
            'tanggal', 
            'totalComplaints', 
            'divisionData', 
            'divisionLabels', 
            'divisionSeries', 
            'typeData', 
            'typeLabels', 
            'typeSeries',
            'last7DaysLabels',
            'last7DaysSeries',
            'thisWeekCount',
            'lastWeekCount',
            'growthPercentage'
        ));
    }
}
