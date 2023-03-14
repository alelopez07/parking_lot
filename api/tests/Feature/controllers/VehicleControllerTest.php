<?php

namespace Tests\Feature\controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testNewVehicleWithValidData() { }
    public function testNewVehicleWithInvalidData() { }
    public function testNewVehicleReturnsErrorResponse() { }

    public function testCreateVehicleTypeWithValidDataReturnsCreatedResponse() { }
    public function testCreateVehicleTypeWithInvalidDataReturnsErrorResponse() { }
    public function testCreateVehicleTypeWithDatabaseErrorReturnsErrorResponse() { }
    
    public function testActiveEntrancesReturnsSuccessResponse() { }
    public function testActiveEntrancesReturnsEmptyArrayWhenNoActives() { }
    
    public function testResidentsReturnsSuccessResponse() { }
    public function testResidentsReturnsEmptyArrayWhenNoResidents() { }
}