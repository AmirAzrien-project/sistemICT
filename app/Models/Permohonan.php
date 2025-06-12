<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

    protected $fillable =
    [
        'tajuk',
        'keterangan',
        'id_pekerja',
        'name',
        'notel',
        'jabatan',
        'status_sekretariat',
        'no_rujukan',
        'dokumen1',
        'dokumen2',
        'dokumen3',
        'dokumen4',
        'dokumen5',
        'skop'
    ];

    // Hubungan dengan pengguna
    public function user()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id', 'id_pekerja'); // atau 'id' jika default
        // return $this->belongsTo(User::class, 'id_pekerja', 'id_pekerja');
    }

    public static function generateNoRujukan($skop, $user)
    {
        $kodSkopList = [
            'Pembangunan Sistem' => 'SISTEM',
            'Perkakasan ICT' => 'PERKAKASAN',
            'Perisian' => 'PERISIAN',
            'Rangkaian dan Alatan Rangkaian' => 'RANGKAIANDANALATAN',
            'Perkhidmatan ICT' => 'PERKHIDMATANICT',
            'Cloud' => 'CLOUD',
            'Lain-lain' => 'LAIN',
        ];

        $kodSkop = $kodSkopList[$skop] ?? 'LAIN';
        $year = now()->format('Y');
        $jabatan = strtoupper(str_replace(' ', '', $user->jabatan));

        $count = DB::table('permohonan')
            ->whereYear('created_at', $year)
            ->where('skop', $skop)
            ->count() + 1;

        $bilangan = str_pad($count, 3, '0', STR_PAD_LEFT);

        return "{$year}/{$jabatan}/{$kodSkop}/{$bilangan}";
    }

    public function mesyuarat()
    {
        // return $this->hasOne(Mesyuarat::class, 'permohonan_id');
        return $this->hasMany(Mesyuarat::class, 'permohonan_id');
    }
}
