<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Post;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function user_has_posts_method()
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'posts'));
    }
}
