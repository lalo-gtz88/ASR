<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top">

    <button class="btn btn-dark d-lg-block d-inline-block" id="toggleSidebar">
        <i class="bi bi-list fs-4"></i>
    </button>

    <div class="container-fluid justify-content-end">

        <!-- Notificaciones -->
        <button class="btn btn-link position-relative me-3">
            <i class="bi bi-bell fs-5"></i>
            {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                3
                <span class="visually-hidden">notificaciones no leídas</span>
            </span> --}}
        </button>

        <!-- Imagen de perfil -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('storage/perfiles/' . auth()->user()->photo) }}" alt="Foto de perfil" width="40" height="40" class="rounded-circle me-2" style="object-fit: cover;">
                <span>{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li>
                    <a class="dropdown-item" href="{{route('perfil')}}">
                        Ver perfil
                    </a>
                </li>
                 <li>
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button class="dropdown-item" type="submit">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>
