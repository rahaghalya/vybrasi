<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title', 'Vybrasi - Premium Coffee')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Montserrat', sans-serif; 
            
            /* TEMA SEPAKUNG NGALAS (Earthy Nature) */
            /* Background gradasi natural krem bersih ke krem hangat */
            background: linear-gradient(135deg, #F9F6F0, #ECE3D4);
            
            /* Teks warna Hijau Telomoyo pekat agar kontras dan sangat jelas dibaca */
            color: #253B2B; 
            min-height: 100vh;
        }
        main { min-height: 70vh; }
    </style>
</head>
<body class="antialiased">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>