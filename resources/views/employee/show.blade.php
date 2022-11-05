@extends('layouts.master')
@section('title')
    انشاء موظف
@endsection
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">موظف</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ انشاء</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row ">
        <div class="col-xl-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0"> عرض الموظف</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>


                </div>
                <div class="card-body">
                    <h1>الغياب و المكافأت و السلف</h1>

                    <div class="row">
                        <div class="col-6 pl-5">

                            <div class="table-responsive">

                                <table class="table " id="example1">
                                    @php
                                        $i = 0;
                                    @endphp
                                    <thead>
                                    <tr>
                                        <th>اليوم</th>
                                        <th>القيمة</th>
                                        <th>الحدث</th>
                                        <th>المنشئ</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employee->employee_datails as $item)
                                        <tr>
                                            <td>{{$item->created_at->format('H:i || d-m-Y')}}</td>
                                            <td>{{$item->amount}}</td>
                                            @if($item->type==1)
                                                <td class="text-danger">غياب</td>
                                            @elseif($item->type == 2 )

                                                <td class="text-success">مكافأة</td>
                                            @else
                                                <td>سلفة</td>
                                            @endif
                                            <td>{{$item->created_by}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>


                                </table>
                            </div>

                        </div>
                        <div class="col-6">
                            <h1>صرف المرتب </h1>
                            <div class="table-responsive">

                                <table class="table " id="example2">
                                    @php
                                        $i = 0;
                                    @endphp
                                    <thead>
                                    <tr>
                                        <th>اليوم</th>
                                        <th>القيمة</th>
                                        <th>المنشئ</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employee->exchangeRevenue as $item)
                                        <tr>
                                            <td>{{$item->created_at->format('H:i || d-m-Y')}}</td>
                                            <td>{{abs($item->amount)}}</td>

                                            <td>{{$item->created_by}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>


                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    </script>
@endsection
