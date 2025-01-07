<div class="container py-5 mt-1" id="bg-container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-6 col-sm-8 mb-5 col-12">
            <div class="mt-5 mx-3 mb-4 rounded shadow-md py-4">
                <div class="card-body bg-transparent emas py-2" style="padding-left: 30px; padding-right: 20px;">
                    <form wire:submit.prevent="login">
                        <h1 class="fs-5 pb-2 text-center pt-2">Login</h1>

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

                        <!-- Submit Button -->
                        <button type="submit"
                            class="btn kuning text-white fw-bold py-2 mt-3 px-4 w-100 fs-7">Login</button>

                        <div class="d-flex">
                            <a href="#"
                                class="text-decoration-none text-warning mt-2 fs-7 text-end mb-2 ms-auto">Lupa
                                password?</a>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-center ps-2">
                    <p class="text-white mt-2 fs-7 text-end mb-2">Anda belum memiliki akun?
                        <a href="/sign_up" class="emas mt-2 fs-7 text-end mb-2">Daftar</a>
                        sekarang!!!
                    </p>
                </div>
            </div>
        </div>
    </div>

<style>
    /* Untuk perangkat mobile, menggunakan gambar */
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
            background-color: #22232400; /* bg-dark */
        }
    }
</style>
</div>
