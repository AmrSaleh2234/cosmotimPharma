@extends('layouts.master')

@section('title')
    المصروفات
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
                    المصروفات/</span>
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
                        <h3 class="card-title mg-b-0">جدول المصروفات </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <a class=" btn btn-outline-primary btn-block" style="width: 300px;margin-top: 20px"
                       href="{{ route('expenses.create') }}">اضافة المصروفات
                    </a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table text-md-nowrap" id="example1">
                            @php
                                $i = 0;
                            @endphp
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0 ">#</th>

                                <th class="wd-15p border-bottom-0">اسم الحساب</th>
                                <th class="wd-15p border-bottom-0">صرف</th>

                                <th class="wd-15p border-bottom-0" style="width: 69px">العمليات</th>
                                <th class="wd-15p border-bottom-0"> المنشئ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($account as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->name }}</td>

                                    <td class="text-center">
                                        <a class="btn btn-danger-gradient ml-2 btn-fixed" data-id="{{$item->id}}"
                                           data-effect="effect-flip-vertical"
                                           data-toggle="modal" href="#modaldemo4"><i
                                                class="mdi mdi-cash-multiple tx-20 "></i></a>
                                    </td>

                                    <td>
                                        <button data-toggle="dropdown" class="btn btn-outline-primary btn-block "
                                                style="width: 150px">العمليات <i
                                                class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('expenses.edit', $item) }}"
                                               class="dropdown-item">تعديل</a>

                                            <a class="dropdown-item text-danger" data-effect="effect-flip-vertical"
                                               data-toggle="modal" href="#modaldemo2" data-id="{{ $item->id }}"
                                               data-name="{{ $item->name }}">حذف</a>


                                        </div><!-- dropdown-menu -->


                                        <div class="modal" id="modaldemo2">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">حذف المنتج</h6>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <h4>هل انت متأكد من عمليه الحذف</h4>
                                                    <form action="{{ route('expenses.destroy') }}" method="post">
                                                        <div class="modal-body">

                                                            @csrf

                                                            <input name="id" id="id" type="hidden">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn ripple btn-danger" type="submit">حذف
                                                                المنتج
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


                                    </td>
                                    <td class="text-primary">{{ $item->created_by }}</td>
                                </tr>
                            @endforeach
                            <div class="modal" id="modaldemo4">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">دفع نقديه</h6>
                                            <button aria-label="Close" class="close"
                                                    data-dismiss="modal" type="button">
                                                <span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <form action="{{route('expenses.pay')}}" method="post">
                                            <div class="modal-body">

                                                @csrf
                                                <input type="hidden" name="id" id="id">
                                                <div class="form-group">
                                                    <label> المبلغ المدفوع </label>
                                                    <input class="form-control " type="number"
                                                           name="payed">المتبقي من الحساب : <span
                                                        class="text-danger" id="not-payed2"></span>

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
    <script>
        $('#modaldemo1').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_id = button.data('product_id')
            var quantity = button.data('quantity')
            var price_before = button.data('price_before')
            var price_after = button.data('price_after')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_id').val(product_id);
            modal.find('.modal-body #quantity').val(quantity);
            modal.find('.modal-body #price_before').val(price_before);
            modal.find('.modal-body #price_after').val(price_after);
        })
    </script>
    <script>
        $('#modaldemo2').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')

            var modal = $(this)
            modal.find('.modal-body #id').val(id);

        })
    </script>
    <script>
        $('document').ready(function () {
            $('#modaldemo4').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')

                var modal = $(this)
                modal.find('.modal-body #id').val(id);


            })

        })
    </script>
@endsection
