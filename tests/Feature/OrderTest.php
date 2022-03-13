<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function check_if_page_redirected_to_login()
    {
        $response = $this->get('/')
            ->assertRedirect('login');
    }
}
