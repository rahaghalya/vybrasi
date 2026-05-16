<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title', 'Vybrasi - Premium Coffee')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* --- VYBRASI x KOPI SEPAKUNG GLOBAL STYLE --- */
        :root {
            /* Warna Dasar & Latar */
            --vy-bg: #FAF6ED;       /* Krem Kabut Pagi */
            --vy-bg-alt: #EBE5D9;   /* Krem Tanah */
            
            /* Warna Aksen & Teks */
            --vy-text: #5C4A3D;     /* Cokelat Kopi Lembut (Teks Paragraf) */
            --vy-dark: #2C1E16;     /* Cokelat Gelap (Judul & Footer) */
            --vy-green: #2C5530;    /* Hijau Rimba Sepakung (Tombol & Aksen Utama) */
            --vy-gold: #D4A373;     /* Emas Sangrai (Sorotan & Bintang) */
        }

        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Montserrat', sans-serif; /* Tetap pakai font andalanmu */
            
            /* Latar belakang global disesuaikan dengan nuansa kabut */
            background-color: var(--vy-bg); 
            color: var(--vy-text);
            
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            scroll-behavior: smooth;
        }
        
        main { 
            flex-grow: 1; 
            min-height: 70vh; 
        }

        /* --- CUSTOM SCROLLBAR SEPAKUNG EDITION --- */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: var(--vy-bg-alt); /* Jalur scrollbar warna krem redup */
        }
        ::-webkit-scrollbar-thumb {
            background: #8C593B; /* Gagang scrollbar warna cokelat kayu */
            border-radius: 10px;
            border: 2px solid var(--vy-bg-alt); /* Efek padding */
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--vy-green); /* Menyala jadi hijau daun saat disorot mouse */
        }

        /* --- CUSTOM TEXT SELECTION (Saat teks diblok oleh kursor) --- */
        ::selection {
            background: var(--vy-green); /* Blok warna hijau rimba */
            color: #FAF6ED; /* Teks jadi putih krem */
        }
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