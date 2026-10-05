@guest
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('login')) active @endif" href="{{ route('login') }}">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('register')) active @endif" href="{{ route('register') }}">Register</a>
    </li>
@else
    @if(in_array(auth()->user()->role, ['admin', 'manager']))
        <li class="nav-item">
            <a class="nav-link @if(request()->is('admin*')) active @endif"
                href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
    @endif
    <li class="nav-item">
        <span class="nav-link text-gold">{{ auth()->user()->name }}</span>
    </li>
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link btn btn-link border-0 p-0">Logout</button>
        </form>
    </li>
@endguest
