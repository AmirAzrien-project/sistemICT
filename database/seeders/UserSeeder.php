<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Type 1 - Biasa
            ['name' => 'Ahmad Bin Ali', 'notel' => '012-3456789', 'email' => 'ahmad.biasa1@johor.gov.my', 'type' => 1, 'jawatan' => 'Pembantu Tadbir (P/O)', 'jabatan' => 'Majlis Daerah Simpang Renggam'],
            ['name' => 'Noraini Binti Zainal', 'notel' => '013-1234567', 'email' => 'noraini.biasa2@johor.gov.my', 'type' => 1, 'jawatan' => 'Penolong Pegawai Tadbir', 'jabatan' => 'Majlis Sukan Negeri Johor'],
            ['name' => 'Zulkifli Bin Hassan', 'notel' => '019-8765432', 'email' => 'zulkifli.biasa3@johor.gov.my', 'type' => 1, 'jawatan' => 'Juruteknik Komputer', 'jabatan' => 'Majlis Perbandaran Segamat'],
            ['name' => 'Aishah Binti Musa', 'notel' => '017-2345678', 'email' => 'aishah.biasa4@johor.gov.my', 'type' => 1, 'jawatan' => 'Pembantu Tadbir (Kewangan)', 'jabatan' => 'Majlis Perbandaran Kulai'],
            ['name' => 'Syafiq Bin Salleh', 'notel' => '011-5678901', 'email' => 'syafiq.biasa5@johor.gov.my', 'type' => 1, 'jawatan' => 'Penolong Jurutera', 'jabatan' => 'Pejabat Kebun Bunga Kerajaan Johor'],
            ['name' => 'Rohana Binti Omar', 'notel' => '016-9012345', 'email' => 'rohana.biasa6@johor.gov.my', 'type' => 1, 'jawatan' => 'Pembantu Awam', 'jabatan' => 'Majlis Daerah Tangkak'],
            ['name' => 'Hafiz Bin Jamal', 'notel' => '014-4567890', 'email' => 'hafiz.biasa7@johor.gov.my', 'type' => 1, 'jawatan' => 'Penolong Akauntan', 'jabatan' => 'Jabatan Kehakiman Syariah Negeri Johor'],
            ['name' => 'Liyana Binti Ismail', 'notel' => '018-7890123', 'email' => 'liyana.biasa8@johor.gov.my', 'type' => 1, 'jawatan' => 'Penolong Pegawai Teknologi Maklumat', 'jabatan' => 'Majlis Daerah Labis'],
            ['name' => 'Farid Bin Amin', 'notel' => '010-3210987', 'email' => 'farid.biasa9@johor.gov.my', 'type' => 1, 'jawatan' => 'Pembantu Operasi', 'jabatan' => 'Jabatan Pertanian Negeri Johor'],
            ['name' => 'Salmah Binti Ghazali', 'notel' => '012-6543210', 'email' => 'salmah.biasa10@johor.gov.my', 'type' => 1, 'jawatan' => 'Pegawai Tadbir', 'jabatan' => 'Yayasan Pelajaran Johor'],

            // Type 2 - Sekretariat
            ['name' => 'Razak Bin Daud', 'notel' => '019-1122334', 'email' => 'razak.sek1@johor.gov.my', 'type' => 2, 'jawatan' => 'Penolong Pegawai Tadbir', 'jabatan' => 'Majlis Bandaraya Johor Bahru'],
            ['name' => 'Siti Aminah Binti Jalil', 'notel' => '017-8899001', 'email' => 'aminah.sek2@johor.gov.my', 'type' => 2, 'jawatan' => 'Pembantu Tadbir (P/O)', 'jabatan' => 'Landskap Johor'],
            ['name' => 'Faizal Bin Rahman', 'notel' => '011-2233445', 'email' => 'faizal.sek3@johor.gov.my', 'type' => 2, 'jawatan' => 'Penolong Jurutera', 'jabatan' => 'Jabatan Kerja Raya Negeri Johor'],
            ['name' => 'Nabila Binti Hamzah', 'notel' => '016-5566778', 'email' => 'nabila.sek4@johor.gov.my', 'type' => 2, 'jawatan' => 'Pembantu Tadbir (Kewangan)', 'jabatan' => 'Perbadanan Kemajuan Perumahan Negeri Johor'],
            ['name' => 'Hadi Bin Kamarudin', 'notel' => '014-9900112', 'email' => 'hadi.sek5@johor.gov.my', 'type' => 2, 'jawatan' => 'Juruteknik Komputer', 'jabatan' => 'Majlis Daerah Kota Tinggi'],
            ['name' => 'Nurul Binti Izzat', 'notel' => '018-3344556', 'email' => 'nurul.sek6@johor.gov.my', 'type' => 2, 'jawatan' => 'Pembantu Operasi', 'jabatan' => 'Pejabat Daerah Mersing'],
            ['name' => 'Shahrul Bin Yusof', 'notel' => '010-6677889', 'email' => 'shahrul.sek7@johor.gov.my', 'type' => 2, 'jawatan' => 'Penolong Akauntan', 'jabatan' => 'Jabatan Pendakwaan Syariah Negeri Johor'],
            ['name' => 'Azlina Binti Roslan', 'notel' => '012-0011223', 'email' => 'azlina.sek8@johor.gov.my', 'type' => 2, 'jawatan' => 'Pegawai Tadbir', 'jabatan' => 'Pejabat Penasihat Undang-undang Negeri Johor'],
            ['name' => 'Firdaus Bin Mokhtar', 'notel' => '013-4455667', 'email' => 'firdaus.sek9@johor.gov.my', 'type' => 2, 'jawatan' => 'Pembantu Awam', 'jabatan' => 'Majlis Perbandaran Pengerang'],
            ['name' => 'Haslinda Binti Karim', 'notel' => '019-7788990', 'email' => 'haslinda.sek10@johor.gov.my', 'type' => 2, 'jawatan' => 'Penolong Pegawai Teknologi Maklumat', 'jabatan' => 'Perbadanan Islam Johor'],

            // Type 3 - Admin
            ['name' => 'Kamal Bin Ibrahim', 'notel' => '017-1029384', 'email' => 'kamal.admin1@johor.gov.my', 'type' => 3, 'jawatan' => 'Penolong Pegawai Tadbir', 'jabatan' => 'Pejabat Menteri Besar Johor'],
            ['name' => 'Marina Binti Salleh', 'notel' => '011-8765432', 'email' => 'marina.admin2@johor.gov.my', 'type' => 3, 'jawatan' => 'Pembantu Tadbir (Kewangan)', 'jabatan' => 'Jabatan Mufti Negeri Johor'],
            ['name' => 'Faiz Bin Osman', 'notel' => '016-2345678', 'email' => 'faiz.admin3@johor.gov.my', 'type' => 3, 'jawatan' => 'Juruteknik Komputer', 'jabatan' => 'Pejabat Setiausaha Kerajaan Johor, Bahagian Pengurusan Sumber Manusia'],
            ['name' => 'Rosmah Binti Ahmad', 'notel' => '014-9876543', 'email' => 'rosmah.admin4@johor.gov.my', 'type' => 3, 'jawatan' => 'Penolong Akauntan', 'jabatan' => 'Pejabat Jurutulis Dewan Undangan Negeri Johor'],
            ['name' => 'Zainal Bin Abidin', 'notel' => '018-1234567', 'email' => 'zainal.admin5@johor.gov.my', 'type' => 3, 'jawatan' => 'Pembantu Operasi', 'jabatan' => 'Majlis Daerah Yong Peng'],
            ['name' => 'Ain Binti Mohd', 'notel' => '010-5432109', 'email' => 'ain.admin6@johor.gov.my', 'type' => 3, 'jawatan' => 'Penolong Jurutera', 'jabatan' => 'Perbendaharaan Negeri Johor'],
            ['name' => 'Izzudin Bin Haris', 'notel' => '012-7890123', 'email' => 'izzudin.admin7@johor.gov.my', 'type' => 3, 'jawatan' => 'Pegawai Tadbir', 'jabatan' => 'Pejabat Setiausaha Kerajaan Johor, Bahagian Pengurusan Sumber Manusia'],
            ['name' => 'Lina Binti Zahari', 'notel' => '013-0987654', 'email' => 'lina.admin8@johor.gov.my', 'type' => 3, 'jawatan' => 'Pembantu Tadbir (P/O)', 'jabatan' => 'Jabatan DiRaja Johor'],
            ['name' => 'Khairul Bin Nizam', 'notel' => '019-6543210', 'email' => 'khairul.admin9@johor.gov.my', 'type' => 3, 'jawatan' => 'Penolong Pegawai Teknologi Maklumat', 'jabatan' => 'Majlis Bandaraya Iskandar Puteri'],
            ['name' => 'Haliza Binti Mohamad', 'notel' => '017-3456789', 'email' => 'haliza.admin10@johor.gov.my', 'type' => 3, 'jawatan' => 'Pembantu Awam', 'jabatan' => 'Jabatan Kebajikan Masyarakat Negeri Johor'],

            // Type 4 - Super Admin
            ['name' => 'Super Admin', 'notel' => '000-0000000', 'email' => 'SuperAdmin@johor.gov.my', 'type' => 4, 'jawatan' => 'Super Admin', 'jabatan' => 'Institut Dato’ Onn'],
            // ['name' => 'Amir Azrien', 'notel' => '010-2870049', 'email' => 'AmirAzrien@johor.gov.my', 'type' => 4, 'jawatan' => 'Pegawai Tadbir', 'jabatan' => 'Pejabat Setiausaha Kerajaan Johor, Bahagian Perancang Ekonomi Negeri Johor'],
            // ['name' => 'Fadzil Bin Iskandar', 'notel' => '019-3333333', 'email' => 'fadzil.super1@johor.gov.my', 'type' => 4, 'jawatan' => 'Pegawai Tadbir', 'jabatan' => 'Muzium DiRaja Abu Bakar Istana Besar Johor'],
            // ['name' => 'Nadiah Binti Halim', 'notel' => '017-4444444', 'email' => 'nadiah.super2@johor.gov.my', 'type' => 4, 'jawatan' => 'Penolong Akauntan', 'jabatan' => 'Pejabat Daerah Johor Bahru'],
            // ['name' => 'Shahril Bin Fauzi', 'notel' => '011-5555555', 'email' => 'shahril.super3@johor.gov.my', 'type' => 4, 'jawatan' => 'Pembantu Operasi', 'jabatan' => 'Unit Strategik Modal Insan Negeri Johor'],
            // ['name' => 'Wani Binti Azman', 'notel' => '016-6666666', 'email' => 'wani.super4@johor.gov.my', 'type' => 4, 'jawatan' => 'Penolong Pegawai Teknologi Maklumat', 'jabatan' => 'Yayasan Pembangunan Keluarga Darul Tak’zim'],
            // ['name' => 'Hakim Bin Salleh', 'notel' => '014-7777777', 'email' => 'hakim.super5@johor.gov.my', 'type' => 4, 'jawatan' => 'Pembantu Tadbir (P/O)', 'jabatan' => 'Pejabat Daerah Pontian'],
            // ['name' => 'Rina Binti Mohd Nor', 'notel' => '018-8888888', 'email' => 'rina.super6@johor.gov.my', 'type' => 4, 'jawatan' => 'Juruteknik Komputer', 'jabatan' => 'Suruhanjaya Perkhidmatan Awam Johor'],
            // ['name' => 'Zaki Bin Hamdan', 'notel' => '010-9999999', 'type' => 4, 'jawatan' => 'Pembantu Tadbir (Kewangan)', 'jabatan' => 'Jabatan Agama Islam Negeri Johor'],
            // ['name' => 'Sofea Binti Zakaria', 'notel' => '012-0000000', 'email' => 'sofea.super8@johor.gov.my', 'type' => 4, 'jawatan' => 'Penolong Jurutera', 'jabatan' => 'Majlis Perbandaran Batu Pahat'],
            // ['name' => 'Nazri Bin Jalil', 'notel' => '013-1110000', 'email' => 'nazri.super9@johor.gov.my', 'type' => 4, 'jawatan' => 'Penolong Pegawai Tadbir', 'jabatan' => 'Pejabat Daerah Segamat'],
            // ['name' => 'Dayang Binti Zaini', 'notel' => '019-2221111', 'email' => 'dayang.super10@johor.gov.my', 'type' => 4, 'jawatan' => 'Pembantu Awam', 'jabatan' => 'Majlis Agama Islam Johor'],
        ];

        foreach ($users as $user) {
            User::create([
                ...$user,
                'password' => Hash::make('123456789'),
            ]);
        }
    }
}
