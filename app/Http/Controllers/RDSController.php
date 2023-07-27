<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResourceCollection;
use App\services\RDSService;
use Illuminate\Http\JsonResponse;

class RDSController extends Controller
{
    private RDSService $RDSService;

    public function __construct(RDSService $RDSService)
    {
        $this->RDSService = $RDSService;
    }


    /**
     * @return DataResourceCollection
     */
    public function index(): DataResourceCollection
    {
        return DataResourceCollection::make($this->RDSService->getInstances()->paginate(10));
    }

    /**
     * @param $DBInstanceIdentifier
     * @return JsonResponse
     */
    public function stopInstance($DBInstanceIdentifier): JsonResponse
    {
        $instanceToBeStopped = $this->RDSService->instancesInActiveState()
            ->where('DBInstanceIdentifier', $DBInstanceIdentifier)
            ->firstOrFail();

        $this->RDSService->stop($instanceToBeStopped);

        return $this->respondWithSuccess();

    }

    /**
     * @param $DBInstanceIdentifier
     * @return JsonResponse
     */
    public function startInstance($DBInstanceIdentifier): JsonResponse
    {
        $instanceToBeStopped = $this->RDSService->instancesInStoppedState()
            ->where('DBInstanceIdentifier', $DBInstanceIdentifier)
            ->firstOrFail();

        $this->RDSService->start($instanceToBeStopped);

        return $this->respondWithSuccess();

    }

}
