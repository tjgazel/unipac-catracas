<nav class="navbar navbar-expand-lg navbar-light bg-light mb-1">
    <div class="container">
        <a class="navbar-brand" href="#">UNIPAC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item {{Route::currentRouteName() == 'catracas.index' ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('catracas.index')}}">
                        <i class="fas fa-list"></i> Registros diários
                    </a>
                </li>
                <li class="nav-item {{Route::currentRouteName() == 'catracas.relatorios.index' ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('catracas.relatorios.index')}}">
                        <i class="far fa-chart-bar text-primary"></i> Relatórios de faltas
                    </a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if (Gate::allows('admin'))
                                <a class="dropdown-item" href="{{ route('gerenciar-usuarios.index') }}">Gerenciar Usuários</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
