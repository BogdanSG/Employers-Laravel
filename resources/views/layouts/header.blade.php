<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ route('home') }}">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::path() == 'treeview' ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('treeview')}}">TreeView <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ Request::path() == 'list' ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('list')}}">List</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                @if(Auth::check())
                    <div>
                        <div class="my-2 my-sm-0 navbar-text" style="color: #eff3f3">Hello, {{Auth::user()->username}}</div>
                        <a class="btn btn-outline-danger my-2 my-sm-0" style="margin-left: 10px" href="{{route('logout')}}">Log out</a>
                    </div>
                @else
                    <div>
                        <a class="btn btn-outline-success my-2 my-sm-0" href="{{route('login')}}">Sign in</a>
                        <a class="btn btn-outline-warning my-2 my-sm-0" style="margin-left: 10px" href="{{route('register')}}">Sign up</a>
                    </div>
                @endif
            </form>
        </div>
    </nav>
</header>
