<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #08C;">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-light {{ Request::is('admin.users') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Page
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('mypage.posts.create') }}">Post</a></li>
                        <li><a class="dropdown-item" href="{{ route('mypage.liked') }}">Like</a></li>
                        <li><a class="dropdown-item" href="{{ route('mypage.profile') }}">Profile</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex mb-0" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link text-white">Logout</button>
            </form>
        </div>
    </div>
</nav>