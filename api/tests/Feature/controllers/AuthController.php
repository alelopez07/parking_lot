<?php

namespace Tests\Feature\controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testAuthenticationWithInvalidUser() { }
    public function testAuthenticationWithValidUser() { }
    public function testAuthenticationWithErrorResponse() { }
}