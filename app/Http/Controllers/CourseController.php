<?php

namespace App\Http\Controllers;

use App\Filters\CourseFilter;
use App\Http\Requests\CourseBulkRequest;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Arr;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CourseFilter();
        $filterItems = $filter->transform($request);

        $courses = Course::where($filterItems)->paginate();
        return CourseResource::collection($courses->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        return new CourseResource(Course::create($request->all()));
    }

    public function bulk_store(CourseBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['durationInDays','isActive']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(Course::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        Course::insert($bulk->toArray());
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource(Course::findOrFail($course->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, Course  $course)
    {
        $course->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
    }
}
?>