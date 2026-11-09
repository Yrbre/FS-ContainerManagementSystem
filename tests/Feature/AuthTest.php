<?php

namespace Tests\Feature;

use App\Enums\OtpTypeEnum;
use App\Models\Otp;
use App\Models\Rank;
use App\Models\User;
use CreateRanksTable;
use Database\Seeders\CreateRanksTableSeeder;
use Database\Seeders\RankSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            CreateRanksTableSeeder::class
        ]);
        Artisan::call('cache:clear');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        // create user
        $user = User::factory()->create();

        $response = $this->postJson('/api/otp', [
            'type' => OtpTypeEnum::LOGIN,
            'value' => $user->phone
        ]);

        $response->assertStatus(200);

        // Check otp
        $otp = Otp::first()->otp;

        // Exchange otp with token
        $response = $this->postJson('/api/auth/login', [
            'phone' => $user->phone,
            'otp' => $otp
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'expires_in'
            ]
        ]);
    }

    public function test_register()
    {
        $phone = "6285603051722";

        $response = $this->postJson('/api/otp', [
            'type' => OtpTypeEnum::REGISTER,
            'value' => $phone
        ]);
        $response->assertStatus(200);

        // Check otp
        $otp = Otp::first()->otp;

        // Register with given token
        $response = $this->postJson('/api/auth/register/verify', [
            'phone' => $phone,
            'otp' => $otp,
            'email' => 'sahabatmiskin.id@gmail.com',
            'name' => 'Sahabat Miskin'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'expires_in'
            ]
        ]);
    }

    public function test_refresh_token()
    {
        // create user
        $user = User::factory()->create();

        $response = $this->postJson('/api/otp', [
            'type' => OtpTypeEnum::LOGIN,
            'value' => $user->phone
        ]);

        $response->assertStatus(200);

        // Check otp
        $otp = Otp::first()->otp;

        // Exchange otp with token
        $response = $this->postJson('/api/auth/login', [
            'phone' => $user->phone,
            'otp' => $otp
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'expires_in'
            ]
        ]);

        $response = $this->postJson('/api/auth/token/refresh', [], [
            'Authorization' => 'Bearer ' . $response->json()['data']['access_token']
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'expires_in'
            ]
        ]);
    }

    public function test_refresh_logout()
    {
        // create user
        $user = User::factory()->create();

        $response = $this->postJson('/api/otp', [
            'type' => OtpTypeEnum::LOGIN,
            'value' => $user->phone
        ]);

        $response->assertStatus(200);

        // Check otp
        $otp = Otp::first()->otp;

        // Exchange otp with token
        $response = $this->postJson('/api/auth/login', [
            'phone' => $user->phone,
            'otp' => $otp
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'expires_in'
            ]
        ]);

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $response->json()['data']['access_token']
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_email_verify()
    {
        // create user
        $user = User::factory()->create();

        $response = $this->postJson('/api/otp', [
            'type' => OtpTypeEnum::LOGIN,
            'value' => $user->phone
        ]);

        $response->assertStatus(200);

        // Check otp
        $otp = Otp::first()->otp;

        // Exchange otp with token
        $response = $this->postJson('/api/auth/login', [
            'phone' => $user->phone,
            'otp' => $otp
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'expires_in'
            ]
        ]);

        $token = $response->json()['data']['access_token'];

        $response = $this->postJson('/api/otp', [
            'type' => OtpTypeEnum::EMAIL_VERIFY,
            'value' => $user->email
        ]);

        $response->assertStatus(200);
        // Check otp
        $otp = Otp::first()->otp;

        $response = $this->postJson('/api/auth/email/verify', [
            'email' => $user->email,
            'otp' => $otp
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);


        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
    }
}
