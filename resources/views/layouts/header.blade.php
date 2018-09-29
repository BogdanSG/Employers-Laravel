<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/home">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item" routerLinkActive="active">
                    <a class="nav-link" href="/treeview">TreeView <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item" routerLinkActive="active">
                    <a class="nav-link" href="/list">List</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <div *ngIf="!isAuthorized">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="/sign-in">Sign in</a>
                    <a class="btn btn-outline-warning my-2 my-sm-0" style="margin-left: 10px" href="/sign-up">Sign up</a>
                </div>
                <div *ngIf="isAuthorized">
                    <div class="my-2 my-sm-0 navbar-text" style="color: #eff3f3">Hello, User</div>
                    <a class="btn btn-outline-danger my-2 my-sm-0" style="margin-left: 10px" href="/log-out">Log out</a>
                </div>
            </form>
        </div>
    </nav>
</header>
