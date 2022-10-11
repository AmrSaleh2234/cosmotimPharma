@extends('layouts.master')

@section('title')
    products
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /المنتجات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title mg-b-0">جدول المنتجات </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-flip-vertical"
                       data-toggle="modal" href="#modaldemo8" style="width: 300px;margin-top: 20px">اضافة منتج </a>
                    <div class="modal" id="modaldemo8">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافة منتج</h6>
                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('product.store')}}" method="post">
                                    <div class="modal-body">

                                        @csrf
                                        <div class="form-group">
                                            <label>اسم المنتج</label>
                                            <input class="form-control" type="text" name="product_name">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">اضف المنتج</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @php
                            $i=0;
                        @endphp
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">اسم المنتج</th>

                                <th class="wd-10p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product as $item)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$item->name}}</td>

                                    <td>
                                        <a class="modal-effect btn btn-primary" data-effect="effect-flip-vertical"
                                           data-toggle="modal" href="#modaldemo1" data-id="{{$item->id}}"
                                           data-name="{{$item->name}}">تعديل</a>
                                        <div class="modal" id="modaldemo1">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">تعديل المنتج</h6>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{route('product.edit')}}" method="post">
                                                        <div class="modal-body">

                                                            @csrf
                                                            <div class="form-group">
                                                                <label>اسم المنتج</label>
                                                                <input class="form-control" type="text"
                                                                       id="edit_product_name" name="product_name">
                                                            </div>
                                                            <input name="id" id="id" type="hidden">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn ripple btn-primary" type="submit">تعديل
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

                                        <a class="modal-effect btn btn-danger" data-effect="effect-flip-vertical"
                                           data-toggle="modal" href="#modaldemo2" data-id="{{$item->id}}"
                                           data-name="{{$item->name}}">حذف</a>
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
                                                    <form action="{{route('product.destroy')}}" method="post">
                                                        <div class="modal-body">

                                                            @csrf

                                                            <input name="id" id="id" type="hidden"
                                                                  >

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
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
    <script>
        $('#modaldemo1').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var section_name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #edit_product_name').val(section_name);
        })
    </script>
    <script>
        $('#modaldemo2').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var section_name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);

        })
    </script>


@endsection
