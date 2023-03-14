<?php

namespace App\Repositories;
use App\Interfaces\VehicleInterface;
use App\Models\BaseResponse;
use App\Models\Entrance;
use App\Models\EntranceResponse;
use App\Models\ResponseActionCode;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Carbon\Carbon;

class VehicleRepository implements VehicleInterface
{
    private $residentId;
    private $noResidentId;
    private $officialId;

    public function __construct() {
        $this->residentId = VehicleType::where('name',VehicleType::CONST_RESIDENT_KEY)->first()->id;
        $this->noResidentId = VehicleType::where('name',VehicleType::CONST_NO_RESIDENT_KEY)->first()->id;
        $this->officialId = VehicleType::where('name',VehicleType::CONST_OFFICIAL_KEY)->first()->id;
    }

    public function newEntrance($userId, array $data): EntranceResponse {
        $result = new EntranceResponse();
        try {
            $exist = Entrance::where('license_plate',$data["license_plate"])->where('state',"ACTIVE")->first();
            if ($exist == null) {
                $startedAt = Carbon::now();
                $entrance = Entrance::create([
                    "license_plate" => $data["license_plate"],
                    "started_at" => $startedAt, 
                    "finalized_at" => "0000-00-00 00:00:00", 
                    "state" => "ACTIVE", 
                    "vehicle_type_id" => $data["vehicle_type_id"], 
                    "user_id" => $userId,
                ]);
                $result->setMessage("new entrance registered successfuly.");
                $result->setEntranceId($entrance->id);
                $result->setComments("this token {entrance_id} will help to finalize this entrance. works as ID");
            } else {
                $result->setEntranceId($exist->id);
                $result->setComments("the licence plate: ". $exist->license_plate ." has an active session.");
            }
            $result->setResponse(true);
        } catch (\Throwable $th) {
            $result->setResponse(false);
            $result->setMessage("an error has ocurred: " . $th->getMessage());
        }
        return $result;
    }

    public function newVehicleType(array $data): BaseResponse {
        $result = new BaseResponse();
        try {
            $type = VehicleType::create([
                "name" => $data["name"],
                "amount" => doubleval($data["amount"]),
            ]);
            $result->setResponse(true);
            $result->setMessage("new vehicle type: " . $type->name . " created successfuly.");
        } catch (\Throwable $th) {
            $result->setResponse(false);
            $result->setMessage("an error has ocurred: " . $th->getMessage());
        }
        return $result;
    }

    public function completeEntrance($id): EntranceResponse {
        $response = new EntranceResponse();
        $comments = [];
        try {
            $entrance = Entrance::find($id);
            $response->setResponse(true);
            if ($entrance != null) {
                $response->setEntranceId($entrance->id);
                if ($entrance->state == "COMPLETED") {
                    $response->setMessage("the entrance was completed on: " . $entrance->finalized_at);
                    array_push($comments, "this session token has already been closed");
                    $response->setComments($comments);
                } else {
                    $finalizedAt = Carbon::now();
                    $entrance->update(['finalized_at' => $finalizedAt, 'state' => "COMPLETED"]);
                    $response->setMessage("the entrance was completed successfuly.");
                    array_push($comments, "- this session token was completed and closed at: " . $finalizedAt);
    
                    $diff = $this->getEntranceDiffTime($entrance->started_at, $finalizedAt);
                    $vehicleType = $entrance->vehicleType->id;
    
                    if ($vehicleType == $this->residentId) {
                        $resident = $this->handleResidents($entrance->license_plate, $diff);
                        if ($resident == ResponseActionCode::CREATED) {
                            array_push($comments, "- this vehicle was registered as resident on vehicles.");
                        } else if ($resident == ResponseActionCode::UPDATED) {
                            array_push($comments, "- this vehicle was updated with new time: " . $diff);
                        }
                    } else if ($vehicleType == $this->noResidentId) {
                        $amount = $entrance->vehicleType->amount;
                        $difftotime = strtotime($diff);
                        $total = floatval($amount * (date('i', $difftotime)));
                        array_push($comments, "- the total amount for [".$diff."] -> $".$total);
    
                    } else if ($vehicleType == $this->officialId) {
                        array_push($comments, "- the total time for official license plate [".$entrance->license_plate."] is [".$diff."]");
                        array_push($comments, "- from: [".$entrance->started_at."] - to: [".$finalizedAt."]");
                    }
                    $response->setComments($comments);
                }
            } else {
                $response->setMessage("entrance was not found.");
            }
        } catch(\Throwable $th) {
            $response->setResponse(false);
            $response->setMessage("an error has ocurred: " . $th->getMessage());
        }
        return $response;
    }

