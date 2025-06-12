<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesyuarat extends Model
{
    use HasFactory;

    protected $table = 'mesyuarat';

    protected $fillable = [
        'no_rujukan',
        'permohonan_id',
        'peringkat_mesyuarat',
        'nama_mesyuarat',
        'nilai_projek',
        'keputusan',
        'tarikh_masa',
        'no_sijil',
    ];

    const KEPUTUSAN_CHOICES = [
        'Lulus',
        'Tidak Lulus',
        'Semakan Semula',
        'Menunggu',
        'Selesai',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}
