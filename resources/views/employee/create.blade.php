@extends('layouts.master')
@section('title')
    انشاء موظف
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">موظف</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ انشاء</span>
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
                        <h3 class="card-title mg-b-0">انشاء موظف </h3>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>


                </div>
                <div class="card-body">
                    <form action="{{route('employee.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ادخل اسم الموظف</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>ادخل العنوان</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <div class="form-group">
                                    <label> الراتب المستحق لاول مرة بأيام الغياب و المكافات </label>
                                    <input type="number" min="0" value="0" class="form-control" name="balance">
                                </div>
                                

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ادخل رقم الهاتف</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                                <div class="form-group">
                                    <label>ادخل الراتب</label>
                                    <input type="number" min="100" class="form-control" name="salary">
                                </div>
                                <div class="form-group">
                                    <label>يوم الراتب</label>
                                    <input type="number"  class="form-control" name="salary_day">
                                </div>

                                
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary w-25">حفظ</button>


                    </form>


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

        

    </script>
@endsection
