<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #08C;">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-light {{ Request::is('admin.users') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light {{ Request::is('admin.posts') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">Posts</a>
                </li>
            </ul>
            <form class="d-flex mb-0" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link text-white">Logout</button>
            </form>
        </div>
    </div>
</nav>