<?php

namespace Tests\Feature\controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateUserWithValidData() { }
    public function testCreateUserWithInvalidData() { }
    public function testCreateUserReturnsErrorResponse() { }
}