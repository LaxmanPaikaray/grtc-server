<?php

namespace App\Http\Controllers;

use App\Filters\SchoolFilter;
use App\Http\Requests\SchoolStoreRequest;
use App\Http\Requests\SchoolUpdateRequest;
use App\Http\Requests\SchoolBulkRequest;
use App\Http\Resources\SchoolResource;
use App\Models\Block;
use App\Models\City;
use App\Models\CitySubarea;
use App\Models\Panchayat;
use App\Models\School;
use App\Models\Village;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new SchoolFilter();
        $filterItems = $filter->transform($request);

        // [Subrat] We will only support to include parent data in the list/index method
        // [Subrat] The support to include additional child elements is added in the show method
        $includeMgmtBoard = $request->query('includeManagementBoard');

        $schools = School::where($filterItems);
        if($includeMgmtBoard) {
            $schools = $schools->with('managementBoard');
        }
        return SchoolResource::collection($schools->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolStoreRequest $request)
    {
        $requestData = $this->createDependentLocalities($request);
        return new SchoolResource(School::create($requestData));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        $includeVillage = request()->query('includeVillage');
        $includePanchayat = request()->query('includePanchayat');
        $includeBlock = request()->query('includeBlock');
        $includeCitySubarea = request()->query('includeCitySubarea');
        $includeCity = request()->query('includeCity');
        $includeDistrict = request()->query('includeDistrict');
        $includeMgmtBoard = request()->query('includeManagementBoard');
        $relations = [];

        if($includeVillage) {
            array_push($relations, 'village');
        }
        if($includeCity) {
            array_push($relations, 'city');
        }
        if($includeMgmtBoard) {
            array_push($relations, 'managementBoard');
        }
        if($includePanchayat) {
            array_push($relations, 'panchayat');
        }
        if($includeBlock) {
            array_push($relations, 'block');
        }
        if($includeCitySubarea) {
            array_push($relations, 'citySubarea');
        }
        if($includeDistrict) {
            array_push($relations, 'district');
        }

        if(count($relations) > 0) {
            return new SchoolResource($school->loadMissing($relations));
        }

        return new SchoolResource($school);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolUpdateRequest $request, School $school)
    {
        $requestData = $this->createDependentLocalities($request);
        $school->update($requestData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();
    }

    public function bulk_store(SchoolBulkRequest $request) 
    {

    }

    private function createDependentLocalities (FormRequest $request) {
        $requestData = $request->all();
        if(isset($request->village_id)) {
            $village = Village::where(['id' => $request->village_id])->with('panchayat')->first();
            if(isset($village)) {
                $requestData['panchayat_id'] = $village->panchayat_id;
                $blockId = $village->panchayat->block_id;
                $requestData['block_id'] = $blockId;
                $block = Block::where(['id' => $blockId])->first();
                $requestData['district_id'] = $block->district_id;
            }
            $requestData = $this->removeCityFields($requestData);
        } elseif($request->panchayat_id) {
            $panchayat = Panchayat::where(['id' => $request->panchayat_id])->with('block')->first();
            if(isset($panchayat)) {
                $requestData['block_id'] = $panchayat->block_id;
                $districtId = $panchayat->block->district_id;
                $requestData['district_id'] = $districtId;
            }

            // We arrived in this else block, that means the village_id is not set in the request.
            // Remove the village_id from the record, so that wrong information is not set.
            $requestData['village_id'] = null;

            // Remove city related fields when village related fields are present.
            // This is specially important when doing updates. Sometime it happens that, the earlier
            // record has city related fields and the update (PATCH) request updates a village field.
            // This time, the complete record goes into a wrong state, if the city related fields
            // are not removed.
            $requestData = $this->removeCityFields($requestData);
        } elseif($request->block_id) {
            $block = Block::where(['id' => $request->block_id])->first();
            if(isset($block)) {
                $requestData['district_id'] = $block->district_id;
            }
            $requestData['panchayat_id'] = null;
            $requestData['village_id'] = null;
            $requestData = $this->removeCityFields($requestData);
        } elseif($request->citySubareaId) {
            $subarea = CitySubarea::where(['id' => $request->city_subarea_id])->with('city')->first();
            if(isset($subarea)) {
                $requestData['city_id'] = $subarea->city_id;
                $requestData['district_id'] = $subarea->city->district_id;
            }
            $requestData = $this->removeVillageFields($requestData);
        } elseif($request->cityId) {
            $city = City::where(['id' => $request->city_id])->first();
            if(isset($city)) {
                $requestData['district_id'] = $city->district_id;
            }
            $requestData['city_subarea_id'] = null;
            $requestData = $this->removeVillageFields($requestData);
        }

        return $requestData;
    }

    private function removeCityFields($requestData) {
        $requestData['city_subarea_id'] = null;
        $requestData['city_id'] = null;
        return $requestData;
    }

    private function removeVillageFields($requestData) {
        $requestData['village_id'] = null;
        $requestData['panchayat_id'] = null;
        $requestData['block_id'] = null;
        return $requestData;
    }
}
