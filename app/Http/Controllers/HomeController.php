<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public function index(Request $request)
    {
        $user = Auth::user();
        $tanggal = now()->format('d-m-Y');

        // 1. Questions by Category
        $categoriesData = Question::select('category', DB::raw('count(*) as total'))
                            ->groupBy('category')
                            ->get();

        $doughnutLabels = [];
        $doughnutData = [];
        // Warna bisa ditambah jika kategorinya sangat banyak
        $doughnutColors = ['#666ee8', '#28d094', '#fdac34', '#ff4961', '#1e9ff2', '#ff9149', '#8e44ad', '#2c3e50'];
        
        foreach($categoriesData as $item) {
            $catName = $item->category ? $item->category : 'Uncategorized';
            $doughnutLabels[] = $catName;
            $doughnutData[] = $item->total;
        }

        // Jika tidak ada data sama sekali, berikan dummy 0
        if (empty($doughnutLabels)) {
            $doughnutLabels = ['No Data'];
            $doughnutData = [1];
        }

        // 2. Player Statistics (Dynamic Period)
        $period = $request->get('period', 'last_7_days');
        
        $barLabels = [];
        $barData = [];

        if (in_array($period, ['today', 'yesterday'])) {
            $startDate = $period == 'today' ? Carbon::today() : Carbon::yesterday();
            $endDate = $startDate->copy()->endOfDay();
            
            $players = Player::whereBetween('created_at', [$startDate, $endDate])->get();
            $grouped = $players->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('H'); // get hour 00-23
            });

            for ($i = 0; $i < 24; $i++) {
                $hourStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                $barLabels[] = $hourStr . ':00';
                $barData[] = $grouped->has($hourStr) ? $grouped[$hourStr]->count() : 0;
            }
        } else {
            if ($period == 'last_30_days') {
                $startDate = Carbon::today()->subDays(29);
                $daysCount = 30;
            } elseif ($period == 'current_month') {
                $startDate = Carbon::today()->startOfMonth();
                $daysCount = Carbon::today()->daysInMonth;
            } elseif ($period == 'last_month') {
                $startDate = Carbon::today()->subMonth()->startOfMonth();
                $daysCount = $startDate->daysInMonth;
            } else {
                // last_7_days
                $startDate = Carbon::today()->subDays(6);
                $daysCount = 7;
            }

            $endDate = $startDate->copy()->addDays($daysCount - 1)->endOfDay();
            
            $players = Player::whereBetween('created_at', [$startDate, $endDate])->get();
            $grouped = $players->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('Y-m-d');
            });

            for ($i = 0; $i < $daysCount; $i++) {
                $date = $startDate->copy()->addDays($i);
                $barLabels[] = $date->format('d/m');
                $dateStr = $date->format('Y-m-d');
                $barData[] = $grouped->has($dateStr) ? $grouped[$dateStr]->count() : 0;
            }
        }

        $activePeriod = $period;

        return view('home.index', compact(
            'user', 
            'tanggal', 
            'doughnutLabels', 
            'doughnutData', 
            'doughnutColors', 
            'barLabels', 
            'barData',
            'activePeriod'
        ));
    }
}
