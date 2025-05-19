    <!-- Navbar para pantallas pequeñas -->
    <nav class="navbar navbar-dark bg-dark d-lg-none" style="background: linear-gradient(to bottom right, #002b4c, #0078d4);">
        <div class="container-fluid ">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <i class="bi bi-list"></i> Menú
            </button>
        </div>
    </nav>

    <!-- Sidebar fijo en pantallas grandes -->
    <div class="sidebar d-none d-lg-block">
        <h5 class="text-center">NetDesk</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-house"></i> Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('tickets')}}"><i class="bi bi-ticket"></i> Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center toggleSubmenu" href="#">
                    <span><i class="bi bi-pc-display"></i> Equipos</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="submenu">
                    <li><a class="nav-link" href="{{route('equipos')}}"><i class="bi bi-box-seam"></i> Inventario</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center toggleSubmenu" href="#">
                    <span><i class="bi bi-globe"></i> Red</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="submenu">
                    <li><a class="nav-link" href="{{route('enlaces')}}"><i class="bi bi-link"></i> Enlaces</a></li>
                    <li><a class="nav-link" href="{{route('mapaEnlaces')}}"><i class="bi bi-geo-alt"></i> Mapa</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('todolist')}}"><i class="bi bi-list-task"></i> Actividades</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('almacenes')}}"><i class="bi bi-clipboard-check"></i> Almacén</a>
            </li>


            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center toggleSubmenu" href="#">
                    <span><i class="bi bi-gear"></i> Administración</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="submenu">
                    <li><a class="nav-link" href="{{route('catalogos')}}"><i class="bi bi-journals"></i> Catálogos</a></li>
                    <li><a class="nav-link" href="{{route('usuarios')}}"><i class="bi bi-people"></i> Usuarios</a></li>
                    
                </ul>
            </li>

            <li class="nav-item">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button class="nav-link" type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Offcanvas para pantallas pequeñas -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel"
    style="background: linear-gradient(to bottom right, #002b4c, #0078d4);">
        <div class="offcanvas-header">
            <h5 id="mobileSidebarLabel" class="text-white">NetDesk</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                 <li class="nav-item">
                <a class="nav-link text-white" href="#"><i class="bi bi-house"></i> Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{route('tickets')}}"><i class="bi bi-ticket"></i> Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center toggleSubmenu" href="#">
                    <span><i class="bi bi-pc-display"></i> Equipos</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="submenu">
                    <li><a class="nav-link text-white" href="{{route('equipos')}}"><i class="bi bi-box-seam"></i> Inventario</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center toggleSubmenu" href="#">
                    <span><i class="bi bi-globe"></i> Red</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="submenu">
                    <li><a class="nav-link text-white" href="{{route('enlaces')}}"><i class="bi bi-link"></i> Enlaces</a></li>
                    <li><a class="nav-link text-white" href="{{route('mapaEnlaces')}}"><i class="bi bi-geo-alt"></i> Mapa</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{route('todolist')}}"><i class="bi bi-list-task"></i> Actividades</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{route('almacenes')}}"><i class="bi bi-clipboard-check"></i> Almacén</a>
            </li>


            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center toggleSubmenu" href="#">
                    <span><i class="bi bi-gear"></i> Administración</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="submenu">
                    <li><a class="nav-link text-white" href="{{route('catalogos')}}"><i class="bi bi-journals"></i> Catálogos</a></li>
                    <li><a class="nav-link text-white" href="{{route('usuarios')}}"><i class="bi bi-people"></i> Usuarios</a></li>
                    
                </ul>
            </li>

            <li class="nav-item">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button class="nav-link text-white" type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
                </form>
            </li>
            </ul>
        </div>
    </div>