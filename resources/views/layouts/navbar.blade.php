<nav class="navbar navbar-custom d-lg-none">
    <div class="container-fluid">
        <ul class="navbar-nav d-flex flex-row justify-content-around w-100">
            <li class="nav-item text-center">
                <a class="nav-link" href="/" id="dashboardLink">
                    <i class="bi bi-house-door"></i>
                    <p class="nav-text m-0 p-0">Utama</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/booking" id="bookingLink">
                    <i class="bi bi-calendar-plus"></i>
                    <p class="nav-text m-0 p-0">Layanan</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/riwayat" id="orderLink">
                    <i class="bi bi-hourglass-split"></i>
                    <p class="nav-text m-0 p-0">Riwayat</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/profile" id="profileLink">
                    <i class="bi bi-person"></i>
                    <p class="nav-text m-0 p-0">Profil</p>
                </a>
            </li>
        </ul>
    </div>
</nav>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;

        const links = [{
                path: '/',
                id: 'dashboardLink',
                icon: 'bi-house-door',
                activeIcon: 'bi-house-door-fill'
            },
            {
                path: '/booking',
                id: 'bookingLink',
                icon: 'bi-calendar-plus',
                activeIcon: 'bi-calendar-check-fill'
            },
            {
                path: '/riwayat',
                id: 'orderLink',
                icon: 'bi-clock-history',
                activeIcon: 'bi-clock-history'
            },
            {
                path: '/profile',
                id: 'profileLink',
                icon: 'bi-person',
                activeIcon: 'bi-person-fill'
            },
        ];

        links.forEach(link => {
            const element = document.getElementById(link.id);
            const icon = element.querySelector('i');

            // Menghapus kelas active dari semua elemen
            element.classList.remove('active');
            if (icon) {
                icon.classList.remove(link.activeIcon);
                icon.classList.add(link.icon);
            }

            // Menambahkan kelas active hanya pada elemen yang sesuai
            if (currentPath === link.path) {
                element.classList.add('active');
                if (icon) {
                    icon.classList.remove(link.icon);
                    icon.classList.add(link.activeIcon);
                }
            }
        });
    });
</script>