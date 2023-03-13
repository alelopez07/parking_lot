<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\StoreEntranceRequest;
use App\Interfaces\VehicleInterface;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParkingLotController extends ApiController {

    use ApiResponse;
    protected $repository;

    /**
     * Initialize the repository for controller
     * 
     * @param VehicleInterface $repositoryImpl
     */
    public function __construct(VehicleInterface $repositoryImpl) {
        $this->repository = $repositoryImpl;
    }

    /**
     * createNewEntrance
     * 
     * Allow user admin to register a new entrance for parking lot. 
     * 
     * @param StoreEntranceRequest $request
     * @return $this|JsonResponse
     */
    public function createNewEntrance(StoreEntranceRequest $request): JsonResponse {
        $entrance = $this->repository->newEntrance($request);
        return $this->successResponse($entrance);
    }
}