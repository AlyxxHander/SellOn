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
   * Test Case 1: Statement coverage untuk validasi gagal (misal: domain email salah).
   * Memastikan Request validation menolak request sebelum ke query database.
   */
  public function test_registration_fails_when_validation_rules_are_violated()
  {
    // TEST DOUBLE: DUMMY
    // Dummy data dengan email kampus yang tidak valid
    $invalidPayload = [
      'name'                  => 'John Doe',
      'nim'                   => '202110370311999',
      'major'                 => 'Informatika',
      'email'                 => 'johndoe@gmail.com', // Bukan @webmail.umm.ac.id
      'whatsapp_no'           => '081234567890',
      'password'              => 'secret123',
      'password_confirmation' => 'secret123',
    ];

    $response = $this->from(route('register'))->post(route('register.post'), $invalidPayload);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email']);
    $this->assertDatabaseMissing('users', ['nim' => '202110370311999']);
  }

  /**
   * Test Case 2: Statement & branch coverage saat NIM sudah terdaftar.
   * Mengeksekusi branch: if (User::where('nim', $request->nim)->exists())
   */
  public function test_registration_fails_if_nim_already()
  {
    // Setup existing user
    User::factory()->create([
      'nim'   => '202110370311001',
      'email' => 'existing@webmail.umm.ac.id',
    ]);

    // TEST DOUBLE: DUMMY
    $invalidPayload = [
      'name'                  => 'New Student',
      'nim'                   => '202110370311001', // Duplicate NIM
      'major'                 => 'Informatika',
      'email'                 => 'unique@webmail.umm.ac.id',
      'whatsapp_no'           => '081234567890',
      'password'              => 'secret123',
      'password_confirmation' => 'secret123',
    ];

    $response = $this->from(route('register'))->post(route('register.post'), $invalidPayload);
    $response->assertRedirect(route('register'));
    $response->assertSessionHas('toast_error', "The NIM you've inputted is already registered.");
  }

  /**
   * Test Case 3: Statement & branch coverage saat Email sudah terdaftar (NIM berbeda).
   * Mengeksekusi branch: else if (User::where('email', $request->email)->exists())
   */
  public function test_registration_fails_if_email_already_exists()
  {
    // Setup existing user
    User::factory()->create([
      'nim'   => '202110370311002',
      'email' => 'duplicate@webmail.umm.ac.id',
    ]);

    // TEST DOUBLE: DUMMY
    $payload = [
      'name'                  => 'Another Student',
      'nim'                   => '202110370311003', // Unique NIM
      'major'                 => 'Informatika',
      'email'                 => 'duplicate@webmail.umm.ac.id', // Duplicate Email
      'whatsapp_no'           => '081234567890',
      'password'              => 'secret123',
      'password_confirmation' => 'secret123',
    ];

    $response = $this->from(route('register'))->post(route('register.post'), $payload);
    $response->assertRedirect(route('register'));
    $response->assertSessionHas('toast_error', "The Email you've inputted is already registered.");
  }

  /**
   * Test Case 4: Full statement coverage saat registrasi berhasil.
   * Menggunakan Test Double:
   * - Notification::fake() [Fake] untuk menggantikan email driver sesungguhnya.
   * - Notification::assertSentTo() [Mock/Spy behavior verification].
   * - Dummy attributes untuk major & whatsapp_no.
   */
  public function test_registration_succeeds_and_creates_user()
  {
    // TEST DOUBLE: FAKE
    Notification::fake();
    // TEST DOUBLE: DUMMY
    $validPayload = [
      'name'                  => 'Ahmad Fulan',
      'nim'                   => '202110370311099',
      'major'                 => 'Teknik Informatika',
      'email'                 => 'fulan@webmail.umm.ac.id',
      'whatsapp_no'           => '081234567899',
      'password'              => 'password123',
      'password_confirmation' => 'password123',
    ];

    $response = $this->post(route('register.post'), $validPayload);
    // Assert redirect & flash message
    $response->assertRedirect(route('verification.notice'));
    $response->assertSessionHas(
      'toast_success', 
      'Akun berhasil dibuat! Cek inbox email kampus Anda untuk verifikasi.'
    );

    // Assert database record created with default role 'admin'
    $this->assertDatabaseHas('users', [
      'nim'   => '202110370311099',
      'email' => 'fulan@webmail.umm.ac.id',
      'role'  => 'admin',
    ]);

    $user = User::where('email', 'fulan@webmail.umm.ac.id')->first();
    $this->assertNotNull($user);
    $this->assertTrue(Hash::check('password123', $user->password));

    // Assert user authenticated
    $this->assertAuthenticatedAs($user, 'web');
    // TEST DOUBLE: SPY / BEHAVIOR VERIFICATION
    Notification::assertSentTo(
      $user,
      VerifyEmailNotification::class
    );
  }
}