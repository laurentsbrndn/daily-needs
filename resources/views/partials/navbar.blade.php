<nav class="navbar">
    <a class="brand-logo" href="/"><img src="assets/image/Title Icon.jpeg" alt=""></a>
    <ul class="nav-left">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Category
            </a>
            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                <li><a class="dropdown-item" href="/">All</a></li>
                @foreach ($categories as $category)
                    <li><a class="dropdown-item" href="{{ url('/?category=' . $category->category_slug) }}">{{ $category->category_name }}</a></li>
                @endforeach
            </ul>
        </li>        
        <li>
            <form action="/" method="get">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
                </div>
            </form>
        </li>
    </ul>

    <ul class="nav-right">
        @auth('customer')
            <li>
                <a href="/cart"><i class="bi bi-cart2"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="/" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(auth('customer')->user()->customer_photo)
                        <img src="{{ asset('storage/customer_photos/' . auth('customer')->user()->customer_photo) }}" 
                             alt="Profile" class="rounded-circle me-2" width="30" height="30">
                    @endif
                    Welcome back, {{ auth('customer')->user()->customer_first_name }} 
                </a>
                
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/dashboard/myprofile"><i class="bi bi-person-circle"></i> My Dashboard</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> 
                                     Logout
                            </button>
                        </form>                        
                    </li>
                </ul>
            </li>
        @else
            <ul class="nav-links">
                <li>
                    <a href="/login"><i class="bi bi-cart2"></i></a>
                </li>
                <li>
                    <a href="/login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                </li>
            </ul>
        @endauth
    </ul>
</nav>