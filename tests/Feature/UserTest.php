<?php

namespace Tests\Feature;

use App\Mail\UserRegisteredMail;
use App\Models\Article;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_create_user(){

        Mail::fake();

        $response = $this->post('/register', [
            'email' => 'chedia122@mail.ru',
            'password' => 'Renig@t0983',
            'password_confirmation' => 'Renig@t0983',
        ]);
        $rr= '';
        Mail::assertQueued(UserRegisteredMail::class);
       // $response->assertRedirectContains('/email/verify');
//                ->assertStatus(302)
//                 ->assertRedirect('/email/verify');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();


    }

    public function testCanRegister(){

        $user = factory(User::class, 1)->create()->first();
        $profile = factory(Profile::class, 1)->create(['user_id' => $user->id])->first();
        $this->assertInstanceOf('App\Models\Profile', $user->profiles->first());
        $this->actingAs($user);
        $response = $this->call('get', '/profile');
        $response->assertStatus(200);
//        $profile = factory(Profile::class)->create(['user_id', $user->id]);
//
//        $rr = $user->profiles;
//        $this->actingAs($user);
//        $response = $this->call('get', '/profile');
//        $response->assertStatus(200);
       // $this->assertAuthenticated();
       // $response->assertRedirect('/profile');
    }

    public function testChangePass()
    {
        //$user = User::find(1);
        $user = factory(User::class)->make();

        $this->actingAs($user);

        $response = $this->call('get', '/profile');

//        $response = $this->call('PUT', '/profile/secureUpdate/1', array(
//            '_token' => csrf_token(),
//            'current_password' => 'dfwdewd',
//            'new_password' => 'dfwdewd',
//            'repeat_new_password' => 'dfwdewd',
//        ));

$rr = '';
        //dd($response['statusCode']);
        //$response->assertRedirect('/profile');

       $response->assertStatus(200);
    }
}
