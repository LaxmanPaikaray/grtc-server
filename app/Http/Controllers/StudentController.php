<?php

namespace App\Http\Controllers;

use App\Filters\StudentFilter;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $filter = new StudentFilter();
        $filterItems = $filter->transform($request);
        $students = Student::where($filterItems);
        return StudentResource::collection($students->paginate()->appends($request->query()));
    }

    public function store(Request $request)
    {
        $x = $request;
        return new StudentResource(Student::create($x->all()));
    }

    public function show(Student  $student)
    {
        return new StudentResource($student);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
    }

    public function destroy(Student $student)
    {
        $student->delete();
    }
}
