<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\StoreEntranceRequest;
use App\Interfaces\VehicleInterface;
use App\Traits\ApiResponse;
use Auth;
use Illuminate\Routing\Controller as ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $validated = $request->validated();
        $authUserId = Auth::user()->id;
        $newEntrance = $this->repository->newEntrance($authUserId, $validated);
        if ($newEntrance->response) {
            return $this->createdResponse($newEntrance);
        } else {
            return $this->errorResponse($newEntrance->message);
        }
    }

    /**
     * completeEntrance
     * 
     * Admin will finalize the entrance. 
     * 
     * @param StoreEntranceRequest $request
     * @return $this|JsonResponse
     */
    public function completeEntrance(Request $request): JsonResponse {
        $entranceCompleted = $this->repository->completeEntrance($request->entrance_id);
        /*
        if ($entranceCompleted->response) {
            return $this->okResponse($entranceCompleted);
        } else {
            return $this->errorResponse($entranceCompleted);
        }*/
        return $this->errorResponse($entranceCompleted);

    }
}