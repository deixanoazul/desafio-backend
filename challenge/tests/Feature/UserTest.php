<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed();
        $this->app->make(User::class)->createUsers();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    //ActionVerb_WhoOrWhatToDo_ExpectedBehavior
    public function test_check_if_users_column_is_correct()
    {
        $user = new User();

        $expected = [
            'name',
            'email',
            'cpf',
            'password',
            'birthday'
        ];

        $array_compared  = array_diff($expected, $user->getFillable());
        $this->assertEquals(0, count($array_compared));
    }
}
