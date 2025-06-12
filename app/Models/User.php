<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    // use \Illuminate\Auth\MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'id_pekerja',
        'jawatan',
        'jabatan',
        'notel',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            // dd('Type value during creating event: ' . $user->type);

            // Generate id_pekerja based on type
            $user->id_pekerja = $user->generateIdPekerja($user->type);
        });
    }

    public function generateIdPekerja($type)
    {
        // dd('Generating ID for type: ' . $type); // Debugging here

        $type = trim($type); // Trim any leading/trailing whitespace
        $type = (int) $type; // Convert to integer

        // dd('Type after trim and cast: ' . $type);

        $prefix = match ($type) {
            1 => 'BIA', // Pengguna Umum
            2 => 'SEK', // Sekretariat
            3 => 'ADM', // Admin Jabatan
            4 => 'SA',  // Super Admin
            default => 'UNK', // Unknown
        };

        // dd('Prefix generated: ' . $prefix);

        // Ensure uniqueness
        do {
            $number = rand(100, 999);
            $id_pekerja = $prefix . '-' . $number;
        } while (self::where('id_pekerja', $id_pekerja)->exists());

        return $id_pekerja;
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'id_pekerja', 'id_pekerja');
        // return $this->hasMany(Permohonan::class, 'id_pekerja')->withTrashed();  // pastikan ada hubungan dengan permohonan
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
