<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="max-height: 3.5rem !important;">
<img src="{{asset('img/logo.png')}}" width="40px" height="40px" class="d-inline-block align-top rounded mr-3" alt="Logo">
  <a class="navbar-brand" href="{{route('tickets')}}">{{env('APP_NAME')}}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item @if(Route::is('tickets')) active @endif"">
        <a class=" nav-link" href="{{route('tickets')}}">Tickets</a>
      </li>

      <li class="nav-item @if(Route::is('todolist')) active @endif"">
        <a class=" nav-link" href="{{route('todolist')}}">Actividades</a>
      </li>

      <li class="nav-item @if(Route::is('base')) active @endif"">
        <a class=" nav-link" href="{{route('base')}}">Base de conocimiento</a>
      </li>


      {{--<li class="nav-item @if(Route::is('diagnosticos')) active @endif"">
        <a class=" nav-link" href="{{route('diagnosticos')}}">Diagnósticos</a>
      </li>--}}

      <li class="nav-item dropdown @if(Route::is('usuarios') || Route::is('catalogos')) active @endif"">
        <a class=" nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
        Administración
        </a>
        <div class="dropdown-menu">
          @can('Seccion usuarios')
          <a class="dropdown-item" href="{{route('usuarios')}}">Usuarios</a>
          @endcan

          @can('Catalogos')
          <a class="dropdown-item" href="{{route('catalogos')}}">Catálogos</a>
          @endcan

          @can('Reporte de unidades')
          <a class="dropdown-item" href="{{route('reporte.unidades')}}">Reporte de unidades</a>
          @endcan

          @can('Almacen')
          <a class="dropdown-item" href="{{route('almacenes')}}">Almacén</a>
          @endcan
          
          
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto" style="margin-right: 100px;">
      <li class="nav-item dropdown show mt-2">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fa fa-bell-o"></i>
          @if($notificaciones > 0)
          <span class="badge badge-danger">1</span>
          @endif
        </a>
        @if($notificaciones > 0)
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <!-- Actividades -->
          <a href="#">
            @if(count($todolist) > 0)
            <a href="{{route('todolist')}}"><span class="dropdown-item dropdown-header">Tienes <span>{{count($todolist)}}</span> actividad(es) pendient(es)</span></a>
            @endif
          </a>
          <!-- ./actividades -->
        </div>
        @endif
      </li> 

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" style="font-size: x-large;">
          <span data-toggle="tooltip" title="{{auth()->user()->name.' '.auth()->user()->lastname}}" data-placement='bottom'>
            @if(auth()->user()->photo != null)
            <img src="{{ asset('storage/perfiles').'/'. auth()->user()->photo }}" class="rounded-circle" style="height:40px; width:40px">
            @else
            {{substr(ucwords(auth()->user()->name),0,1).substr(ucwords(auth()->user()->lastname),0,1)}}
            @endif
          </span>
        </a>

        <div class="dropdown-menu">
          @if(auth()->user()->photo != null)
          <a href="#" id="verFoto" class="dropdown-item verFoto">Ver foto</a>
          @endif
          <a href="{{route('perfil')}}" class="dropdown-item">Pérfil</a>
          <a href="#" id="logout" class="dropdown-item">Salir</a>
          <form id="frmLogout" action="{{route('logout')}}" method="POST">
            @csrf
          </form>
        </div>
      </li>
    </ul>


  </div>
</nav>