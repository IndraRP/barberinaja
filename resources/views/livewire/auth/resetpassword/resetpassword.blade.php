@section('title', 'Auth ResetPassword')

@section('styles')
    <style>
        .cont {
            padding-top: 80px;
            padding-bottom: 120px;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .abu {
            background-color: #292a2dc0;
            border-radius: 10px;
        }

        .atas {
            background-color: #1f2022;
            border-radius: 10px;
        }
    </style>
@endsection

<div class="cont"
    style="background-image: url('https://i.pinimg.com/474x/60/fe/cb/60fecbac0b8368d71a5d5360fc591316.jpg'); background-size: cover; background-position: center;">
    <div class="row justify-content-center mx-4 abu">
        <div class="col-md-6 my-5">
            <h4 class="emas text-center">Masukkan Password Baru Anda</h4>
            <p class="fs-7 text-white text-center">
                Masukkan password baru Anda di bawah ini dan konfirmasikan password tersebut.
            </p>
            <form wire:submit.prevent="resetPassword">
                <div class="mb-3 position-relative">
                    <label for="new_password" class="form-label fs-7">Kata Sandi</label>
                    <input type="password" id="password"
                        class="form-control bg-secondary text-light border-warning pe-5" wire:model.defer="password"
                        placeholder="Ketik di sini" required>
                    <span class="position-absolute end-0 top-0 me-3"
                        onclick="togglePassword('password', 'password-icon')"
                        style="cursor: pointer; margin-top: 37px;">
                        <i id="password-icon" class="fa fa-eye text-warning"></i>
                    </span>
                </div>

                <div class="mb-3 position-relative">
                    <label for="confirm_password" class="form-label fs-7">Konfirmasi Kata Sandi</label>
                    <input type="password" id="confirm_password"
                        class="form-control bg-secondary text-light border-warning pe-5"
                        wire:model.defer="password_confirmation" placeholder="Ketik di sini" required>
                    <span class="position-absolute end-0 top-0 me-3"
                        onclick="togglePassword('confirm_password', 'confirm-password-icon')"
                        style="cursor: pointer; margin-top: 37px;">
                        <i id="confirm-password-icon" class="fa fa-eye text-warning"></i>
                    </span>
                </div>

                <div class="form-group mt-3 text-end">
                    <button type="submit" class="btn kuning text-white fs-7 p-2 btn-sm booking-btn">
                        Reset Password
                    </button>
                </div>
            </form>
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
