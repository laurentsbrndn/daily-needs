{{-- <nav class="navbar">
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
                    @else
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                    @endif
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/dashboard/myprofile"><i class="bi bi-person-circle"></i> Account</a></li>
                    <li>{{ $customers->customer_balance }}</li>
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
                    <a href="/login"><button>Login</button></a>
                </li>
            </ul>
        @endauth
    </ul>
</nav> --}}

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<nav class="flex items-center justify-between px-6 py-4 bg-white text-green-800 shadow-md">
    <div class="flex items-center space-x-8">
        <a href="/">
            <img src="{{ asset('assets/image/Title-Icon.jpeg') }}" alt="Logo" class="h-10 w-auto">
        </a>
        
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="text-green-600 hover:text-green-900 font-medium flex items-center space-x-1 focus:outline-none">
                <span>Category</span>
                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul x-show="open" @click.outside="open = false" class="absolute mt-2 w-48 bg-white text-green-800 border-green-200 rounded-md shadow-lg z-10">
                <li><a href="/" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">All</a></li>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ url('/?category=' . $category->category_slug) }}" class="block px-4 py-2 text-green-700 hover:bg-gray-100 category-list">
                            {{ $category->category_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Search Form -->
        <form action="/" method="get" class="flex">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                class="border border-green-700 rounded-md px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Search">
        </form>
    </div>

    <!-- Right Side: Cart + Auth -->
    <div class="flex items-center space-x-4">
        @auth('customer')
            <a href="/cart" class="text-gray-700 hover:text-green-600 text-xl">
                <i class="bi bi-cart2"></i>
            </a>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center focus:outline-none">
                    @if(auth('customer')->user()->customer_photo)
                        <img src="{{ asset('storage/customer_photos/' . auth('customer')->user()->customer_photo) }}" 
                            alt="Profile" class="w-8 h-8 rounded-full object-cover mr-2">
                    @else
                        <i class="bi bi-person-circle text-2xl text-gray-700 mr-2"></i>
                    @endif
                </button>

                <ul x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                    <li>
                        <a href="/dashboard/myprofile" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-person-circle mr-2"></i> My Account
                        </a>
                    </li>
                    <li><hr class="my-1 border-gray-200"></li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center">
                                <i class="bi bi-box-arrow-right mr-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <div>
                <a href="/login" class="text-gray-700 hover:text-green-600 rounded-lg text-xl">
                    <i class="bi bi-cart2"></i>
                </a>
                <a href="/login">
                    <button class="px-4 py-2 bg-green-600 text-white hover:bg-green-700 transition login-button">Login</button>
                </a>
            </div>
        @endauth
    </div>
</nav>