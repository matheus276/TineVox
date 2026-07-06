<nav class="col-md-3 col-lg-2 d-md-block sidebar vh-100% bg-dark" id="sidebar">
        <button id="toggleSidebar" class="btn btn-dark m-2">
                ☰
            </button>
        <img src="{{ asset('images/Logo.webp') }}" alt="Logo" class="img-fluid my-3 " style="max-width: 250px;">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                href="{{ url('/dashboard') }}">
                Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('recording') ? 'active' : '' }}"
                href="{{ url('/recording') }}">
                Gravações
                </a>
            </li>

            <?php if (session('tipo_usuario') === 'admin'): ?>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users') ? 'active' : '' }}"
                    href="{{ url('/users') }}">
                    Usuários
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('condominios') ? 'active' : '' }}"
                    href="{{ url('/condominios') }}">
                    Condominios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('new_ramal') ? 'active' : '' }}"
                    href="{{ url('/new_ramal') }}">
                    Adicionar Ramal
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('logs') ? 'active' : '' }}"
                    href="{{ url('/logs') }}">
                    Logs
                    </a>
                </li>

            <?php endif; ?>
            
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ url('/logout') }}">Sair</a>
            </li>
        </ul>
    </nav>