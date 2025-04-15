<div class="sidebar">
    <h4 class="text-center">Daily Needs</h4>
    <a href="/">Home</a>
    <a href="/dashboard/myprofile">My Profile</a>
    <a href="{{ route('purchasehistory.show', ['status' => 'Completed']) }}">Purchase History</a>
    <a href="/dashboard/topup">Top Up</a>
    <form action="/logout" method="post">
        @csrf
        <button type="submit" class="dropdown-item">Logout</button>
    </form>
</div>