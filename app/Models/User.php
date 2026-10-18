<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
      'name',
      'nim',
      'major',
      'email',
      'whatsapp_no',
      'profile_image',
      'role',
      'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor for avatar: Get the image from storage if available,
     * or fallback automatically to DiceBear if empty.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($this->name);
    }

    /**
     * Override the default email verification notification
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Check if the user's email has been verified.
     */
    public function hasVerifiedEmail(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Add in class User in app/Models/User.php:
    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }
}
