<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Support\Str;

class PermohonanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user yang ada id_pekerja
        $users = User::whereNotNull('id_pekerja')->get();

        foreach ($users as $user) {
            for ($x = 1; $x <= 3; $x++) {
                $skop = $this->getSkopRawak();

                // Elak duplikasi: jana no_rujukan unik
                do {
                    $noRujukan = Permohonan::generateNoRujukan($skop, $user);
                } while (Permohonan::where('no_rujukan', $noRujukan)->exists());

                Permohonan::create([
                    'no_rujukan' => $noRujukan,
                    'name' => $user->name,
                    'notel' => $user->notel,
                    'id_pekerja' => $user->id_pekerja,
                    'jabatan' => $user->jabatan,
                    'skop' => $skop,
                    'tajuk' => 'Permohonan Projek ' . $skop,
                    'keterangan' => 'Ini adalah keterangan permohonan secara rawak.',
                    'dokumen1' => 'dummy_dokumen1.pdf',
                    'dokumen2' => 'dummy_dokumen2.docx',
                    'dokumen3' => 'dummy_dokumen3.xlsx',
                    'dokumen4' => 'dummy_dokumen4.pdf',
                    'dokumen5' => 'dummy_dokumen5.docx',
                    'status_sekretariat' => 'Menunggu',
                ]);

                $this->command->info("Permohonan untuk {$user->name} dengan No Rujukan: {$noRujukan} berjaya dijana.");
            }
        }
    }

    private function getSkopRawak(): string
    {
        $skop = [
            'Pembangunan Sistem',
            'Perkakasan ICT',
            'Perisian',
            'Rangkaian dan Alatan Rangkaian',
            'Perkhidmatan ICT',
            'Pengkomputeran Awan',
            'Khidmat ICT',
        ];

        return $skop[array_rand($skop)];
    }
}
