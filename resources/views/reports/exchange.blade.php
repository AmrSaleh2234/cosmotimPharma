@extends('layouts.master')

@section('title')
    العملاء
@endsection
@section('css')
    <!-- Internal Data table css -->
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
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    الحسابات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card card_top">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">جدول حركة الخزينه </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table key-buttons  " id="example">
                            @php
                                $i = 0;
                            @endphp
                            <thead>
                            <tr>
                                <th class=" border-bottom-0  "  style="width: 20%">#</th>
                                <th class=" border-bottom-0 " style="width: 20%">نوع الحساب</th>
                                <th class=" border-bottom-0 " style="width: 20%">اسم الحساب</th>
                                <th class=" border-bottom-0 " style="width: 20%">القيمة</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($exchange as $item)
                                <tr>
                                    <td>{{ ++$i}}</td>
                                    {{--                                    start name of account--}}
                                    @if($item->type==1)
                                        <td>مورد</td>
                                        <td class="text-primary">{{\App\Models\supplier::where('id',$item->fk)->first()->name}}</td>
                                    @elseif($item->type==2)
                                        <td>عميل</td>
                                        <td class="text-primary">{{\App\Models\customer::where('id',$item->fk)->first()->name}}</td>
                                    @elseif($item->type==3)
                                        <td>فاتورة مشتريات</td>
                                        <td class="text-primary">{{\App\Models\invoice_supplier::where('id',$item->fk)->first()->supplier->name}}</td>
                                    @elseif($item->type==4)
                                        <td>فاتورة مبيعات</td>
                                        <td class="text-primary">{{\App\Models\invoice_customer::where('id',$item->fk)->first()->customer->name}}</td>
                                    @elseif($item->type==5)
                                        <td>موظف</td>
                                        <td class="text-primary">{{\App\Models\employee::where('id',$item->fk)->first()->name}}</td>
                                    @elseif($item->type==6)
                                        <td>رأس مال</td>
                                        <td class="text-primary">{{\App\Models\capital::where('id',$item->fk)->first()->name}}</td>
                                    @elseif($item->type==7)
                                        <td>هدية</td>
                                        <td class="text-primary" style="width:130px">{{\App\Models\gift::where('id',$item->fk)->first()->description}}</td>
                                    @elseif($item->type==8)
                                        <td>مصروفات</td>
                                        <td class="text-primary">{{\App\Models\expenses::where('id',$item->fk)->first()->name}}</td>
                                    @endif
                                    {{--                                    end name of account--}}
                                    @if($item->amount>=0)
                                        <td class="text-success">{{$item->amount}}</td>
                                    @else
                                        <td class="text-danger">{{$item->amount}}</td>
                                    @endif
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

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
    <!-- Internal Data tables -->
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

@endsection
