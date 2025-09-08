<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    /** @test */
    public function it_provides_age_and_sex(): void
    {
        $response = $this->post('/users', [
          'age' => 18,
          'spol' => 'm'
        ]);

        $response->assertStatus(200);
        $response->assertSee('Godine: 18, Spol: m');
    }
    
    /** @test */
    public function it_lacks_age_and_sex(): void
    {
        $response = $this->post('/users', []);
        $response->assertStatus(200);
        $response->assertSee('Nedostaje neki parametar');
    }
}
