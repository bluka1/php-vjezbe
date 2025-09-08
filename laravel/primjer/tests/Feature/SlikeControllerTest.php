<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SlikeControllerTest extends TestCase
{
    /** @test */
    public function it_uploads_a_valid_image_and_returns_path()
    {
        // simulira "public" disk, tako da se datoteke ne spremaju stvarno na disk tijekom testa
        Storage::fake('public');

        // stvara fake sliku "test.jpg" za potrebe testiranja
        $file = UploadedFile::fake()->image('test.jpg');

        // salje POST zahtjev na rutu '/slike/store' s fake slikom kao input
        $request = $this->post('/slike/store', [
            'slika' => $file,
        ]);

        // provjerava da je HTTP status odgovora 200 (OK)
        $request->assertStatus(200);

        // provjerava da se u odgovoru nalazi ime slike ("test.jpg")
        $request->assertSee('test.jpg');

        // provjerava da je slika stvarno spremljena na "public" disk u folder "slike/"
        $this->assertTrue(Storage::disk('public')->exists('slike/' . $file->hashName()));
    }

    /** @test */
    public function it_returns_error_for_invalid_file()
    {
        // salje POST zahtjev bez datoteke
        $response = $this->post('/slike/store', []);

        // provjerava da je HTTP status odgovora 200 (OK)
        $response->assertStatus(200);

        // provjerava da se u odgovoru nalazi poruka o gresci
        $response->assertSee('Molimo označite ispravnu datoteku.');
    }
}
