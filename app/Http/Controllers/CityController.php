<?php

namespace App\Http\Controllers;

use App\Filters\CityFilter;
use App\Http\Requests\CityBulkRequest;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CityFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includeDistrict = $request->query('includeDistrict');

        $cities = City::where($filterItems);
        if($includeDistrict) {
            $cities = $cities->with('district');
        }
        return CityResource::collection($cities->paginate()->appends($request->query()));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        return new CityResource(City::create($request->all()));
    }

    public function bulk_store(CityBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['districtId']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(City::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        City::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        $includeDistrict = request()->query('includeDistrict');
        $includeSubAreas = request()->query('includeSubareas');
        $relations = [];

        if($includeDistrict) {
            array_push($relations, 'district');
        }

        if($includeSubAreas) {
            array_push($relations, 'subareas');
        }

        if(count($relations) > 0) {
            return new CityResource($city->loadMissing($relations));
        }

        return new CityResource($city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityUpdateRequest $request,City  $city)
    {
        $city->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City  $city)
    {
        $city->delete();
    }
}
