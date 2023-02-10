@extends('layouts.master')
@section('title')
    عرض فواتير المبيعات
@endsection
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">العملاء </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/فواتير
                    المبيعات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @php
        $c=-1;
        if(isset($customer))
            {
                 $c=$customer;
            }
    @endphp
    @if(isset($customer))
        <a class="btn btn-primary" href="{{route('customer.invoicesInTable',$customer)}}">رؤية عامة للعميل </a>

    @endif

    <div class="row d-flex flex-wrap">
        <div class="col-lg-8 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">فواتير المبيعات</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="card-body">
                        <form action="{{route('invoice_customer.searchDate',['customer'=>$c])}}" method="get" class="mb-3">
                            @csrf
                            <div class="row">
                                <div class="input-group col-5 ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input autocomplete="off" class="form-control fc-datepicker" placeholder="YYYY/MM/DD" type="text" name="firstDate">
                                </div>
                                <div class="input-group col-5 ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input autocomplete="off" class="form-control fc-datepicker" placeholder="YYYY/MM/DD" type="text" name="secondDate">
                                </div>

                                <div class="col-2" >
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ion-ionic  ion ion-md-search tx-24 lh--9 op-6 "></i>
                                    </button>
                                </div>

                            </div>


                        </form>
                        <div class="table-responsive">
                            {{--                            <div id="invoiceSearch" class="">--}}
                            {{--                                <label>--}}
                            {{--                                    <input type="search"--}}
                            {{--                                           class="form-control form-control-sm"--}}
                            {{--                                           placeholder="Search..."--}}
                            {{--                                           aria-controls="example">--}}
                            {{--                                </label>--}}
                            {{--                            </div>--}}
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th class="wd-2">رقم الفاتورة</th>
                                    <th class="">اسم العميل</th>
                                    <th class="wd-5p">قيمة الفاتورة</th>
                                    <th class="wd-5p">المدفوع</th>

                                    <th>التاريخ</th>
                                    <th>تحصيل</th>
                                    <th class="d-flex justify-content-center ">العمليات</th>
                                    <th class="">منشئ الفاتورة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoices as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{$item->customer->name}}</td>
                                        <td class="">{{ $item->total_after }}</td>
                                        <td class="text-success">{{ $item->payed }}</td>
                                        <td class="text-nowrap">{{ $item->created_at->format(' H:i Y-m-d') }}</td>
                                        <td>
                                            <a class="btn btn-success-gradient ml-2 btn-fixed" data-id="{{$item->id}}"

                                               title="تحصيل الفاتورة"
                                               data-not_payed="{{$item->total_after- $item->payed}}"
                                               data-effect="effect-flip-vertical"
                                               data-toggle="modal" href="#modaldemo8"><i
                                                    class="mdi mdi-cash-multiple tx-20 "></i></a>
                                        </td>

                                        <td class="d-flex no-wrap align-items-center ">
                                            <button class="btn btn-primary ml-2 btn-fixed btn-view"
                                                    title="تفاصيل الفاتورة"
                                                    onclick="order(this);" data-id="{{ $item->id }}"
                                                    data-url="{{ route('invoice_customer.orderDetails', $item) }}"
                                                    data-url_print="{{route('invoice_customer.print',$item->id)}}"><i
                                                    class="typcn typcn-eye-outline tx-20 "></i></button>
                                            <a class="btn btn-warning-gradient ml-2 btn-fixed" title="تعديل"
                                               href="{{ route('invoice_customer.edit', $item->id) }}"><i
                                                    class="typcn typcn-edit tx-20 "></i></a>
                                            <button class="btn btn-danger-gradient ml-2 btn-fixed" title="حذف"
                                                    onclick="getElementById('delete_invoice_customer-{{$item->id}}').submit()">
                                                <i
                                                    class="typcn typcn-delete-outline tx-20 "></i></button>
                                            <form id="delete_invoice_customer-{{$item->id}}" method="post"
                                                  action="{{ route('invoice_customer.destroy', $item) }}"
                                                  style="display: none">
                                                @csrf
                                            </form>
                                            <button class="btn btn-purple-gradient ml-2 btn-fixed"
                                                    data-id="{{$item->id}}" title="تفاصيل الدفع"
                                                    data-effect="effect-flip-vertical"
                                                    data-url="{{ route('invoice_customer.payment', $item) }}"
                                                    data-toggle="modal" onclick="payment(this)"><i
                                                    class=" typcn typcn-info-large-outline tx-20 "></i></button>
                                            <a class="btn btn-warning btn-fixed" title="مرتجعات"
                                               href="{{route('invoice_customer.return', $item->id)}}"><i
                                                    class=" typcn typcn-refresh-outline tx-20 "></i></a>
                                        </td>
                                        <td class="text-primary">{{ $item->created_by }}</td>

                                    </tr>
                                @endforeach
                                <div class="modal" id="modaldemo8">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">صرف نقديه نظير فاتورة شراء</h6>
                                                <button aria-label="Close" class="close"
                                                        data-dismiss="modal" type="button">
                                                    <span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form action="{{route('invoice_customer.collect')}}" method="post">
                                                <div class="modal-body">

                                                    @csrf
                                                    <input type="hidden" name="id" id="id">
                                                    <div class="form-group">
                                                        <label> المبلغ المدفوع </label>
                                                        <input class="form-control " type="number"
                                                               name="payed">المتبقي من ثمن الفاتورة <span
                                                            class="text-danger" id="not-payed"></span>

                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn ripple btn-primary" type="submit">
                                                        تحصيل
                                                    </button>
                                                    <button class="btn ripple btn-secondary"
                                                            data-dismiss="modal" type="button">
                                                        Close
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">الفاتورة</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>

                    <div class="card-body" id="tbody">
                        <div id="loader" style="display: none">
                            <img src="{{ URL::asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
                        </div>

                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <a class="btn btn-primary-gradient w-75" href="" target="_blank" id="print-btn"
                           data-idInvoice="" data-url=""><i
                                class="typcn typcn-printer tx-20 "></i>اطبع
                        </a>
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

    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script>
        $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true
        });
    </script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>


    <script>
        function order(identfier) {


            var url = $(identfier).data('url');
            var url_print = $(identfier).data('url_print');
            var id = $(identfier).data('id');
            $('#loader').css('display', 'block')

            $.ajax({
                url: url,
                method: 'get',
                success: function (data) {
                    $('#loader').css('display', 'none')
                    $('#tbody').empty()
                    $('#tbody').append(data)


                    document.getElementById('print-btn').setAttribute('href', url_print)

                    // $('#printContent').empty()
                    // $('#printContent').append(data)
                    // $('#number_invoice').empty()
                    // $('#number_invoice').append(id)

                }
            })
        }


    </script>
    <script>
        $('#modaldemo8').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var not_payed = button.data('not_payed')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #not-payed').html(not_payed);

        })
    </script>
    <script>

        function payment(identfier) {

            var url = $(identfier).data('url')


            $('#loader').css('display', 'block')
            $.ajax({
                url: url,
                method: 'get',
                success: function (data) {
                    $('#loader').css('display', 'none')
                    $('#tbody').empty()
                    $('#tbody').append(data)

                }


            })
        }


    </script>
@endsection

