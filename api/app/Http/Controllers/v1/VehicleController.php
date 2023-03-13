<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\VehicleTypeRequest;
use App\Interfaces\VehicleInterface;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as ApiController;
use Symfony\Component\HttpFoundation\Request;

class VehicleController extends ApiController {

    use ApiResponse;

    protected $repository;

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

    public function newVehicle($id, Request $request) {
        $created = $this->repository->addNewVehicle($id, $request->license_plate);
        if ($created->response) {
            return $this->createdResponse($created);
        } else {
            return $this->errorResponse($created->message);
        }
    }

}