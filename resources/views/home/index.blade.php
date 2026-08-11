@extends('layouts.app')
@section('title','Dashboard')
@section('content') 
<div class="row">    
    <!-- Hour chart  -->
    <div class="card bg-transparent shadow-none border-0 my-4">
        <div class="card-body row p-0 pb-3">
            <div class="col-12 col-md-12 card-separator">
                <h4 class="fw-bold">Selamat Datang, {{ ucfirst($user->name) }} {{ $tanggal }}👋🏻 </h5>
                
                <div class="row g-4 mt-2">
                    <!-- Courses-->
                    <div class="col-12 col-lg-8">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Complaints by unit or division</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="topic" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topic">
                                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['filter_unit' => 'highest']) }}">Highest Complaints (>= 50%)</a>
                                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['filter_unit' => 'all']) }}">All View</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-8">
                                <div id="horizontalBarChart"></div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-around align-items-center flex-wrap">
                            @if(count($divisionData) > 0)
                                @foreach(array_chunk($divisionData, max(1, ceil(count($divisionData) / 2))) as $chunk)
                                <div>
                                    @foreach($chunk as $index => $item)
                                    <div class="d-flex align-items-baseline {{ $index % 3 == 1 ? 'my-3' : 'mb-3' }}">
                                        <span style="color: {{ $item['hex_color'] }}; margin-right: 0.5rem;"><i class="icon-base bx bxs-circle bx-12px"></i></span>
                                        <div>
                                            <p class="mb-0" style="font-size: 12px; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item['name'] }}">{{ $item['name'] }}</p>
                                            <h5>{{ $item['percentage'] }}%</h5>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted">Belum ada data</p>
                            @endif
                            </div>
                        </div>
                        </div>
                    </div>
                <!-- /Courses-->

                <!-- Reasons for delivery exceptions -->
                <div class="col-lg-4 col-xxl-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Most Common Types of Complaints</h5>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="deliveryExceptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
                                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['filter_type' => 'highest']) }}">Highest Complaints (>= 50%)</a>
                                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['filter_type' => 'all']) }}">All View</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="deliveryExceptionsChart"></div>
                        </div>
                    </div>
                </div>
                <!--/ Reasons for delivery exceptions -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hour chart End  -->
    
    <!-- Bar Charts -->
    <div class="col-xl-12 col-12 mb-4">
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="col-lg-8">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Complaint Statistics</h5>
                        </div>
                    </div>
                    <div id="totalRevenueChart" class="px-3"></div>
                </div>
                <div class="col-lg-4">
                    <div class="card-body px-xl-9 d-flex align-items-center flex-column" style="position: relative;">
                        <div class="text-center mb-6">
                            <div class="btn-group">
                                <button type="button" class="btn btn-label-primary">
                                    This Week vs Last Week
                                </button>
                            </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-medium my-6">{{ $growthPercentage > 0 ? '+' : '' }}{{ $growthPercentage }}% Growth</div>
                        
                        <div class="d-flex gap-6 justify-content-between mt-3">
                            <div class="d-flex">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-2 bg-label-primary"><i class="icon-base bx bx-bar-chart-alt-2 icon-lg text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>This Week</small>
                                    <h6 class="mb-0">{{ $thisWeekCount }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-2 bg-label-info"><i class="icon-base bx bx-bar-chart-alt-2 icon-lg text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Last Week</small>
                                    <h6 class="mb-0">{{ $lastWeekCount }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Bar Charts -->

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const divisionLabels = {!! json_encode($divisionLabels) !!};
    const divisionSeries = {!! json_encode($divisionSeries) !!};
    const divisionColors = {!! json_encode(array_column($divisionData, 'hex_color')) !!};

    const typeLabels = {!! json_encode($typeLabels) !!};
    const typeSeries = {!! json_encode($typeSeries) !!};
    const typeColors = {!! json_encode(array_column($typeData, 'hex_color')) !!};

    // 1. Horizontal Bar Chart (Topic you are interested in)
    const horizontalBarChartEl = document.querySelector('#horizontalBarChart'),
    horizontalBarChartConfig = {
        chart: {
            height: 300,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '60%',
                distributed: true,
                startingShape: 'rounded',
                borderRadius: 7,
            }
        },
        grid: {
            strokeDashArray: 10,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
            padding: {
                top: -35,
                bottom: -12
            }
        },
        colors: divisionColors.length ? divisionColors : ['#696cff'],
        dataLabels: {
            enabled: true,
            textAnchor: 'middle',
            style: {
                colors: ['#fff'],
                fontSize: '13px',
                fontFamily: 'Public Sans'
            },
            formatter: function (val, opt) {
                return divisionLabels[opt.dataPointIndex];
            },
            offsetX: 0,
            dropShadow: {
                enabled: false
            }
        },
        series: [
            {
                data: divisionSeries
            }
        ],
        xaxis: {
            categories: divisionLabels.map((val, index) => (index + 1).toString()),
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#a1acb8',
                    fontSize: '13px'
                },
                formatter: function (val) {
                    return val + '%';
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#a1acb8',
                    fontSize: '13px'
                },
                formatter: function (val) {
                    if (val && val.length > 10) {
                        return val.substring(0, 10) + '...';
                    }
                    return val;
                }
            }
        },
        legend: {
            show: false
        },
        tooltip: {
            enabled: true,
            y: {
                formatter: function (val) {
                    return val + "%";
                }
            }
        }
    };
    if (typeof horizontalBarChartEl !== undefined && horizontalBarChartEl !== null) {
        const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
        horizontalBarChart.render();
    }

    // 2. Donut Chart (Reasons for delivery exceptions)
    const deliveryExceptionsChartEl = document.querySelector('#deliveryExceptionsChart'),
    deliveryExceptionsChartConfig = {
        chart: {
            height: 400,
            type: 'donut'
        },
        labels: typeLabels,
        series: typeSeries.length ? typeSeries : [1],
        colors: typeColors.length ? typeColors : ['#28c76f'],
        stroke: {
            width: 0,
            lineCap: 'round'
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            position: 'bottom',
            markers: {
                offsetX: -3
            },
            itemMargin: {
                vertical: 3,
                horizontal: 10
            },
            labels: {
                colors: '#a1acb8',
                useSeriesColors: false
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        value: {
                            fontSize: '2rem',
                            fontFamily: 'Public Sans',
                            color: '#566a7f',
                            offsetY: -15,
                            formatter: function (val) {
                                return parseInt(val) + '%';
                            }
                        },
                        name: {
                            offsetY: 20,
                            fontFamily: 'Public Sans'
                        },
                        total: {
                            show: true,
                            fontSize: '0.9rem',
                            color: '#a1acb8',
                            label: 'AVG. Exceptions',
                            formatter: function (w) {
                                let total = w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0);
                                let count = w.globals.seriesTotals.length;
                                let avg = count > 0 ? Math.round(total / count) : 0;
                                return avg + '%';
                            }
                        }
                    }
                }
            }
        }
    };
    if (typeof deliveryExceptionsChartEl !== undefined && deliveryExceptionsChartEl !== null) {
        const deliveryExceptionsChart = new ApexCharts(deliveryExceptionsChartEl, deliveryExceptionsChartConfig);
        deliveryExceptionsChart.render();
    }

    // 3. Total Revenue Chart (Complaint Statistics)
    let dailySeriesData = {!! json_encode($last7DaysSeries) !!};
    let maxComplaints = Math.max(...dailySeriesData);
    if (maxComplaints === 0) maxComplaints = 1;
    let tickAmt = maxComplaints < 5 ? maxComplaints : 5;

    const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
    totalRevenueChartOptions = {
      series: [
        {
          name: 'Total Complaints',
          data: dailySeriesData
        }
      ],
      chart: {
        height: 300,
        stacked: false,
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '25%',
          borderRadius: 8,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: ['#696cff'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: ['#fff']
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: '#f3f4f6',
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: {!! json_encode($last7DaysLabels) !!},
        labels: {
          style: {
            fontSize: '13px',
            colors: '#a1acb8'
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        min: 0,
        max: maxComplaints,
        tickAmount: tickAmt,
        labels: {
          formatter: function (val) {
            return parseInt(val);
          },
          style: {
            fontSize: '13px',
            colors: '#a1acb8'
          }
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
    if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
      const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
      totalRevenueChart.render();
    }

    // 4. Growth Chart
    const growthChartEl = document.querySelector('#growthChart'),
    growthChartOptions = {
      series: [{{ min(abs($growthPercentage), 100) }}], // max 100% for radial bar
      labels: ['Growth'],
      chart: {
        height: 240,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          size: 150,
          offsetY: 10,
          startAngle: -150,
          endAngle: 150,
          hollow: {
            size: '55%'
          },
          track: {
            background: '#fff',
            strokeWidth: '100%'
          },
          dataLabels: {
            name: {
              offsetY: 15,
              color: '#566a7f',
              fontSize: '15px',
              fontWeight: '500',
              fontFamily: 'Public Sans'
            },
            value: {
              offsetY: -25,
              color: '#566a7f',
              fontSize: '22px',
              fontWeight: '500',
              fontFamily: 'Public Sans'
            }
          }
        }
      },
      colors: ['#696cff'],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          shadeIntensity: 0.5,
          gradientToColors: ['#696cff'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0.6,
          stops: [30, 70, 100]
        }
      },
      stroke: {
        dashArray: 5
      },
      grid: {
        padding: {
          top: -35,
          bottom: -10
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
    if (typeof growthChartEl !== undefined && growthChartEl !== null) {
      const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
      growthChart.render();
    }

});
</script>
@endpush