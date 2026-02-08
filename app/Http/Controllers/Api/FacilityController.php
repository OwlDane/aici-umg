<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities
     * 
     * GET /api/v1/facilities
     */
    public function index()
    {
        $facilities = Facility::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return FacilityResource::collection($facilities);
    }

    /**
     * Display the specified facility
     * 
     * GET /api/v1/facilities/{id}
     */
    public function show(Facility $facility)
    {
        return new FacilityResource($facility);
    }
}
