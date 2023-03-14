<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\VehicleTypeRequest;
use App\Interfaces\VehicleInterface;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VehicleController extends ApiController {

    use ApiResponse;

    protected $repository;

    /**
     * Initialize the repository for controller
     * 
     * @param VehicleInterface $repositoryImpl
     */
    public function __construct(
        VehicleInterface $repositoryImpl
    ) {
        $this->repository = $repositoryImpl;
    }

    public function createVehicleType(VehicleTypeRequest $request) {
        $validated = $request->validated();
        $created = $this->repository->newVehicleType($validated);
        if ($created->response) {
            return $this->createdResponse($created);
        } else {
            return $this->errorResponse($created->message);
        }
    }

    /**
     * newVehicle
     * 
     * Add new vehicle to the database if the type is one of the two
     * following vehicle types: Official or Resident. 
     * 
     * @param $id, // Official/Resident
     * @param Request $request
     * @return $this|JsonResponse
     */
    public function newVehicle($id, Request $request): JsonResponse {
        $created = $this->repository->addNewVehicle($id, $request->license_plate);
        if ($created->response) {
            return $this->createdResponse($created);
        } else {
            return $this->errorResponse($created->message);
        }
    }

    /**
     * residents
     * 
     * Provide all the residents.
     * @return JsonResponse
     */
    public function residents() {
        $residents = $this->repository->getResidents();
        return $this->successResponse($residents);
    }

    /**
     * activeEntrances
     * 
     * Provide all the active entrances.
     * @return JsonResponse
     */
    public function activeEntrances() {
        $actives = $this->repository->getActives();
        return $this->successResponse($actives);
    }

}