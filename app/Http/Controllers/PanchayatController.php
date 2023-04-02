<?php

namespace App\Http\Controllers;

use App\Filters\PanchayatFilter;
use App\Http\Requests\PanchayatStoreRequest;
use App\Http\Requests\PanchayatUpdateRequest;
use App\Http\Requests\PanchayatBulkRequest;
use App\Http\Resources\PanchayatResource;
use App\Models\Panchayat;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PanchayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new PanchayatFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includeBlock = $request->query('includeBlock');

        $panchayats = Panchayat::where($filterItems);
        if($includeBlock) {
            $panchayats = $panchayats->with('block');
        }
        return PanchayatResource::collection($panchayats->paginate()->appends($request->query()));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PanchayatStoreRequest $request)
    {
        return new PanchayatResource(Panchayat::create($request->all()));
    }

    public function bulk_store(PanchayatBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['blockId']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(Panchayat::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        Panchayat::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panchayat  $bpanchayat
     * @return \Illuminate\Http\Response
     */
    public function show(Panchayat  $panchayat)
    {
        $includeBlock = request()->query('includeBlock');
        $includeVillages = request()->query('includeVillages');
        $relations = [];

        if($includeBlock) {
            array_push($relations, 'block');
        }

        if($includeVillages) {
            array_push($relations, 'villages');
        }

        if(count($relations) > 0) {
            return new PanchayatResource($panchayat->loadMissing($relations));
        }

        return new PanchayatResource($panchayat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panchayat  $panchayat
     * @return \Illuminate\Http\Response
     */
    public function update(PanchayatUpdateRequest $request, Panchayat $panchayat)
    {
        $panchayat->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panchayat  $panchayat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panchayat $panchayat)
    {
        $panchayat->delete();
    }
}
