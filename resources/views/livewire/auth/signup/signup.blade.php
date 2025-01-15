@section('title', 'Auth SignUp')

<div class="container pb-5 pt-4"
    style="background-image: url('https://i.pinimg.com/474x/d5/ea/d0/d5ead09c1c0b40b0530a444d83c126ad.jpg'); background-size: cover; background-position: center;">
    <div class="row justify-content-center pb-5">
        <div class="col-md-6 col-sm-8 col-12">
            <div class="mt-5 mx-3 rounded shadow-md">
                <div class="card-body abu emas px-2 bg-transparent">
                    <h2 class="fw-bolder">Daftar Sekarang</h2>
                    <div class="card-body">

                        <form wire:submit.prevent="register" class="fs-7">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" wire:model="name"
                                    class="form-control bg-secondary text-light border-warning"
                                    placeholder="Ketik di sini">
                                @error('name')
                                    <div class="text-danger small">Nama tidak boleh kosong.</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" wire:model="email"
                                    class="form-control bg-secondary text-light border-warning"
                                    placeholder="Ketik di sini">
                                @error('email')
                                    <div class="text-danger small">Masukkan email yang valid/gunakan email lain.</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">No. Handphone</label>
                                <input type="number" id="phone_number" wire:model="phone_number"
                                    class="form-control bg-secondary text-light border-warning"
                                    placeholder="Ketik di sini">
                                @error('phone_number')
                                    <div class="text-danger small">Nomor handphone tidak boleh kosong.</div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" id="password" wire:model="password"
                                    class="form-control bg-secondary text-light border-warning pe-5"
                                    placeholder="Ketik di sini">
                                <span class="position-absolute end-0 top-0 me-3"
                                    onclick="togglePassword('password', 'password-icon')"
                                    style="cursor: pointer; margin-top: 37px;">
                                    <i id="password-icon" class="fa fa-eye text-warning"></i>
                                </span>
                                @error('password')
                                    <div class="text-danger small"> Kata Sandi harus diisi min-8 karakter/ulangi pengisian.
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Confirmation Input -->
                            <div class="mb-3 position-relative">
                                <label for="password_confirmation" class="form-label">Ulangi Kata Sandi</label>
                                <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                    class="form-control bg-secondary text-light border-warning pe-5"
                                    placeholder="Ketik di sini">
                                <span class="position-absolute end-0 top-0 me-3"
                                    onclick="togglePassword('password_confirmation', 'password-confirmation-icon')"
                                    style="cursor: pointer; margin-top: 37px;">
                                    <i id="password-confirmation-icon" class="fa fa-eye text-warning"></i>
                                </span>
                                @error('password_confirmation')
                                    <div class="text-danger small">Konfirmasi password harus sesuai dengan password.</div>
                                @enderror
                            </div>

                            <button type="submit"
                                class="btn kuning text-white fw-bold py-2 mt-3 px-4 w-100 fs-7">Daftarkan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
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
