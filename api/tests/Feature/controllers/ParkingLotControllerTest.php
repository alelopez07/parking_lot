<?php

namespace Tests\Feature\controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParkingLotControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateNewEntranceWithValidData() { }
    public function testCreateNewEntranceWithInvalidData() { }
    
    public function testCompleteEntranceWithValidId() { }
    public function testCompleteEntranceWithResidentId() { }
    public function testCompleteEntranceWithUnregisteredEntrance() { }
    public function testCompleteEntranceWithRegisteredAndCompletedEntrance() { }
    public function testCompleteEntranceWithRegisteredAndActiveEntrance() { }

    public function testInitializeMonth() { }
    public function testGenerateResidentsPaymentReport() { }
}