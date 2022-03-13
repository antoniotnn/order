<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{

    /** @test */
    public function check_if_user_admin_is_correctly_inserted()
    {
        $user = new DB;

        $user = DB::table('users')
            ->where('email', 'admin@admin.com')
            ->first();

        $this->assertTrue(!empty($user));

    }
}
