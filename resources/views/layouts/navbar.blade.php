<nav class="navbar navbar-expand-lg rounded-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-medium" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100 justify-content-evenly">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tags.index') ? 'active' : '' }}"
                        href="{{ route('tags.index') }}">Tags</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">Categories</a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"class="btn btn-danger logout_btn">
                    logout
                    <i class="fa-solid fa-right-from-bracket ms-1"></i>
                </button>
            </form>
        </div>
    </div>
</nav>
