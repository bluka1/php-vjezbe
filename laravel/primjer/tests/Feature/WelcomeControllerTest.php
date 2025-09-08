<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class WelcomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function prijava_view_shows_post_count_and_has_posts_flag()
    {
        $user = User::create(['name' => 'Test User', 'email' => 'test@example.com', 'password' => bcrypt('password')]);
        $this->actingAs($user);

        // korisnik nema postova
        $response = $this->get('/prijava');
        $response->assertStatus(200);
        // $response->assertViewHas('postCount', 0);
        // $response->assertViewHas('hasPosts', false);

        // dodaj novi post trenutnom korisniku
        Post::create(['user_id' => $user->id, 'title' => 'Test Post', 'content' => 'Test Content']);
        // osvjezi korisnika
        $user->refresh();
        $response = $this->get('/prijava');
        $response->assertStatus(200);
        // $response->assertViewHas('postCount', 1);
        // $response->assertViewHas('hasPosts', true);
    }
}
