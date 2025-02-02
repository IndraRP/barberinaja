@section("title", "Auth Login")

@section("styles")
    <style>
        @media (max-width: 767px) {
            #bg-container {
                background-image: url('https://i.pinimg.com/474x/9d/5c/13/9d5c13e3d92af6e99120a7b2394263cf.jpg');
                background-size: cover;
                background-position: center;
            }
        }

        /* Untuk perangkat desktop, menggunakan bg-dark */
        #bg-container {
            background-color: #22232400;
            /* bg-dark */
        }
        }
    </style>

@endsection

<div class="container mt-1" id="bg-container" style="padding-top:50px; padding-bottom:92px;">
    <div class="row justify-content-center">
        <div class="d-flex justify-content-end w-100 mb-2 me-4 pe-4">
            <img src="{{ asset("storage/" . $this->logo->image) }}" alt="Logo" style="width:150px">
        </div>
        <div class="col-md-6 col-sm-8 col-12">
            <div class="mx-3 mt-4 rounded py-4 shadow-md">
                <div class="card-body emas bg-transparent" style="padding-left: 30px; padding-right: 20px;">
                    <form wire:submit.prevent="login">
                        <h1 class="fs-5 text-center">Masuk</h1>

                        @if (session()->has("error"))
                            <div class="alert alert-danger">
                                {{ session("error") }}
                            </div>
                        @endif

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fs-7">Email</label>
                            <input type="email" id="email" class="form-control bg-secondary text-light border-warning" wire:model="email" placeholder="Ketik di sini" required>
                            @error("email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="position-relative mb-3">
                            <label for="password" class="form-label fs-7">Kata Sandi</label>
                            <input type="password" id="password" class="form-control bg-secondary text-light border-warning pe-5" wire:model="password" placeholder="Ketik di sini" required>
                            <span class="position-absolute end-0 top-0 me-3" onclick="togglePassword()" style="cursor: pointer; margin-top: 37px;">
                                <i id="password-icon" class="fa fa-eye text-warning"></i>
                            </span>
                            @error("password")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn kuning fw-bold w-100 fs-7 mt-3 px-4 py-2 text-white">Masuk</button>

                        <div class="d-flex">
                            <a href="/forgot-password" class="text-decoration-none text-warning fs-7 mb-2 ms-auto mt-2 text-end">Lupa
                                password?</a>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-center ps-2">
                    <p class="fs-7 mb-2 mt-2 text-end text-white">Anda belum memiliki akun?
                        <a href="/sign_up" class="emas fs-7 mb-2 mt-2 text-end">Daftar sekarang!!!
                        </a>
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-center ms-3 mt-4 px-4">
                <div class="p-12rounded d-flex align-items-center">
                    <div class="atas ms-2 rounded p-1">
                        <img src="{{ asset("storage/" . $this->FB->image) }}" alt="Logo" style="width:23px">
                    </div>

                    <div class="atas ms-2 rounded p-1">
                        <img src="{{ asset("storage/" . $this->TT->image) }}" alt="Logo" style="width:23px">
                    </div>

                    <div class="atas ms-2 rounded p-1">
                        <img src="{{ asset("storage/" . $this->YT->image) }}" alt="Logo" style="width:23px">
                    </div>

                    <div class="atas ms-2 rounded p-1">
                        <img src="{{ asset("storage/" . $this->IG->image) }}" alt="Logo" style="width:23px">
                    </div>
                </div>
            </div>


        </div>


    </div>

</div>

@push("scripts")
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
