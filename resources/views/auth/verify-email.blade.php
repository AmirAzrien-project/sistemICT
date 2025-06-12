<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Emel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/home.css'])

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1692119141571-00c2f1137636?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
            background-size: cover;
        }

        .bg-overlay {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        }

        .johor-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-right: 1rem;
            border-radius: 20%;
            /* Jadikan logo bulat */
            background: #fff;
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 576px) {
            .johor-logo {
                width: 40px;
                height: 40px;
            }

            .bg-overlay {
                padding: 1.2rem !important;
            }
        }
    </style>
</head>

<body>
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="mb-4 text-center">
            <img src="https://images.seeklogo.com/logo-png/30/1/kerajaan-negeri-johor-logo-png_seeklogo-306450.png"
                alt="Logo Johor" class="johor-logo">
            <div>
                <span class="fw-bold fs-4 text-primary">SISTEM KERAJAAN JOHOR</span><br>
                <span class="text-secondary fs-6">Pengesahan Emel Pengguna</span>
            </div>
        </div>
        <div class="bg-overlay p-4 p-md-5 w-100" style="max-width: 430px;">
            <div class="mb-3 text-secondary small">
                Terima kasih kerana mendaftar! Sebelum anda boleh menggunakan sistem, sila sahkan alamat emel anda
                dengan klik pautan yang telah dihantar ke emel anda.<br>
                Jika anda tidak menerima emel, anda boleh minta sistem hantar semula.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success py-2 mb-3" role="alert">
                    Semak emel anda — pengesahan yang baru telah dihantar. </div>
            @endif

            <div class="d-flex flex-column gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Hantar Emel Pengesahan
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        Log Keluar
                    </button>
                </form>
            </div>
        </div>
        <div class="text-center text-muted mt-4 small">
            &copy; {{ date('Y') }} Sistem Kerajaan Johor. Hak Cipta Terpelihara.
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
