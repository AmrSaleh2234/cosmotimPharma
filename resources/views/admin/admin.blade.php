@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet"/>
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
<style>
    body{
        font-size: 18px !important;
    }



</style>
@endsection
@section('page-header')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome back!</h2>
                <p class="mg-b-0">Sales monitoring dashboard template.</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">Customer Ratings</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">Online Sales</label>
                <h5>563,275</h5>
            </div>
            <div>
                <label class="tx-13">Offline Sales</label>
                <h5>783,675</h5>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @php
        if(count($invoicesLastWeek)>0)
            {
                $profitPercentege=round($invoicesCurrentWeek->sum('profit')/$invoicesLastWeek->sum('profit')*100,2);
                $sellesWeek=round($invoicesCurrentWeek->sum('total_after')/$invoicesLastWeek->sum('total_after')*100,2);
            }
        else{
            $profitPercentege=100;
            $sellesWeek=100;
        }
        if(count($invoicesLastMonth)>0)
            {
            $profitPercentegeMonth=round($invoicesCurrentMonth->sum('profit')/$invoicesLastMonth->sum('profit')*100,2);
            $sellesMonth=round($invoicesCurrentMonth->sum('total_after')/$invoicesLastMonth->sum('total_after')*100,2);

            }
        else{
            $profitPercentegeMonth=100;
            $sellesMonth=100;
        }
        $total_afterYear=0;
        $profitYear=0;
        foreach ($total_after as $item)
            {
                $total_afterYear+=$item->total;
            }
        foreach ($profit as $item)
            {
                $profitYear+=$item->total;
            }

    @endphp
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div
                class="card overflow-hidden sales-card @if($profitPercentege>100) bg-success-gradient @elseif($profitPercentege<=100 && $profitPercentege>=80) bg-warning-gradient @else bg-danger-gradient @endif bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h4 class="mb-3 tx-12 text-white">الارباح الكليه خلال هذا الاسبوع</h4>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$invoicesCurrentWeek->sum('profit')}}
                                    جم</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنه بلاسبوع الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas @if($profitPercentege>=100) fa-arrow-circle-up @else fa-arrow-circle-down @endif text-white"></i>
											<span class="text-white op-7">{{$profitPercentege}} %</span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">
                    @php
                        $i=count($invoicesLastWeek)-1
                    @endphp
                    @foreach($invoicesLastWeek as $item)
                        {{$item->profit}}
                        @if($i)
                            ,
                        @endif
                        @php
                            $i--;
                        @endphp
                    @endforeach
                    @php
                        $i=count($invoicesCurrentWeek)-1
                    @endphp

                    @foreach($invoicesCurrentWeek as $item)

                        ,{{$item->profit}}

                    @endforeach
                </span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div
                class="card overflow-hidden sales-card @if($profitPercentegeMonth>100) bg-success-gradient @elseif($profitPercentegeMonth<=100 && $profitPercentegeMonth>=80) bg-warning-gradient @else bg-danger-gradient @endif ">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الارباح الكليه خلال هذا شهر</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$invoicesCurrentMonth->sum('profit')}}
                                    جم</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنه بالشهر الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas @if($profitPercentegeMonth>=100) fa-arrow-circle-up @else fa-arrow-circle-down @endif text-white"></i>
											<span class="text-white op-7">{{$profitPercentegeMonth}} %</span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">
                    @php
                        $i=count($invoicesLastMonth)-1
                    @endphp
                    @foreach($invoicesLastMonth as $item)
                        {{$item->profit}}
                        @if($i)
                            ,
                        @endif
                        @php
                            $i--;
                        @endphp
                    @endforeach
                    @php
                        $i=count($invoicesCurrentMonth)-1
                    @endphp

                    @foreach($invoicesCurrentMonth as $item)

                        ,{{$item->profit}}

                    @endforeach
                </span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div
                class="card overflow-hidden sales-card @if($sellesWeek>100) bg-success-gradient @elseif($sellesWeek<=100 && $sellesWeek>=80) bg-warning-gradient @else bg-danger-gradient @endif bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">المبيعات الكليه خلال هذا الاسبوع</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$invoicesCurrentWeek->sum('total_after')}}
                                    جم</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنه بلاسبوع الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas @if($sellesWeek>=100) fa-arrow-circle-up @else fa-arrow-circle-down @endif text-white"></i>
											<span class="text-white op-7">{{$sellesWeek}} %</span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">
                    @php
                        $i=count($invoicesLastWeek)-1
                    @endphp
                    @foreach($invoicesLastWeek as $item)
                        {{$item->total_after}}
                        @if($i)
                            ,
                        @endif
                        @php
                            $i--;
                        @endphp
                    @endforeach
                    @php
                        $i=count($invoicesCurrentWeek)-1
                    @endphp

                    @foreach($invoicesCurrentWeek as $item)

                        ,{{$item->total_after}}

                    @endforeach
                </span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div
                class="card overflow-hidden sales-card @if($sellesMonth>100) bg-success-gradient @elseif($sellesMonth<=100 && $sellesMonth>=80) bg-warning-gradient @else bg-danger-gradient @endif ">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">المبيعات الكليه خلال هذا شهر</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$invoicesCurrentMonth->sum('total_after')}}
                                    جم</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنه بالشهر الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas @if($sellesMonth>=100) fa-arrow-circle-up @else fa-arrow-circle-down @endif text-white"></i>
											<span class="text-white op-7">{{$sellesMonth}} %</span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">
                    @php
                        $i=count($invoicesLastMonth)-1
                    @endphp
                    @foreach($invoicesLastMonth as $item)
                        {{$item->total_after}}
                        @if($i)
                            ,
                        @endif
                        @php
                            $i--;
                        @endphp
                    @endforeach
                    @php
                        $i=count($invoicesCurrentMonth)-1
                    @endphp

                    @foreach($invoicesCurrentMonth as $item)

                        ,{{$item->total_after}}

                    @endforeach
                </span>
            </div>
        </div>
    </div>

    <!-- row closed -->

    <!-- row opened -->
    <div class="row d-flex justify-content-center ">
        <div class="col-md-12 col-lg-12 ">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h1 class="card-title mb-0">الميعات والارباح عام {{date('Y')}}</h1>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>

                </div>
                <div class="card-body">
                    <div class="total-revenue mb-4">
                        <div>
                            <h4>{{$total_afterYear}}جم</h4>
                            <label><span class="bg-primary"></span>مبيعات</label>
                        </div>
                        <div>
                            <h4>{{$profitYear}}جم</h4>
                            <label><span class="bg-danger"></span>ارباح</label>
                        </div>

                    </div>
                    <div style="margin-top: 70px">
                        <div id="echart1" class="ht-200"></div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">افضل 5 عملاء عام {{date('Y')}}</h3>
                    <p class="tx-12 mb-0 text-muted">افضل عميرل بمجموع الفواتير النهائية </p>
                </div>

                <div class="card-body p-0 customers mt-1">
                    @for($i=0 ; $i<5 && $i<count($customer) ;$i++)
                        <div class="list-group list-lg-group list-group-flush">
                        <div class="list-group-item list-group-item-action" href="#">
                            <div class="media mt-0">

                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mt-0">
                                            <h5 class="mb-1 tx-15">{{$customer[$i]->name}}</h5>
                                            <p class="mb-0 tx-13 text-muted "><span
                                                    class="text-success ml-2" style="font-size: 15px">قيمة كل الفواتير</span>
                                                {{$customer[$i]->total}}</p>
                                            <p class="mb-0 tx-13 text-muted"><span
                                                    class="text-primary ml-2"  style="font-size: 15px">قيمة المدفوع منهم</span>
                                                {{$customer[$i]->total_payed}}</p>
                                        </div>
                                        <span class="mr-auto wd-45p fs-16 mt-2">
                                            <div id="spark{{$i+1}}" class="wd-100p"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endfor

                </div>
            </div>
        </div>



        <div class="col-xl-4 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">Sales Activity</h3>
                    <p class="tx-12 mb-0 text-muted">Sales activities are the tactics that salespeople use to achieve
                        their goals and objective</p>
                </div>
                <div class="product-timeline card-body pt-2 mt-1">
                    <ul class="timeline-1 mb-0">
                        <li class="mt-0"><i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">Total Products</span> <a href="#"
                                                                                                  class="float-left tx-11 text-muted">3
                                days ago</a>
                            <p class="mb-0 text-muted tx-12">1.3k New Products</p>
                        </li>
                        <li class="mt-0"><i class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i>
                            <span class="font-weight-semibold mb-4 tx-14 ">Total Sales</span> <a href="#"
                                                                                                 class="float-left tx-11 text-muted">35
                                mins ago</a>
                            <p class="mb-0 text-muted tx-12">1k New Sales</p>
                        </li>
                        <li class="mt-0"><i class="ti-bar-chart-alt bg-success-gradient text-white product-icon"></i>
                            <span class="font-weight-semibold mb-4 tx-14 ">Toatal Revenue</span> <a href="#"
                                                                                                    class="float-left tx-11 text-muted">50
                                mins ago</a>
                            <p class="mb-0 text-muted tx-12">23.5K New Revenue</p>
                        </li>
                        <li class="mt-0"><i class="ti-wallet bg-warning-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">Toatal Profit</span> <a href="#"
                                                                                                 class="float-left tx-11 text-muted">1
                                hour ago</a>
                            <p class="mb-0 text-muted tx-12">3k New profit</p>
                        </li>
                        <li class="mt-0"><i class="si si-eye bg-purple-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">Customer Visits</span> <a href="#"
                                                                                                   class="float-left tx-11 text-muted">1
                                day ago</a>
                            <p class="mb-0 text-muted tx-12">15% increased</p>
                        </li>
                        <li class="mt-0 mb-0"><i
                                class="icon-note icons bg-primary-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">Customer Reviews</span> <a href="#"
                                                                                                    class="float-left tx-11 text-muted">1
                                day ago</a>
                            <p class="mb-0 text-muted tx-12">1.5k reviews</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h3 class="card-title mb-2">Recent Orders</h3>
                    <p class="tx-12 mb-0 text-muted">An order is an investor's instructions to a broker or brokerage
                        firm to purchase or sell</p>
                </div>
                <div class="card-body sales-info ot-0 pt-0 pb-0">
                    <div id="chart" class="ht-150"></div>
                    <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                        <div class="col-md-6 col">
                            <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>Delivered</p>
                            <h3 class="mb-1">5238</h3>
                            <div class="d-flex">
                                <p class="text-muted ">Last 6 months</p>
                            </div>
                        </div>
                        <div class="col-md-6 col">
                            <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Cancelled</p>
                            <h3 class="mb-1">3467</h3>
                            <div class="d-flex">
                                <p class="text-muted">Last 6 months</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center pb-2">
                                <p class="mb-0">Total Sales</p>
                            </div>
                            <h4 class="font-weight-bold mb-2">$7,590</h4>
                            <div class="progress progress-style progress-sm">
                                <div class="progress-bar bg-primary-gradient wd-80p" role="progressbar"
                                     aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 mt-md-0">
                            <div class="d-flex align-items-center pb-2">
                                <p class="mb-0">Active Users</p>
                            </div>
                            <h4 class="font-weight-bold mb-2">$5,460</h4>
                            <div class="progress progress-style progress-sm">
                                <div class="progress-bar bg-danger-gradient wd-75" role="progressbar" aria-valuenow="45"
                                     aria-valuemin="0" aria-valuemax="45"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row close -->

    <!-- row opened -->
    <div class="row row-sm row-deck d-flex justify-content-center">

        <div class="col-md-12 col-lg-12  ">
            <div class="container-fluid">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">Your Most Recent Earnings</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <span class="tx-12 tx-muted mb-3 ">This is your most recent earnings for today's date.</span>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                            <tr>
                                <th class="wd-lg-25p">Date</th>
                                <th class="wd-lg-25p tx-right">Sales Count</th>
                                <th class="wd-lg-25p tx-right">Earnings</th>
                                <th class="wd-lg-25p tx-right">Tax Witheld</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>05 Dec 2019</td>
                                <td class="tx-right tx-medium tx-inverse">34</td>
                                <td class="tx-right tx-medium tx-inverse">$658.20</td>
                                <td class="tx-right tx-medium tx-danger">-$45.10</td>
                            </tr>
                            <tr>
                                <td>06 Dec 2019</td>
                                <td class="tx-right tx-medium tx-inverse">26</td>
                                <td class="tx-right tx-medium tx-inverse">$453.25</td>
                                <td class="tx-right tx-medium tx-danger">-$15.02</td>
                            </tr>
                            <tr>
                                <td>07 Dec 2019</td>
                                <td class="tx-right tx-medium tx-inverse">34</td>
                                <td class="tx-right tx-medium tx-inverse">$653.12</td>
                                <td class="tx-right tx-medium tx-danger">-$13.45</td>
                            </tr>
                            <tr>
                                <td>08 Dec 2019</td>
                                <td class="tx-right tx-medium tx-inverse">45</td>
                                <td class="tx-right tx-medium tx-inverse">$546.47</td>
                                <td class="tx-right tx-medium tx-danger">-$24.22</td>
                            </tr>
                            <tr>
                                <td>09 Dec 2019</td>
                                <td class="tx-right tx-medium tx-inverse">31</td>
                                <td class="tx-right tx-medium tx-inverse">$425.72</td>
                                <td class="tx-right tx-medium tx-danger">-$25.01</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
    <!-- Internal Map -->
    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Echart Plugin -->
    <script src="{{URL::asset('assets/plugins/echart/echart.js')}}"></script>
    <script>


        var chartdata = [{
            name: 'المبيعات',
            type: 'bar',
            barMaxWidth: 20,
            @php
                $i=count($total_after)-1;
            @endphp
            data: [
                @foreach($total_after as $item )
                    {{$item->total}}
                    @if($i)
                ,
                @endif
                @endforeach
            ]
        }, {
            name: 'الربح',
            type: 'bar',
            barMaxWidth: 20,
            @php
                $i=count($profit)-1;
            @endphp
            data: [
                @foreach($profit as $item )
                    {{$item->total}}
                    @if($i)
                ,
                @endif
                @endforeach
            ]
        }];
        var chart = document.getElementById('echart1');
        var barChart = echarts.init(chart);
        var option = {
            valueAxis: {
                axisLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: ['rgba(171, 167, 167,0.2)']
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: ['rgba(171, 167, 167,0.2)']
                    }
                }
            },
            grid: {
                top: '6',
                right: '0',
                bottom: '17',
                left: '25',
            },
            xAxis: {
                @php
                    $i=count($total_after)-1;
                @endphp
                data: [
                    @foreach($total_after as $item )
                        {{$item->month}}
                        @if($i)
                    ,
                    @endif
                    @endforeach
                ],
                axisLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#5f6d7a'
                }
            },
            tooltip: {
                trigger: 'axis',
                position: ['35%', '32%'],
            },
            yAxis: {
                splitLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#5f6d7a'
                }
            },
            series: chartdata,
            color: ['#285cf7', '#f7557a']
        };
        barChart.setOption(option);

    </script>
@endsection
