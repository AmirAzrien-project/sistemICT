<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/home.css'])
</head>

<body>
    <!-- Main Content -->
    <div class="container my-5">
        <div class="main-content p-4 p-md-5 shadow-lg">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Maklumat Profil') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Kemas kini maklumat profil akaun dan alamat emel anda.') }}
                    </p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="form-label">{{ __('Nama') }}</label>
                        <input id="name" name="name" type="text" class="form-control"
                            value="{{ Auth::user()->name }}" required autofocus autocomplete="name" />
                    </div>
                    <br>
                    <div>
                        <label for="email" class="form-label">{{ __('E-mel') }}</label>
                        <input id="email" name="email" type="email" class="form-control"
                            value="{{ Auth::user()->email }}" required autocomplete="username" />
                    </div>
                    <br>
                    <div>
                        <label for="notel" class="form-label">{{ __('No Tel') }}</label>
                        <input id="notel" name="notel" type="text" class="form-control"
                            value="{{ Auth::user()->notel }}" required autocomplete="username" maxlength="12"
                            oninput="formatNotel(this)" placeholder="012-3456789" />
                    </div>
                    <br>
                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn btn-johor">{{ __('Simpan') }}</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function formatNotel(input) {
            let val = input.value.replace(/\D/g, ''); // Buang semua bukan nombor
            if (val.length > 3) {
                val = val.slice(0, 3) + '-' + val.slice(3, 10);
            }
            input.value = val;
        }
    </script>
</body>

</html>
