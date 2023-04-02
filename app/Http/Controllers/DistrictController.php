<?php

namespace App\Http\Controllers;

use App\Filters\DistrictFilter;
use App\Http\Requests\DistrictBulkRequest;
use App\Http\Requests\DistrictStoreRequest;
use App\Http\Requests\DistrictUpdateRequest;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new DistrictFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includeState = $request->query('includeState');

        $districts = District::where($filterItems);
        if($includeState) {
            $districts = $districts->with('state');
        }
        
        return DistrictResource::collection($districts->paginate()->appends($request->query()));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictStoreRequest $request)
    {
        return new DistrictResource(District::create($request->all()));
    }

    public function bulk_store(DistrictBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['stateId']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(District::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        District::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        $includeState = request()->query('includeState');
        $includeBlocks = request()->query('includeBlocks');
        $includeCities = request()->query('includeCities');
        $relations = [];

        if($includeState) {
            array_push($relations, 'state');
        }

        if($includeBlocks) {
            array_push($relations, 'blocks');
        }

        if($includeCities) {
            array_push($relations, 'cities');
        }

        if(count($relations) > 0) {
            return new DistrictResource($district->loadMissing($relations));
        }

        return new DistrictResource($district);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictUpdateRequest $request, District $district)
    {
        $district->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        $district->delete();
    }
}
