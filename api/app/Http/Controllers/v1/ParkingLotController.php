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
        if ($entranceCompleted->response) {
            return $this->okResponse($entranceCompleted);
        } else {
            return $this->errorResponse($entranceCompleted);
        }
    }
    

    public function initMonth() {
        $initialized = $this->repository->initMonth();
        if ($initialized->response) {
            return $this->okResponse($initialized);
        } else {
            return $this->errorResponse($initialized);
        }
    }

    public function generateResidentsPaymentReport(Request $request) {
        $docName = $request->document_name;
        $generated = $this->repository->generateReports();
        if ($generated->response) {
            $result = new \stdClass();
            $result->document_name = $docName;
            $result->residents = $generated->message;
            return $this->okResponse($result);
        } else {
            return $this->errorResponse($generated->message);
        }

    }
}