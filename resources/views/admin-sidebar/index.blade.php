<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Needs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/admin-sidebar.css">
    

<body>
    <div class="sidebar">
       
        <div class="logo-container">
            <img src="{{ asset('assets/image/Title Icon.jpeg') }}" alt="Logo" class="logo">

        </div>
        
        <div class="sidebar-container">
            <div class = "menu-item">
                <i class="bi bi-person" style="color: #D1D88D;"></i>
                <a href="/admin/myprofile">Admin Profile</a>
            </div>

            <div class = "menu-item">
                <i class="bi bi-archive" style="color: #D1D88D;"></i>
                <a href="/admin/productlist">Product List</a>
            </div>

            <div class = "menu-item">
                <i class="bi bi-wallet2" style="color: #D1D88D;"></i>
                <a href="/admin/transactions">Transactions</a>
            </div>

            <form action="/admin/logout" method="post" class="menu-item-logout">
                @csrf
                <i class="bi bi-box-arrow-left" style="color: #D1D88D;"></i>
                <button type="submit" class="dropdown-item">Log Out</button>
            </form>

        </div>
            
    </div>

    @yield('container')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/admin-productstock.js"></script>
</body>
</html>