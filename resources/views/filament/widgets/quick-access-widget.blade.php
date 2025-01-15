<div>
    <p class="head">Tambahkan Disini</p>

    <div class="button-container">
        @php
            $buttons = [
                [
                    'text' => 'Customer',
                    'class' => 'btn-yellow',
                    'icon' => 'user-icon',
                    'action' => 'registerCustomer',
                ],
                [
                    'text' => 'Barber',
                    'class' => 'btn-yellow',
                    'icon' => 'user-circle-icon',
                    'action' => 'registerBarber',
                ],

                [
                    'text' => 'Page Tren',
                    'class' => 'btn-yellow',
                    'icon' => 'trending-up-icon',
                    'action' => 'addTren',
                ],
                [
                    'text' => 'Page Barber',
                    'class' => 'btn-yellow',
                    'icon' => 'scissors-icon',
                    'action' => 'addBarber',
                ],
                [
                    'text' => 'Page Layanan',
                    'class' => 'btn-yellow',
                    'icon' => 'briefcase-icon',
                    'action' => 'addService',
                ],
            ];
        @endphp

        @foreach ($buttons as $button)
            <button class="btn {{ $button['class'] }}" wire:click="{{ $button['action'] }}">
                <span class="{{ $button['icon'] }}"></span>
                {{ $button['text'] }}
            </button>
        @endforeach

        <style>
            .head {
                font-size: 18px;
                font-weight: bold;
                color: #fafafa;
            }

            .button-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(80px, 0.3fr));
                gap: 8px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .btn {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 5px 5px;
                /* Padding konsisten agar tinggi tombol sama */
                height: 50px;
                /* Menetapkan tinggi tombol agar sama */
                border: none;
                border-radius: 5px;
                font-size: 12px;
                color: white;
                cursor: pointer;
                text-align: start;
                transition: background-color 0.3s ease;
            }

            .btn span {
                margin-right: 5px;
            }

            .btn-blue {
                background-color: #007bff;
            }

            .btn-blue:hover {
                background-color: #0056b3;
            }

            .btn-indigo {
                background-color: #6610f2;
            }

            .btn-indigo:hover {
                background-color: #520dc2;
            }

            .btn-yellow {
                background-color: #a48118;
                ;
                color: #000;
            }

            .btn-yellow:hover {
                background-color: rgb(205, 157, 11);
                ;
            }

            .btn-green {
                background-color: #28a745;
            }

            .btn-green:hover {
                background-color: #218838;
            }

            .btn-red {
                background-color: #dc3545;
            }

            .btn-red:hover {
                background-color: #c82333;
            }

            /* Dummy icons */
            .user-icon::before {
                content: '👤';
            }

            .user-circle-icon::before {
                content: '👥';
            }

            .trending-up-icon::before {
                content: '📈';
            }

            .scissors-icon::before {
                content: '✂️';
            }

            .briefcase-icon::before {
                content: '💼';
            }
        </style>

    </div>
</div>
