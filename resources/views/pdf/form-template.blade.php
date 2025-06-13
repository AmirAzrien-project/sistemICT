<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kertas Kerja Permohonan Kelulusan Teknikal Projek ICT</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 40px 40px;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
        }

        h1 {
            text-align: left;
            font-size: 16pt;
            font-weight: bold;
            margin-top: 1px;
            margin-bottom: 1px;
        }

        h2,
        h3 {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        p {
            margin: 20px 40px;
            font-size: 18px;
            text-align: justify;
            margin-bottom: 2.5rem;
        }

        .section {
            margin-bottom: 25px;
        }

        .section label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        .section p.boxed {
            border: 1px solid #000;
            padding: 10px;
            min-height: 40px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 22px;
            margin-right: 40px;
            margin-top: 15px;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .total-row td {
            font-weight: bold;
            text-align: right;
        }

        ol,
        ul {
            font-size: 17px !important;
            margin-left: 40px !important;
            padding-left: 30px !important;
            margin-right: 40px;
            margin-bottom: 2rem;
        }

        ol ol,
        ul ul {
            font-size: 17px !important;
            margin-left: 40px !important;
            padding-left: 30px !important;
            margin-right: 40px;
            margin-bottom: 2rem;
        }

        /* Optional: Page Break for PDF */
        .page-break {
            page-break-before: always;
        }

        .contact-info div {
            margin-left: 40px;
            margin-bottom: 6px;
            font-size: 12pt;
        }

        .label {
            display: inline-block;
            width: 220px;
            font-weight: bold;
        }

        .signature-container {
            margin-top: 40px;
            width: 250px;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }

        .signature-space {
            margin-bottom: 5px;
            border-bottom: 1.5px solid #000;
            height: 40px;
            width: 70%;
            display: inline-block;
            line-height: 40px;
            font-style: italic;
        }

        .signature-label {
            margin-top: 0;
        }

        .date-line {
            margin-top: 10px;
            font-size: 12pt;
        }
    </style>

</head>

<body>

    <br>

    <h3>PERMOHONAN KELULUSAN</h3>

    <h3 style="margin-bottom: 6rem;margin-top: 0">JAWATANKUASA TEKNIKAL ICT (JTICT)</h3>

    <h3 style="margin-bottom: 5rem;">Mengemukakan Kertas Cadangan</h3>

    <p style="text-align: center; font-size:18px; margin-bottom: 6rem">{{ $tajuk }}</p>

    <br>

    <p style="text-align: center; font-size:18px; margin-bottom: 7rem">Oleh</p>

    <br><br><br><br>

    <p style="text-align: center; font-size:20px">{!! str_replace(',', '<br>', $jabatan) !!}</p>
    {{-- <p style="text-align: center; font-size:20px">{{ $jabatan }}</p> --}}

    <br>

    <div class="section">

        <h1>1.0 TUJUAN</h1>
        <p style="margin-bottom: 2.5rem">Kertas cadangan ini bertujuan memohon pertimbangan untuk mendapatkan kelulusan
            daripada Jawatankuasa Teknikal
            ICT Kerajaan Negeri Johor mengenai cadangan perolehan Permohonan Pertukaran (Change Request) Sistem ePNJ
            untuk diperakukan kepada Jawatankuasa Pemandu ICT Kerajaan Negeri Johor.</p>

        <h1>2.0 LATAR BELAKANG SISTEM</h1>
        <p style="margin-top: -0.5rem"> {!! $tajuk_latar_belakang !!} </p>
        @if (
            !empty($latar_belakang) &&
                (is_array($latar_belakang) ? count(array_filter($latar_belakang)) : trim($latar_belakang) !== ''))
            <ol style="list-style-type: lower-roman; margin-left:28px; margin-right:40px; margin-bottom: 2rem">
                @if (is_array($latar_belakang))
                    @foreach (array_filter($latar_belakang) as $item)
                        <li style="text-align: justify; font-size:13pt">{{ $item }}</li>
                    @endforeach
                @else
                    @foreach (explode("\n", $latar_belakang) as $item)
                        @if (trim($item) !== '')
                            <li style="text-align: justify; font-size:13pt">{{ $item }}</li>
                        @endif
                    @endforeach
                @endif
            </ol>
        @endif

        <h1>3.0 KEKANGAN SISTEM SEDIA ADA</h1>
        <p style="margin-top: -0.5rem"> {!! $tajuk_kekangan !!} </p>
        {{-- <p> {!! is_array($kekangan) ? implode('<br>', $kekangan) : nl2br(e($kekangan)) !!} </p> --}}

        {{-- 4.0 OBJEKTIF --}}
        <h1>4.0 OBJEKTIF</h1>
        <p style="margin-top: -0.5rem"> {!! $tajuk_objektif !!} </p>
        @if (!empty($objektif) && (is_array($objektif) ? count(array_filter($objektif)) : trim($objektif) !== ''))
            <ol style="list-style-type: lower-roman; margin-left:28px; margin-right:40px; margin-bottom: 2rem">
                @if (is_array($objektif))
                    @foreach (array_filter($objektif) as $item)
                        <li style="text-align: justify; font-size:13pt">{{ $item }}</li>
                    @endforeach
                @else
                    @foreach (explode("\n", $objektif) as $item)
                        @if (trim($item) !== '')
                            <li style="text-align: justify; font-size:13pt">{{ $item }}</li>
                        @endif
                    @endforeach
                @endif
            </ol>
        @endif

        {{-- 5.0 JUSTIFIKASI PEMBANGUNAN CR --}}
        <h1>5.0 JUSTIFIKASI PEMBANGUNAN CR</h1>
        <p style="margin-top: -0.5rem"> {!! $tajuk_justifikasi !!} </p>
        @if (!empty($justifikasi) && (is_array($justifikasi) ? count(array_filter($justifikasi)) : trim($justifikasi) !== ''))
            <ol style="list-style-type: lower-roman; margin-left:28px; margin-right:40px; margin-bottom: 2rem">
                @if (is_array($justifikasi))
                    @foreach (array_filter($justifikasi) as $item)
                        <li style="text-align: justify; font-size:13pt">{{ $item }}</li>
                    @endforeach
                @else
                    @foreach (explode("\n", $justifikasi) as $item)
                        @if (trim($item) !== '')
                            <li style="text-align: justify; font-size:13pt">{{ $item }}</li>
                        @endif
                    @endforeach
                @endif
            </ol>
        @endif
    </div>

    {{-- 6.0 IMPLIKASI KEWANGAN --}}
    <h1 style="page-break-before: always;">6.0 IMPLIKASI KEWANGAN</h1>
    <table>
        <thead>
            <tr>
                <th>BIL</th>
                <th>KETERANGAN</th>
                <th>KOS UNIT (RM)</th>
                <th>SST (RM)</th>
                <th>KOS UNIT (RM) + SST</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalJumlah = 0;
                $totalSST = 0;
                $totalAkhir = 0;
            @endphp
            @foreach ($keterangan ?? [] as $i => $desc)
                @php
                    $j = isset($jumlah[$i]) ? floatval($jumlah[$i]) : 0;
                    $flag = isset($sst_flag[$i]) ? $sst_flag[$i] : '';
                    $sst = $flag === 'Ada' ? $j * 0.08 : 0;
                    $akhir = $j + $sst;
                    $totalJumlah += $j;
                    $totalSST += $sst;
                    $totalAkhir += $akhir;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $desc }}</td>
                    <td style="text-align:center">{{ number_format($j, 2) }}</td>
                    <td style="text-align:center">{{ $flag === 'Ada' ? number_format($sst, 2) : '0.00' }}</td>
                    <td style="text-align:center">{{ number_format($akhir, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2" style="text-align:right">JUMLAH KESELURUHAN</td>
                <td style="text-align:center">{{ number_format($totalJumlah, 2) }}</td>
                <td style="text-align:center">{{ number_format($totalSST, 2) }}</td>
                <td style="text-align:center">{{ number_format($totalAkhir, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <p style="margin-bottom: 2.5rem">Anggaran kos bagi Permohonan Pertukaran (Change Request)
        <pp>{{ $tajuk }}</pp> adalah berjumlah <b>RM
            {{ number_format($totalAkhir, 2) }}</b> dan akan
        menggunakan bajet P71. Sila rujuk LAMPIRAN untuk spesifikasi teknikal dan kos terperinci.
    </p>

    <div class="section">

        <h1>7.0 SYOR</h1>
        <p style="margin-bottom: 2rem">Kertas cadangan ini dikemukakan kepada Mesyuarat Jawatankuasa Teknikal ICT
            Kerajaan Negeri Johor untuk
            pertimbangan dan seterusnya kelulusan Mesyuarat Jawatankuasa Pemandu ICT Kerajaan Negeri Johor.</p>

        <h1>8.0 PERAKUAN</h1>
        <p style="margin-bottom: 2rem">Ahli Mesyuarat Jawatankuasa Teknikal ICT Kerajaan Negeri Johor adalah dipohon
            menimbang perakuan syor di para
            7.0. seperti di atas kepada Ahli Mesyuarat Jawatankuasa Pemandu ICT Kerajaan Negeri Johor.</p>

        <h1>9.0 MAKLUMAT PEGAWAI YANG DIHUBUNGI</h1>
        <br>
        <div class="contact-info" style="margin-bottom: 2rem">
            <div><span class="label">Nama Pegawai Penyelaras</span> : <span> {{ $nama_penyelaras }}</span></div>
            <div><span class="label">Jawatan</span> : <span> {{ $jawatan }}</span></div>
            <div><span class="label">Gred Jawatan</span> : <span> {{ $gred_jawatan }}</span></div>
            <div><span class="label">No Telefon</span> : <span> {{ $notel }}</span></div>
            <div><span class="label">No Fax</span> : <span> {{ $nofax }}</span></div>
            <div><span class="label">E-mel</span> : <span> {{ $email }}</span></div>
        </div>

        <h1>KEPUTUSAN</h1>
        <p>Mesyuarat Jawatankuasa Teknikal ICT Kerajaan Negeri Johor dengan ini (meluluskan / tidak meluluskan) cadangan
            perolehan Permohonan Pertukaran (Change Request) iaitu <b>RM
                {{ number_format($totalAkhir, 2) }}</b> bagi
            <pp>{{ $tajuk }}</pp> diperakukan ke
            Mesyuarat Jawatankuasa Pemandu ICT Kerajaan Negeri Johor.
        </p>
        <div class="signature-container">
            <div class="signature-space"></div>
            <p class="date-line">Tarikh: </p>
        </div>

    </div>

</body>

</html>
