<?php

namespace App\Http\Controllers;

use App\Filters\VillageFilter;
use App\Http\Requests\VillageStoreRequest;
use App\Http\Requests\VillageUpdateRequest;
use App\Http\Requests\VillageBulkRequest;
use App\Http\Resources\VillageResource;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new VillageFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includePanchayat = $request->query('includePanchayat');

        $villages = Village::where($filterItems);
        if($includePanchayat) {
            $villages = $villages->with('panchayat');
        }
        return VillageResource::collection($villages->paginate()->appends($request->query()));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VillageStoreRequest $request)
    {
        return new VillageResource(Village::create($request->all()));
    }

    public function bulk_store(VillageBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['panchayatId']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(Village::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        Village::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(Village $village)
    {
        $includePanchayat = request()->query('includePanchayat');
        $relations = [];

        if($includePanchayat) {
            array_push($relations, 'panchayat');
        }

        if(count($relations) > 0) {
            return new VillageResource($village->loadMissing($relations));
        }

        return new VillageResource($village);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(VillageUpdateRequest $request, Village $village)
    {
        $village->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy(Village $village)
    {
        $village->delete();
    }
}
