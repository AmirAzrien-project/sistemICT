<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class RandomizeJabatan extends Command
{
    protected $signature = 'jabatan:randomize';
    protected $description = 'Randomkan jabatan pengguna dalam table users';

    public function handle()
    {
        $senaraiJabatan = [
            // Jabatan Negeri
            'Pejabat Penasihat Undang-undang Negeri Johor',
            'Perbendaharaan Negeri Johor',
            'Jabatan Mufti Negeri Johor',
            'Jabatan Kehakiman Syariah Negeri Johor',
            'Pejabat Tanah Dan Galian Johor',
            'Jabatan Agama Islam Negeri Johor',
            'Jabatan Pendakwaan Syariah Negeri Johor',
            'Suruhanjaya Perkhidmatan Awam Johor',
            'Jabatan DiRaja Johor',
            'Muzium DiRaja Abu Bakar Istana Besar Johor',
            'Pejabat Kebun Bunga Kerajaan Johor',
            'Tourism Johor',
            'Institut Dato’ Onn',
            'Media Digital Johor',
            'Unit Strategik Modal Insan Negeri Johor',

            // Pejabat SUK
            'Pejabat Jurutulis Dewan Undangan Negeri Johor',
            'Pejabat Menteri Besar Johor',
            'Pejabat Setiausaha Kerajaan Johor, ICT@Johor',
            'Pejabat Setiausaha Kerajaan Johor, Bahagian Kerajaan Tempatan',
            'Pejabat Setiausaha Kerajaan Johor, Bahagian Pengurusan Sumber Manusia',
            'Pejabat Setiausaha Kerajaan Johor, Bahagian Perancang Ekonomi Negeri Johor',
            'Pejabat Setiausaha Kerajaan Johor, Bahagian Pemantauan Projek dan Kesejahteraan Rakyat',
            'Pejabat Setiausaha Kerajaan Johor, Bahagian Khidmat Pengurusan',
            'Pejabat Setiausaha Kerajaan Johor, Audit Dalam',
            'Badan Kawalselia Air Johor (BAKAJ)',
            'Landskap Johor',
            'Majlis Sukan Negeri Johor',

            // Pejabat Daerah
            'Pejabat Daerah Johor Bahru',
            'Pejabat Daerah Muar',
            'Pejabat Daerah Batu Pahat',
            'Pejabat Daerah Segamat',
            'Pejabat Daerah Kluang',
            'Pejabat Daerah Pontian',
            'Pejabat Daerah Kota Tinggi',
            'Pejabat Daerah Mersing',
            'Pejabat Daerah Tangkak',
            'Pejabat Daerah Kulai',

            // PBT
            'Majlis Bandaraya Johor Bahru',
            'Majlis Bandaraya Iskandar Puteri',
            'Majlis Bandaraya Pasir Gudang',
            'Majlis Perbandaran Batu Pahat',
            'Majlis Perbandaran Kluang',
            'Majlis Perbandaran Kulai',
            'Majlis Perbandaran Muar',
            'Majlis Perbandaran Pontian',
            'Majlis Perbandaran Segamat',
            'Majlis Perbandaran Pengerang',
            'Majlis Daerah Kota Tinggi',
            'Majlis Daerah Mersing',
            'Majlis Daerah Tangkak',
            'Majlis Daerah Yong Peng',
            'Majlis Daerah Simpang Renggam',
            'Majlis Daerah Labis',

            // Jabatan Persekutuan
            'Jabatan Kerja Raya Negeri Johor',
            'Jabatan Pengairan dan Saliran Negeri Johor',
            'Jabatan Pertanian Negeri Johor',
            'PLANMalaysia@Johor',
            'Jabatan Perhutanan Negeri Johor',
            'Jabatan Perkhidmatan Veterinar Negeri Johor',
            'Jabatan Kebajikan Masyarakat Negeri Johor',

            // Badan Berkanun
            'Majlis Agama Islam Johor',
            'Yayasan Pelajaran Johor',
            'Perbadanan Islam Johor',
            'Perbadanan Kemajuan Perumahan Negeri Johor',
            'Perbadanan Stadium Johor',
            'Yayasan Warisan Johor',
            'Yayasan Pembangunan Keluarga Darul Tak’zim',
            'Taman Negara Johor',
            'Perbadanan Perpustakaan Awam Johor',
        ];

        $users = User::all();

        foreach ($users as $user) {
            $user->jabatan = $senaraiJabatan[array_rand($senaraiJabatan)];
            $user->save();
        }

        $this->info('Semua `jabatan` pengguna berjaya dikemaskini secara rawak.');
    }
}
