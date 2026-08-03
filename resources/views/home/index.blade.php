@extends('layouts.app')
@section('title','Dashboard')
@section('content') 
<div class="row">    
    <!-- Hour chart  -->
    <div class="card bg-transparent shadow-none border-0 my-4">
        <div class="card-body row p-0 pb-3">
            <div class="col-12 col-md-12 card-separator">
                <h3>Selamat Datang, {{ ucfirst($user->name) }} {{ $tanggal }}👋🏻 </h3>
                <!-- <div class="col-12 col-lg-7">
                    <p>Your progress this week is Awesome. let's keep it up and get a lot of points reward !</p>
                </div> -->
                
                <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                    <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                        <span class="bg-label-info p-2 rounded">
                            <i class='bx bx-user bx-sm'></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Karyawan</p>
                            <h4 class="text-info mb-0"></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-success p-2 rounded">
                            <i class='bx bx-calendar-check'></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Absen Datang / Pulang</p>
                            <h4 class="text-success mb-0"></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-danger p-2 rounded">
                            <i class='bx bx-calendar-minus'></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Tidak Absen Datang / Pulang</p>
                            <h4 class="text-danger mb-0"></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class=" bg-label-dark p-2 rounded">
                            <i class='bx bx-calendar-x'></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Izin</p>
                            <h4 class="text-dark mb-0"></h4>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Hour chart End  -->
    
    <!-- Bar Charts -->
    <div class="col-xl-12 col-12 mb-4">
        <div class="card">
            <div class="card-header header-elements">
                <h5 class="card-title mb-0">Statistik Absensi Perminggu</h5>
            </div>
            <div class="card-body">
                <canvas class="chartjs" data-height="800" id="myChart"></canvas>
            </div>
        </div>
    </div>
    <!-- /Bar Charts -->

</div>
@endsection