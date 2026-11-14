<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestingUserController extends Controller
{
  public function register(Request $request) {
    $validation = $request->validate([
      'name'        => ['required', 'string', 'max:255'],
      'nim'         => ['required', 'string', 'size:15'],
      'major'       => ['required'],
      'email'       => ['required', 'string', 'email', 'ends_with:@webmail.umm.ac.id'],
      'whatsapp_no' => ['required', 'string', 'min:10', 'max:15'],
      'role'        => ['string', 'max:10'],
      'password'    => ['required', 'string', 'min:5', 'confirmed'],
    ]);

    if (User::where('nim', $request->nim)->exists()) {
      return redirect()
        ->route('register')
        ->with(
            "toast_error", 
            "The NIM you've inputted is already registered."
          );
    } else if (User::where('email', $request->email)->exists()) {
      return redirect()
        ->route('register')
        ->with(
            "toast_error", 
            "The Email you've inputted is already registered."
          );
    }

    // Set role default menjadi admin
    $validation['role'] = 'admin';
    // Enkripsi Password
    $validation['password'] = Hash::make($validation['password']);
    // Simpan user ke database
    $user = User::create($validation);
    // Login user (akses penuh dibatasi middleware 'verified')
    auth()->guard('web')->login($user);
    // Kirim email verifikasi ke inbox kampus
    $user->sendEmailVerificationNotification();

    // Redirect ke halaman instruksi verifikasi email
    return redirect()
      ->route('verification.notice')
      ->with(
          'toast_success', 
          'Akun berhasil dibuat! Cek inbox email kampus Anda untuk verifikasi.'
        );
  }
}
