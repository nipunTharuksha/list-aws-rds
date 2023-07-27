<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResource;
use App\Http\Resources\DataResourceCollection;
use App\services\RDSService;

class RDSSingleInstanceController extends Controller
{
    private RDSService $RDSService;

    public function __construct(RDSService $RDSService)
    {
        $this->RDSService = $RDSService;
    }


    /**
     * @param $DBInstanceIdentifier
     * @return DataResourceCollection
     */
    public function getEvents($DBInstanceIdentifier): DataResourceCollection
    {
        $instance = $this->RDSService->getInstances()->where('DBInstanceIdentifier', $DBInstanceIdentifier)
            ->firstOrFail();
        return DataResourceCollection::make($this->RDSService->getEvents($instance)->paginate(10));
    }

}
