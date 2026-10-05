@guest
    <li class="nav-item">
        <a class="nav-link site-nav-link @if(request()->routeIs('login')) active @endif"
            href="{{ route('login') }}">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link site-nav-link @if(request()->routeIs('register')) active @endif"
            href="{{ route('register') }}">Register</a>
    </li>
@else
    @if(in_array(auth()->user()->role, ['admin', 'manager']))
        <li class="nav-item">
            <a class="nav-link site-nav-link @if(request()->is('admin*')) active @endif"
                href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
    @endif
    <li class="nav-item dropdown">
        <a class="nav-link site-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ auth()->user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-raven">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </li>
        </ul>
    </li>
@endguest
