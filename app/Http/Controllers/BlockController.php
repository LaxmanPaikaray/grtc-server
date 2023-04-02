<?php

namespace App\Http\Controllers;

use App\Filters\BlockFilter;
use App\Http\Requests\BlockBulkRequest;
use App\Http\Requests\BlockStoreRequest;
use App\Http\Requests\BlockUpdateRequest;
use App\Http\Resources\BlockResource;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new BlockFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includeDistrict = $request->query('includeDistrict');

        $blocks = Block::where($filterItems);
        if($includeDistrict) {
            $blocks = $blocks->with('district');
        }
        return BlockResource::collection($blocks->paginate()->appends($request->query()));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockStoreRequest $request)
    {
        return new BlockResource(Block::create($request->all()));
    }

    public function bulk_store(BlockBulkRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['districtId']);
        })->map(function($arr, $key) {
            //TODO: [Subrat] optimize this function. 
            // We should be able to utilize laravel's way of generating uuid and timestamps
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(Block::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });

        Block::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block  $block)
    {
        $includeDistrict = request()->query('includeDistrict');
        $includePanchayats = request()->query('includePanchayats');
        $relations = [];

        if($includeDistrict) {
            array_push($relations, 'district');
        }

        if($includePanchayats) {
            array_push($relations, 'panchayats');
        }

        if(count($relations) > 0) {
            return new BlockResource($block->loadMissing($relations));
        }

        return new BlockResource($block);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(BlockUpdateRequest $request, Block $block)
    {
        $block->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        $block->delete();
    }
}
