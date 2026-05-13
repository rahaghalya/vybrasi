<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Mulai Perjalanan Kopimu (Daftar)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css-admin/daftar.css') }}">
    <style>
        .error-message {
            color: #C25953;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            text-align: left;
        }

        /* CSS KHUSUS UNTUK POP-UP CUSTOM */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-box {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 420px;
            width: 90%;
            transform: translateY(-20px);
            transition: all 0.3s ease;
            border-top: 5px solid #28a745; /* Border sukses */
        }
        .modal-box.error {
            border-top: 5px solid #C25953; /* Border error */
        }
        .modal-overlay.active .modal-box {
            transform: translateY(0);
        }
        .modal-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .modal-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .modal-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        /* Style list error agar rapi di dalam pop-up */
        .modal-error-list {
            text-align: left;
            color: #C25953;
            font-size: 13px;
            margin-bottom: 20px;
            padding-left: 20px;
        }
        .btn-close-modal {
            background: #D4A373;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-close-modal:hover {
            background: #b58b61;
        }
        .modal-loading {
            display: none;
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
        .modal-loading.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="register-container">
        
        <div class="hero-section">
            <h1 class="hero-text">Mulai<br>Perjalanan<br>Kopimu</h1>
        </div>

        <div class="form-section">
            <div class="register-box">
                <h2>Daftar</h2>
                
                <form action="{{ route('daftar.proses') }}" method="POST">
                    @csrf 
                    
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukan nama" required>
                        @error('name') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Gmail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
                        @error('email') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>

                    <div class="auth-link-container">
                        <span class="auth-link-text">Sudah punya akun? <a href="{{ route('login') }}">Login</a></span>
                    </div>

                    <button type="submit" class="btn-register">Daftar & Mulai Belanja</button>
                </form>
                
            </div>
        </div>

    </div>

    {{-- Modal Pop-up --}}
    <div class="modal-overlay" id="customModal">
        <div class="modal-box" id="modalBox">
            <div class="modal-icon" id="modalIcon"></div>
            <h3 class="modal-title" id="modalTitle"></h3>
            <p class="modal-text" id="modalMessage"></p>
            
            {{-- Tempat memunculkan list error dari Laravel --}}
            <ul class="modal-error-list" id="modalErrorList" style="display: none;"></ul>

            <button class="btn-close-modal" id="modalBtn" onclick="closeModal()">OK</button>
            <p class="modal-loading" id="modalLoading">Mengalihkan ke halaman login...</p>
        </div>
    </div>

    <script>
        const IS_SUCCESS = @json(session()->has('success'));
        const SUCCESS_MSG = @json(session('success'));
        const HAS_ERRORS = @json($errors->any());
        // Menangkap semua pesan error ke dalam array JavaScript
        const ERRORS_LIST = @json($errors->all());

        function showModal(icon, title, message, isError = false) {
            document.getElementById('modalIcon').innerText = icon;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;

            const modalBox = document.getElementById('modalBox');
            const errorListUl = document.getElementById('modalErrorList');

            if (isError) {
                modalBox.classList.add('error');
                // Menampilkan daftar error spesifik
                if(ERRORS_LIST.length > 0) {
                    errorListUl.innerHTML = '';
                    ERRORS_LIST.forEach(err => {
                        errorListUl.innerHTML += `<li>${err}</li>`;
                    });
                    errorListUl.style.display = 'block';
                }
            } else {
                modalBox.classList.remove('error');
                errorListUl.style.display = 'none';
            }

            document.getElementById('customModal').classList.add('active');
        }

        function closeModal() {
            if (IS_SUCCESS) {
                // Tampilkan loading text sebelum redirect
                document.getElementById('modalBtn').disabled = true;
                document.getElementById('modalBtn').innerText = 'Menunggu...';
                document.getElementById('modalLoading').classList.add('show');
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1000);
            } else {
                document.getElementById('customModal').classList.remove('active');
            }
        }

        // Jalankan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            if (IS_SUCCESS) {
                showModal('✅', 'Pendaftaran Berhasil!', SUCCESS_MSG || 'Akun kamu berhasil dibuat. Silakan login untuk mulai belanja.', false);
            } else if (HAS_ERRORS) {
                showModal('⚠️', 'Pendaftaran Gagal', 'Mohon perbaiki kesalahan berikut:', true);
            }
        });
    </script>
</body>
</html>