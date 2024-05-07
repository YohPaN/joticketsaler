<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function test_welcome_page_is_displayed(): void
    {
        $response = $this
            ->get('/');

        $response->assertOk();
    }
}
