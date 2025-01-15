@section('title', 'Auth Login')

@section('styles')
    <style>
        @media (max-width: 767px) {
            #bg-container {
                background-image: url('https://i.pinimg.com/474x/9d/5c/13/9d5c13e3d92af6e99120a7b2394263cf.jpg');
                background-size: cover;
                background-position: center;
            }
        }

        /* Untuk perangkat desktop, menggunakan bg-dark */
        @media (min-width: 768px) {
            #bg-container {
                background-color: #22232400;
                /* bg-dark */
            }

        }
    </style>

@endsection

<div class="container mt-1" id="bg-container" style="padding-top:65px; padding-bottom:92px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 col-12">
            <div class="d-flex justify-content-end pe-4 w-100">
                <img src="{{ asset('images/Barberinaja_logo.png') }}" alt="Logo" style="width:150px">
            </div>

            <div class="mx-3 rounded shadow-md mt-4 py-4">
                <div class="card-body bg-transparent emas" style="padding-left: 30px; padding-right: 20px;">
                    <form wire:submit.prevent="login">
                        <h1 class="fs-5 text-center">Masuk</h1>

                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fs-7">Email</label>
                            <input type="email" id="email"
                                class="form-control bg-secondary text-light border-warning" wire:model="email"
                                placeholder="Ketik di sini" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label fs-7">Kata Sandi</label>
                            <input type="password" id="password"
                                class="form-control bg-secondary text-light border-warning pe-5" wire:model="password"
                                placeholder="Ketik di sini" required>
                            <span class="position-absolute end-0 top-0 me-3" onclick="togglePassword()"
                                style="cursor: pointer; margin-top: 37px;">
                                <i id="password-icon" class="fa fa-eye text-warning"></i>
                            </span>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="btn kuning text-white fw-bold py-2 mt-3 px-4 w-100 fs-7">Masuk</button>

                        <div class="d-flex">
                            <a href="/forgot-password"
                                class="text-decoration-none text-warning mt-2 fs-7 text-end mb-2 ms-auto">Lupa
                                password?</a>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-center ps-2">
                    <p class="text-white mt-2 fs-7 text-end mb-2">Anda belum memiliki akun?
                        <a href="/sign_up" class="emas mt-2 fs-7 text-end mb-2">Daftar sekarang!!!
                        </a>
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-center mt-4 px-4 ms-3">
                <div class="p-12rounded d-flex align-items-center">
                    <div class="atas p-1 ms-2 rounded">
                        <img src="https://freepnglogo.com/images/all_img/1691751275tiktok-logo-png-black-and-white.png"
                            alt="Logo" style="width:20px">
                    </div>
    
                    <div class="atas p-1 ms-2 rounded">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Instagram_logo_2022.svg/480px-Instagram_logo_2022.svg.png"
                            alt="Logo" style="width:20px">
                    </div>
    
                    <div class="atas p-1 ms-2 rounded">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Facebook_f_logo_%282019%29.svg/2048px-Facebook_f_logo_%282019%29.svg.png"
                            alt="Logo" style="width:20px">
                    </div>
    
                    <div class="atas p-1 ms-2 rounded">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Youtube_logo.png" alt="Logo"
                            style="width:20px">
                    </div>
                </div>
            </div>

            
        </div>


    </div>

</div>

@push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
