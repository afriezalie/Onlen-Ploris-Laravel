<nav class="navbar navbar-expand-lg navbar-dark bg-red">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('user.edit') }}">Profile</a>
                    </li>
                    @if (Auth::user()->role->name == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="adminMenuDropdown" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin Menu
                            </a>
                            <div class="dropdown-menu" aria-labelledby="adminMenuDropdown">
                                <a class="dropdown-item" href="{{ route('courier.index') }}">Courier</a>
                                <a class="dropdown-item" href="{{ route('flower.index_admin') }}">Flower</a>
                                <a class="dropdown-item" href="{{ route('flower_type.index') }}">Flower Type</a>
                                <a class="dropdown-item" href="{{ route('transaction.index') }}">Transaction History</a>
                                <a class="dropdown-item" href="{{ route('user.index') }}">User</a>
                            </div>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link text-white" id="time"></span>
                        <script>showTime();</script>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userMenuDropdown" 
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ explode(" ", Auth::user()->name)[0] }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
                            <a class="dropdown-item" href="{{ route('cart.index') }}">Cart</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
            @endauth

            @guest
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('register') }}">Register</a>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</nav>