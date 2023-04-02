<?php

namespace App\Http\Controllers;

use App\Filters\SchoolManagementBoardFilter;
use App\Http\Requests\SchoolManagementBoardBulkRequest;
use App\Http\Requests\SchoolManagementBoardStoreRequest;
use App\Http\Requests\SchoolManagementBoardUpdateRequest;
use App\Http\Resources\SchoolManagementBoardResource;
use App\Models\SchoolManagementBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Arr;

class SchoolManagementBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new SchoolManagementBoardFilter();
        $filterItems = $filter->transform($request);

        $schoolmangementboards = SchoolManagementBoard::where($filterItems)->paginate();
        return SchoolManagementBoardResource::collection($schoolmangementboards->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolManagementBoardStoreRequest $request)
    {
        return new SchoolManagementBoardResource(SchoolManagementBoard::create($request->all()));
    }

    public function bulk_store(SchoolManagementBoardBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['shortName']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(SchoolManagementBoard::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        SchoolManagementBoard::insert($bulk->toArray());
    }
    /**
    * Display the specified resource.
    *
    * @param  \App\Models\SchoolManagementBoard  $schoolmanagementboard
     * @return \Illuminate\Http\Response
     */

   
    public function show(SchoolManagementBoard  $schoolmanagementboard)
    {
        return new SchoolManagementBoardResource(SchoolManagementBoard::findOrFail($schoolmanagementboard->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolManagementBoard  $schoolmanagementboard
     * @return \Illuminate\Http\Response
     */
   
    public function update(SchoolManagementBoardUpdateRequest $request, SchoolManagementBoard  $schoolmanagementboard)
    {
        $schoolmanagementboard->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolManagementBoard  $schoolmanagementboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolManagementBoard  $schoolmanagementboard)
    {
        $schoolmanagementboard->delete();
    }
}
