@extends('layouts.master')
@section('title')
    عرض فواتير المشتريات
@endsection
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموردين </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/فواتير
                    المشتريات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row d-flex flex-wrap">
        <div class="col-lg-8 col-sm-12">
            <div class="card" style="border-top:3px solid cadetblue">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">فواتير المشتريات</h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                <tr>
                                    <th class="wd-sm-5">رقم الفاتورة</th>
                                    <th class="wd-sm-5">اسم المورد</th>
                                    <th class="wd-sm-10">قيمة الفاتورة</th>
                                    <th class="">المدفوع</th>
                                    <th class="">التاريخ</th>
                                    <th class="">دفع</th>
                                    <th class="">العمليات</th>
                                    <th class="">منشئ الفاتورة</th>


                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoices as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->supplier->name }}</td>
                                        <td class="">{{ $item->total }}</td>
                                        <td class="@if($item->payed==$item->total)text-success @else text-pink @endif ">{{ $item->payed }}</td>

                                        <td class="text-nowrap">{{ $item->created_at->format(' H:i d-m-Y') }}</td>
                                        <td class="text-nowrap">
                                            <a class="btn btn-danger-gradient ml-2 btn-fixed" data-id="{{$item->id}}"
                                               data-not_payed="{{$item->total- $item->payed}}"
                                               data-effect="effect-flip-vertical"
                                               data-toggle="modal" href="#modaldemo8"><i
                                                    class="mdi mdi-cash-multiple tx-20 "></i></a>
                                        </td>

                                        <td class=" ">
                                            <div class="d-flex no-wrap align-items-center">
                                                <button class="btn btn-primary ml-2 btn-fixed btn-view"
                                                        onclick="order(this);" data-id="{{ $item->id }}" data-url_print="{{route('invoice_supplier.print',$item)}}"
                                                        data-url="{{ route('invoice_supplier.orderDetails', $item) }}">
                                                    <i
                                                        class="typcn typcn-eye-outline tx-20 "></i></button>
                                                <a class="btn btn-warning-gradient ml-2 btn-fixed"
                                                   href="{{ route('invoice_supplier.edit', $item->id) }}"><i
                                                        class="typcn typcn-edit tx-20 "></i></a>
                                                <button class="btn btn-danger ml-2 btn-fixed"
                                                        onclick="getElementById('delete_invoice_supplier-{{$item->id}}').submit()">
                                                    <i
                                                        class="typcn typcn-delete-outline tx-20 "></i></button>
                                                <form id="delete_invoice_supplier-{{$item->id}}" method="post"
                                                      action="{{ route('invoice_supplier.destroy', $item) }}"
                                                      style="display: none">
                                                    @csrf
                                                </form>
                                                <button class="btn btn-purple-gradient ml-2 btn-fixed"
                                                        data-id="{{$item->id}}"
                                                        data-effect="effect-flip-vertical"
                                                        data-toggle="modal" onclick="payment(this)"><i
                                                        class=" typcn typcn-info-large-outline tx-20 "></i></button>
                                            </div>

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
                                            <form action="{{route('invoice_supplier.pay')}}" method="post">
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
                                                        ادفع
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
   </div>
</div>
    <!-- row closed -->
    <!-- Container closed -->
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
    <!--Internal  Datatable js -->
    <script>
        $(function (e) {
            //file export datatable
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'colvis'],
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                }


            });


            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
            $('#example_filter input').on('change', function () {
                var search = $(this);
                table
                    .column(0)
                    .search(search.val())
                    .draw();

            });
        })

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
        function order(identfier) {


            var url = $(identfier).data('url');
            var url_print = $(identfier).data('url_print');
            $('#loader').css('display', 'block')
            $.ajax({
                url: url,
                method: 'get',
                success: function (data) {
                    $('#loader').css('display', 'none')
                    $('#tbody').empty()
                    $('#tbody').append(data)
                    document.getElementById('print-btn').setAttribute('href', url_print)
                }
            })
        }


    </script>
    <script>

        function payment(identfier) {

            var id = $(identfier).data('id')


            $('#loader').css('display', 'block')
            $.ajax({
                url: "supplier_invoice/payment/" + id,
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
