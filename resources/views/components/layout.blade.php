<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

        <title>CRUD Generator</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="w3-light-gray">
        @php use Illuminate\Support\Str; @endphp
        @php use Illuminate\Support\Facades\Schema; @endphp
        <div class="w3-top">
            <div class="w3-bar w3-black w3-wide w3-padding w3-card">
              <a href="/" class="w3-bar-item w3-button"><b>CRUD</b> Generator</a>
            </div>
        </div>

            <div class="w3-content w3-padding">
                {{ $slot }}
            </div>
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            position: "top-end",
                            text: "{{ session('success') }}",
                            icon: 'success',
                            showConfirmButton: false,
                            width: '25%',
                            height: '10%',
                            timer: 1500,
                        });
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            position: "top-end",
                            text: "{{ session('error') }}",
                            icon: 'error',
                            showConfirmButton: false,
                            width: '20%',
                            height: '10%',
                            timer: 1500,
                        });
                    });
                </script>
            @endif
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </body>
</html>
