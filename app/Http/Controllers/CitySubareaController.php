<?php

namespace App\Http\Controllers;

use App\Filters\CitySubareaFilter;
use App\Http\Requests\CitySubareaBulkRequest;
use App\Http\Requests\CitySubareaStoreRequest;
use App\Http\Requests\CitySubareaUpdateRequest;
use App\Http\Resources\CitySubareaResource;
use App\Models\CitySubarea;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CitySubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CitySubareaFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includeCity = $request->query('includeCity');

        $subareas = CitySubarea::where($filterItems);
        if($includeCity) {
            $subareas = $subareas->with('city');
        }
        return CitySubareaResource::collection($subareas->paginate()->appends($request->query()));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CitySubareaStoreRequest $request)
    {
        return new CitySubareaResource(CitySubarea::create($request->all()));
    }

    public function bulk_store(CitySubareaBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['cityId']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(CitySubarea::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        CitySubarea::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CitySubarea  $city_subarea
     * @return \Illuminate\Http\Response
     */
    public function show(CitySubarea $city_subarea)
    {
        $includeCity = request()->query('includeCity');
        $relations = [];

        if($includeCity) {
            array_push($relations, 'city');
        }

        if(count($relations) > 0) {
            return new CitySubareaResource($city_subarea->loadMissing($relations));
        }

        return new CitySubareaResource($city_subarea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CitySubarea  $city_subarea
     * @return \Illuminate\Http\Response
     */
    public function update(CitySubareaUpdateRequest $request, CitySubarea  $city_subarea)
    {
        $city_subarea->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CitySubarea  $city_subarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(CitySubarea  $city_subarea)
    {
        $city_subarea->delete();
    }
}
