<?php

namespace App\Http\Controllers;

use App\Models\employee;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = employee::where('com_code', auth()->user()->com_code)->get();
        return view('employee.index', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'balance' => 'required|integer',
            'salary' => 'required|integer|min:100',
            'salary_day' => 'required|integer|min:1|max:30',


        ], [
            'name.required' => 'ادخل اسم الحساب',
            'name.string' => 'ادخل حروف فقط',
            'balance.required' => 'ادخل الراتب المستحق للموظف',
            'salary.required' => 'ادخل الراتب  للموظف',
            'salary_day.required' => 'ادخل يوم الحصول علي الراتب  ',
            'salary_day.min' => ' ادخل  يوم من 1 ال 30 ',
            'salary_day.max' => ' ادخل  يوم من 1 ال 30 ',
        ]);
        employee::create([
            'name' => $request->name,
            'salary' => $request->salary,
            'salary_day' => $request->salary_day,
            'address' => $request->address,
            'phone' => $request->phone,
            'balance' => $request->balance,
            'start_balance' => $request->balance,
            'com_code' => $this->getAuthData('com_code'),
            'created_by' => $this->getAuthData('name'),
        ]);
        return $this->success('تم اضافة الموظف بنجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(employee $employee)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(employee $employee)
    {
        return view('employee.edit', compact('employee'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'balance' => 'required|integer',
            'salary' => 'required|integer|min:100',
            'salary_day' => 'required|integer|min:1|max:30',


        ], [
            'name.required' => 'ادخل اسم الحساب',
            'name.string' => 'ادخل حروف فقط',
            'balance.required' => 'ادخل الراتب المستحق للموظف',
            'salary.required' => 'ادخل الراتب  للموظف',
            'salary_day.required' => 'ادخل يوم الحصول علي الراتب  ',
            'salary_day.min' => ' ادخل  يوم من 1 ال 30 ',
            'salary_day.max' => ' ادخل  يوم من 1 ال 30 ',
        ]);
        $employee->update([
            'name' => $request->name,
            'salary' => $request->salary,
            'salary_day' => $request->salary_day,
            'address' => $request->address,
            'phone' => $request->phone,
            'balance' => ($employee->balance - $employee->start_balance) + $request->balance,
            'start_balance' => $request->balance,
            'com_code' => $this->getAuthData('com_code'),
            'created_by' => $this->getAuthData('name'),
        ]);

        return $this->success('تم تعديل الموظف بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee = employee::find($request->id);
        if ($employee->balance)
            return $this->error('لابد من صرف مستحقات الموظف اولا');

        $employee->delete();
        return $this->success('تم حذف الموظف بنحاح ');


    }




    //created function*****************************************************************

    //take absent
    public function absent(employee $employee)
    {
        $salaryDay = $employee->salary / 30;
        if ($employee->com_code != $this->getAuthData('com_code')) {
            return $this->error('غير مسموح بالتحكم بهذا الموظف');
        }
        if (count($employee->employee_datails()->whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('type', 1)->get()) > 0) {
            return $this->error('لقد تم تسجيل الغياب بالفعل ');
        }
        $employee->employee_datails()->create(['type' => 1, 'done' => 0, 'amount' => $salaryDay, 'created_by' => $this->getAuthData('name')]);
        $employee->update(['balance' => $employee->balance - $salaryDay]);
        return $this->success('تم تسجيل الغياب');
    }

    public function attendance(employee $employee)
    {
        $salaryDay = $employee->salary / 30;
        if ($employee->com_code != $this->getAuthData('com_code')) {
            return $this->error('غير مسموح بالتحكم بهذا الموظف');
        }
        $employee->employee_datails()->whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('type', 1)->first()->delete();
        $employee->update(['balance' => $employee->balance + $salaryDay]);
        return $this->success('تم تعديل الغياب لحضور');
    }

    public function reward(Request $request, employee $employee)
    {
        $employee->update([
            'balance' => $employee->balance + $request->reward
        ]);
        $employee->employee_datails()->create(['type' => "2", 'amount' => $request->reward, 'done' => 0, 'created_by' => $this->getAuthData('com_code')]);

        return $this->success('جم' . $request->reward . "تم اضافة المكافأه قدرها ");
    }
}
