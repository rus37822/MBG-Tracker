<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_root_shows_the_public_menu_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Menu MBG Hari Ini')
            ->assertSee('href="'.route('login', absolute: false).'"', false);
    }
}
