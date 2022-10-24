@extends('layouts.master')

@section('title')
    الموظفين
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        td{
            text-align: center;
        }
        th{
            text-align: center !important;
        }
        @media (max-width: 767px){
            .address  {
            width: 150px !important;
        }}
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    الموظفين/</span>
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
                        <h3 class="card-title mg-b-0">جدول الموظفين </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <a class=" btn btn-outline-primary btn-block" style="width: 300px;margin-top: 20px"
                       href="{{ route('employee.create') }}">اضافة موظف
                    </a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table " id="example1">
                            @php
                                $i = 0;
                            @endphp
                            <thead>
                            <tr>
                                <th class=" border-bottom-0 ">#</th>
                                <th class="  border-bottom-0">اسم الحساب</th>
                                <th class=" border-bottom-0">رقم الهاتف</th>
                                <th class=" border-bottom-0" style="width: 15%!important;">العنوان</th>
                                <th class="  border-bottom-0">الحساب</th>
                                <th class=" border-bottom-0"> عرض</th>
                                <th class=" border-bottom-0"> غياب</th>
                                <th class=" text-center border-bottom-0 " >العمليات</th>
                                <th class=" border-bottom-0"> المنشئ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($account as $item)
                                @if($item->salary_date == \Illuminate\Support\Carbon::now()->format('d'))

                                    <tr style="border: navy">
                                @else
                                    <tr>
                                        @endif
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td >
                                            <div class="address" style="text-align: right !important;width: 200px">
                                                {{ $item->address }}
                                            </div>
                                        </td>

                                        @if ($item->balance < 0)
                                            <td><span>مخصوم : {{ $item->balance }}</span>
                                            </td>
                                        @elseif($item->balance > 0)
                                            <td><span> مستحق
                                                    {{ $item->balance }}</span></td>
                                        @elseif($item->balance == 0)
                                            <td> 0</td>
                                        @endif
                                        <td class="text-center">
                                            <a class="btn btn-primary ml-2 btn-fixed btn-view" href=""><i
                                                    class="typcn typcn-eye-outline tx-20 "></i></a>
                                        </td>


                                        <td class="text-center">
                                            @if($item->employee_datails()->whereDate('created_at', \Illuminate\Support\Carbon::now()->format('Y-m-d'))->get()->isEmpty())

                                                <a class=" btn btn-danger d-flex justify-content-center  "
                                                   href="{{route('employee.absent',$item)}}"
                                                   style="width:10px; cursor:pointer ;">
                                                    <i class="typcn typcn-user-delete-outline tx-20 "></i>
                                                </a>
                                            @else

                                                <a class=" btn btn-success d-flex justify-content-center "
                                                   href="{{route('employee.attendance',$item)}}"
                                                   style="width:10px; cursor:pointer;">
                                                    <i class="typcn typcn-user-add-outline tx-20 "></i>
                                                </a>
                                            @endif

                                        </td>


                                        <td class="d-flex justify-content-center">
                                            <button data-toggle="dropdown" class="btn btn-outline-primary btn-block "
                                                    style="width: 150px">العمليات <i
                                                    class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>


                                            <div class="dropdown-menu">

                                                <a href="{{ route('employee.edit', $item) }}"
                                                   class="dropdown-item text-orange font-weight-bolder">صرف المرتب</a>

                                                <a class="dropdown-item text-purple " data-effect="effect-flip-vertical"
                                                   data-toggle="modal" href="#modaldemo1" data-id="{{$item->id}}">اضافة
                                                    مكافأة علي الراتب</a>
                                                <a href="{{ route('employee.edit', $item) }}"
                                                   class="dropdown-item text-primary">تعديل</a>

                                                <a class="dropdown-item text-danger" data-effect="effect-flip-vertical"
                                                   data-toggle="modal" href="#modaldemo2" data-id="{{ $item->id }}"
                                                   data-name="{{ $item->name }}">حذف</a>


                                            </div><!-- dropdown-menu -->

                                            <div class="modal" id="modaldemo1">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">ادخل المكافأه</h6>
                                                            <button aria-label="Close" class="close"
                                                                    data-dismiss="modal"
                                                                    type="button">
                                                                <span aria-hidden="true">&times;</span></button>
                                                        </div>

                                                        <form action="{{ route('employee.reward',$item) }}"
                                                              method="post">
                                                            <div class="modal-body">

                                                                @csrf

                                                                <input name="id" id="id" type="hidden">
                                                                <div class="form-group">
                                                                    <label>دخل قيمة المكافأه للموظف </label>
                                                                    <input name="reward" id="reward_input" type="number"
                                                                           min="10">
                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-primary-gradient"
                                                                        type="submit">
                                                                    حفظ
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

                                            <div class="modal" id="modaldemo2">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">حذف الموظف</h6>
                                                            <button aria-label="Close" class="close"
                                                                    data-dismiss="modal"
                                                                    type="button">
                                                                <span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <h4>هل انت متأكد من عمليه الحذف</h4>
                                                        <form action="{{ route('employee.destroy') }}" method="post">
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
                                        <td class="text-success">{{ $item->created_by }}</td>
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
    <script>

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





    </script>
@endsection
