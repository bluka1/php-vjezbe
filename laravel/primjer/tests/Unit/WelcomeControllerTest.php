<?php

namespace Tests\Unit;

use App\Http\Controllers\WelcomeController;
use App\Models\User;
use App\Models\Post;
use PHPUnit\Framework\TestCase;

class WelcomeControllerTest extends TestCase
{
    /** @test */
    public function welcome_controller_has_index_method()
    {
        $controller = new WelcomeController();
        $this->assertTrue(method_exists($controller, 'index'));
    }
}
