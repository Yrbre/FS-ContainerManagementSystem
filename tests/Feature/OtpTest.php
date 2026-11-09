<?php

namespace Tests\Feature;

use App\Enums\OtpTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OtpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_otp_validation()
    {
        $response = $this->postJson('/api/otp');
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'status',
            'errors'
        ]);
    }

    public function test_otp_register()
    {
        $response = $this->postJson('/api/otp', [
            'type' => 1,
            'value' => '6285603051722'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'status'
        ]);
    }
}
