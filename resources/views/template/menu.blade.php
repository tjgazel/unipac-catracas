<nav class="navbar navbar-expand-lg navbar-light bg-light mb-1">
    <div class="container">
        <a class="navbar-brand" href="#">UNIPAC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {{--<li class="nav-item dropdown {{Route::currentRouteName() == 'catracas.index' ||
                    Route::currentRouteName() == 'catracas.show' ||
                    Route::currentRouteName() == 'catracas.relatorios.index' ||
                    Route::currentRouteName() == 'catracas.relatorios.show' ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cogs"></i> Catracas
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{Route::currentRouteName() == 'catracas.index' ? 'active' : ''}}"
                           href="{{route('catracas.index')}}">
                            <i class="fas fa-list"></i> Registros diários
                        </a>
                        <a class="dropdown-item {{Route::currentRouteName() == 'catracas.relatorios.index' ? 'active' : ''}}"
                           href="{{route('catracas.relatorios.index')}}">
                            <i class="far fa-chart-bar text-primary"></i> Relatórios de faltas
                        </a>
                    </div>
                </li>--}}

                <li class="nav-item {{Route::currentRouteName() == 'catracas.relatorios.index' ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('catracas.relatorios.index')}}">
                        <i class="far fa-chart-bar text-primary"></i> Relatórios de faltas
                    </a>
                </li>

                <li class="nav-item {{Route::currentRouteName() == 'catracas.index' ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('catracas.index')}}">
                        <i class="fas fa-list"></i> Registros diários
                    </a>
                </li>

                {{--<li class="nav-item {{Route::currentRouteName() == 'calendarios.index' ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('calendarios.index')}}">
                        <i class="far fa-calendar-alt text-danger"></i> Calendários
                    </a>
                </li>--}}
            </ul>
        </div>
    </div>
</nav>
