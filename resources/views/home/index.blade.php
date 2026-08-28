@extends('layouts.app')
@section('title','Dashboard')
@section('content') 
<h4 class="fw-bold py-3 mb-2">Selamat Datang, {{ ucfirst($user->name) }} {{ $tanggal }}👋🏻</h4>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <p>Welcome to Wheel of Fortune.</p>
            </div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="col-lg-8 col-12 mb-6">
      <div class="card h-100">
        <div class="card-header header-elements">
          <h5 class="card-title mb-0">Player Statistics</h5>
          <div class="card-action-element ms-auto py-0">
            <div class="dropdown">
              <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-base bx bx-calendar"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a href="?period=today" class="dropdown-item d-flex align-items-center {{ isset($activePeriod) && $activePeriod == 'today' ? 'active' : '' }}">Today</a></li>
                <li><a href="?period=yesterday" class="dropdown-item d-flex align-items-center {{ isset($activePeriod) && $activePeriod == 'yesterday' ? 'active' : '' }}">Yesterday</a></li>
                <li><a href="?period=last_7_days" class="dropdown-item d-flex align-items-center {{ isset($activePeriod) && $activePeriod == 'last_7_days' ? 'active' : '' }}">Last 7 Days</a></li>
                <li><a href="?period=last_30_days" class="dropdown-item d-flex align-items-center {{ isset($activePeriod) && $activePeriod == 'last_30_days' ? 'active' : '' }}">Last 30 Days</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a href="?period=current_month" class="dropdown-item d-flex align-items-center {{ isset($activePeriod) && $activePeriod == 'current_month' ? 'active' : '' }}">Current Month</a></li>
                <li><a href="?period=last_month" class="dropdown-item d-flex align-items-center {{ isset($activePeriod) && $activePeriod == 'last_month' ? 'active' : '' }}">Last Month</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div style="position: relative; height: 400px; width: 100%;">
            <canvas id="barChart" class="chartjs"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- /Bar Chart -->

    <!-- Doughnut Chart -->
    <div class="col-lg-4 col-12 mb-6">
      <div class="card h-100">
        <h5 class="card-header">Questions by Category</h5>
        <div class="card-body">
          <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="doughnutChart" class="chartjs mb-6"></canvas>
          </div>

        </div>
      </div>
    </div>
    <!-- /Doughnut Chart -->
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data from PHP Controller
    const doughnutLabels = {!! json_encode($doughnutLabels) !!};
    const doughnutData = {!! json_encode($doughnutData) !!};
    const doughnutColors = {!! json_encode($doughnutColors) !!};

    const barLabels = {!! json_encode($barLabels) !!};
    const barData = {!! json_encode($barData) !!};

    // Doughnut Chart Configuration
    const doughnutChartEl = document.getElementById('doughnutChart');
    if (doughnutChartEl) {
        new Chart(doughnutChartEl, {
            type: 'doughnut',
            data: {
                labels: doughnutLabels,
                datasets: [{
                    data: doughnutData,
                    backgroundColor: doughnutColors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let total = context.chart._metasets[context.datasetIndex].total;
                                let value = context.raw;
                                let percentage = Math.round((value / total) * 100) + '%';
                                return ' ' + context.label + ' : ' + percentage;
                            }
                        }
                    }
                }
            }
        });
    }

    // Bar Chart Configuration
    const barChartEl = document.getElementById('barChart');
    if (barChartEl) {
        // Skala Y max 20, kelipatan 2. Jika data > 20, skala menyesuaikan.
        let maxData = Math.max(...barData);
        let maxScale = maxData <= 20 ? 20 : Math.ceil(maxData / 10) * 10;
        let stepScale = maxData <= 20 ? 2 : Math.ceil(maxScale / 10);

        new Chart(barChartEl, {
            type: 'bar',
            data: {
                labels: barLabels, 
                datasets: [{
                    label: 'Players',
                    data: barData,
                    backgroundColor: 'rgb(40, 208, 148)',
                    borderRadius: 4,
                    barThickness: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false 
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: maxScale,
                        ticks: {
                            stepSize: stepScale
                        },
                        grid: {
                            drawBorder: false,
                            color: '#e9ecef'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush