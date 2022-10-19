@extends('layouts.master')
@section('title')
    عرض فواتير المبيعات
@endsection
@section('css')
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">العملاء </h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/فواتير المبيعات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row d-flex flex-wrap">
        <div class="col-lg-7 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">فواتير المبيعات</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th class="wd-2">رقم الفاتورة</th>
                                    <th class="">اسم العميل</th>
                                    <th class="wd-5p">قيمة الفاتورة </th>
                                    <th class="wd-5p">المدفوع </th>
                                    <th class="wd-5">منشئ الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th class="d-flex justify-content-center">العمليات</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->customer->name}}</td>
                                        <td class="">{{$item->total_after}}</td>
                                        <td class="text-success">{{$item->payed}}</td>
                                        <td class="text-primary">{{$item->created_by}}</td>
                                        <td class="text-nowrap">{{$item->created_at->format(' H:i Y-m-d')}}</td>

                                        <td class="d-flex no-wrap align-items-center ">
                                            <button class="btn btn-primary ml-2 btn-fixed btn-view"
                                                    onclick="order(this);"
                                                    data-id="{{$item->id}}"
                                                    data-url="{{route('invoice_customer.orderDetails',$item)}}"><i
                                                    class="typcn typcn-eye-outline tx-20 "></i></button>
                                            <a class="btn btn-warning-gradient ml-2 btn-fixed" href="{{route('invoice_customer.edit',$item->id)}}"><i
                                                    class="typcn typcn-edit tx-20 "></i></a>
                                            <button class="btn btn-danger-gradient ml-2 btn-fixed"  onclick="getElementById('delete_invoice_customer').submit()"><i
                                                    class="typcn typcn-delete-outline tx-20 "></i></button>
                                            <form id ="delete_invoice_customer" method="post" action="{{route('invoice_customer.destroy',$item)}}" style="display: none">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-5 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">الفاتورة</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>

                    <div class="card-body" id="tbody">
                        <div id="loader" style="display: none">
                            <img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
                        </div>

                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <button class="btn btn-primary-gradient w-75"><i class="typcn typcn-printer tx-20 "></i>اطبع
                        </button>
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
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script>

    </script>
    <script>
        function order(identfier) {

            var url = $(identfier).data('url');
            $('#loader').css('display', 'block')

            $.ajax(
                {
                    url: url,
                    method: 'get',
                    success: function (data) {
                        $('#loader').css('display', 'none')
                        $('#tbody').empty()
                        $('#tbody').append(data)
                    }
                }
            )
        }

    </script>

@endsection
