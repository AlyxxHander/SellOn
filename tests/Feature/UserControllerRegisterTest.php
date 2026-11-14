<?php

/**
 * -----------------------
 * HOW TO RUN
 * -----------------------
 * php artisan test --filter=UserControllerRegisterTest
 */

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserControllerRegisterTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test Case 1: Domain Email Salah.
   */
  public function test_registration_fails_when_validation_rules_are_violated()
  {
    // TEST DOUBLE: DUMMY
    $invalidPayload = [
      'name'                  => 'Alyxx Hander',
      'nim'                   => '202310370311179',
      'major'                 => 'Informatic',
      'email'                 => 'dummyadmin123@gmail.com', // Bukan @webmail.umm.ac.id
      'whatsapp_no'           => '081339112233',
      'password'              => 'admin123',
      'password_confirmation' => 'admin123',
    ];

    $response = $this->from(route('register'))->post(route('register.post'), $invalidPayload);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email']);
    $this->assertDatabaseMissing('users', ['nim' => '202110370311999']);
  }

  /**
   * Test Case 2: NIM sudah terdaftar.
   */
  public function test_registration_fails_if_nim_already()
  {
    // Setup user yang sudah ada
    User::factory()->create([
      'nim'   => '202310370311179',
      'email' => 'dummyadmin122@webmail.umm.ac.id',
    ]);

    // TEST DOUBLE: DUMMY
    $invalidPayload = [
      'name'                  => 'Alyxx Hander',
      'nim'                   => '202310370311179', // NIM duplikasi
      'major'                 => 'Informatic',
      'email'                 => 'dummyadmin123@webmail.umm.ac.id',
      'whatsapp_no'           => '081339112233',
      'password'              => 'admin123',
      'password_confirmation' => 'admin123',
    ];

    $response = $this->from(route('register'))->post(route('register.post'), $invalidPayload);
    $response->assertRedirect(route('register'));
    $response->assertSessionHas('toast_error', "The NIM you've inputted is already registered.");
  }

  /**
   * Test Case 3: Email sudah terdaftar.
   */
  public function test_registration_fails_if_email_already_exists()
  {
    // Setup user yang sudah ada
    User::factory()->create([
      'nim'   => '202310370311178',
      'email' => 'dummyadmin123@webmail.umm.ac.id',
    ]);

    // TEST DOUBLE: DUMMY
    $invalidPayload = [
      'name'                  => 'Alyxx Hander',
      'nim'                   => '202310370311179', // NIM unik
      'major'                 => 'Informatic',
      'email'                 => 'dummyadmin123@webmail.umm.ac.id', // Email duplikasi
      'whatsapp_no'           => '081339112233',
      'password'              => 'admin123',
      'password_confirmation' => 'admin123',
    ];

    $response = $this->from(route('register'))->post(route('register.post'), $invalidPayload);
    $response->assertRedirect(route('register'));
    $response->assertSessionHas('toast_error', "The Email you've inputted is already registered.");
  }

  /**
   * Test Case 4: Registrasi berhasil dilakukan.
   */
  public function test_registration_succeeds_and_creates_user()
  {
    // TEST DOUBLE: FAKE
    Notification::fake();
    // TEST DOUBLE: DUMMY
    $validPayload = [
      'name'                  => 'Alyxx Hander',
      'nim'                   => '202310370311179',
      'major'                 => 'Informatic',
      'email'                 => 'dummyadmin123@webmail.umm.ac.id',
      'whatsapp_no'           => '081339112233',
      'password'              => 'admin123',
      'password_confirmation' => 'admin123',
    ];

    $response = $this->post(route('register.post'), $validPayload);
    $response->assertRedirect(route('verification.notice'));
    $response->assertSessionHas(
      'toast_success', 
      'Akun berhasil dibuat! Cek inbox email kampus Anda untuk verifikasi.'
    );

    // Memastikan data user berhasil dibuat
    $this->assertDatabaseHas('users', [
      'nim'   => '202310370311179',
      'email' => 'dummyadmin123@webmail.umm.ac.id',
      'role'  => 'admin',
    ]);

    $user = User::where('email', 'dummyadmin123@webmail.umm.ac.id')->first();
    $this->assertNotNull($user);
    $this->assertTrue(Hash::check('admin123', $user->password));
    $this->assertAuthenticatedAs($user, 'web');
    
    // TEST DOUBLE: SPY
    Notification::assertSentTo(
      $user,
      VerifyEmailNotification::class
    );
  }
}