<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResource;
use App\services\RDSService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * @param RDSService $RDSService
     * @return DataResource
     */
    public function __invoke(RDSService $RDSService): DataResource
    {
        return new DataResource($RDSService->getAvailableRegions());
    }
}