    private function handleResidents($licensePlate, $diff): ResponseActionCode {
        $vehicleExist = Vehicle::where('license_plate',$licensePlate)->first();
        if ($vehicleExist == null) {
            $vehicle = new Vehicle();
            $vehicle->license_plate = $licensePlate;
            $vehicle->vehicle_type_id = $this->residentId;
            $vehicle->time = $diff;
            $vehicle->save();
            return ResponseActionCode::CREATED;
        } else {
            $currentTime = \DateTime::createFromFormat('H:i:s', $vehicleExist->time);
            $newDiff = \DateTime::createFromFormat('H:i:s', $diff);
            $newTime = $currentTime->add($newDiff->diff(new \DateTime('00:00:00')));
            $vehicleExist->update(['time' => $newTime->format('H:i:s')]); 
            return ResponseActionCode::UPDATED;
        }
    }

    private function getEntranceDiffTime($start, $end): string {
        $startDateTime = new \DateTime($start);
        $endDateTime = new \DateTime($end);
        $diff = $startDateTime->diff($endDateTime);
        $diffParse = $diff->h . ':' . $diff->i . ':' . $diff->s;
        return $diffParse;
    }

    public function addNewVehicle($id, $licensePlate): BaseResponse {
        $response = new BaseResponse();
        try {
            $vehicleExist = Vehicle::where('license_plate',$licensePlate)->first();
            if ($vehicleExist == null) {
                $typeId = null;
                $message = null;

                if (strtoupper($id) == "RESIDENT") {
                    $typeId = $this->residentId;
                    $message = "A new resident vehicle was registered in database.";
                } else if(strtoupper($id) == "OFFICIAL") {
                    $typeId = $this->officialId;
                    $message = "A new official vehicle was registered in database.";
                } else {
                    $message = "Operation not completed, vehicle type is not identified.";
                }

                if ($typeId != null) {
                    Vehicle::create(
                        [
                            'license_plate' => $licensePlate,
                            'time' => "00:00:00",
                            'vehicle_type_id' => $typeId
                        ]
                    );
                }
                
                $response->setMessage($message);
            } else {
                $response->setMessage("This license plate is already registered.");
            }
            $response->setResponse(true);
        } catch (\Throwable $th) {
            $response->setResponse(false);
            $response->setMessage("an error occured: " . $th->getMessage());
        }
        return $response;
    }

    public function initMonth(): BaseResponse {
        $response = new BaseResponse();
        try {
            $this->resetVehicleTiming();
            $this->removeOfficialsEntrance();
            $response->setResponse(true);
            $response->setMessage("Month was initialized");
        } catch(\Throwable $th) {
            $response->setResponse(false);
            $response->setMessage("An error occured: ".$th->getMessage());
        }
        return $response;
    }

    private function resetVehicleTiming() {
        $vehicles = Vehicle::where('deleted_at',null)->get();
        foreach($vehicles as $vehicle) {
            $vehicle->update(['time' => '00:00:00']);
        }
    }

    private function removeOfficialsEntrance() {
        Entrance::where('vehicle_type_id', $this->officialId)->delete();
    }

    public function generateReports(): BaseResponse { 
        $response = new BaseResponse();
        try {
            $residents = Vehicle::where('vehicle_type_id',$this->residentId)->get();
            $results = [];
            for($i=0; $i<count($residents);++$i) {
                $result = new \stdClass();
                $result->licensePlate = $residents[$i]->license_plate;
                $result->time = $residents[$i]->time;
                $time = strtotime($result->time);
                $total = floatval($residents[$i]->vehicleType->amount * (date('i', $time)));
                $result->total = "$".$total;
                $results[$i] = $result;
            }
            $response->setResponse(true);
            $response->setMessage($results);
        } catch(\Throwable $th) {
            $response->setResponse(false);
            $response->setMessage('An error occured: ' . $th->getMessage());
        }
        return $response;
    }
}
