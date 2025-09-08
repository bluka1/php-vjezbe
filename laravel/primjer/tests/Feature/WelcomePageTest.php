<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    /** @test */
    public function is_welcome_page_loading_and_has_correct_text_and_view(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user);

        $response = $this->get('/welcome');

        $response->assertStatus(200);
        $response->assertDontSee('user');
        $response->assertSee('Dobro nam došli');

        $response->assertHeaderMissing('token');

        $response->assertViewIs('welcome.index');

        $this->assertAuthenticated();
    }
}
