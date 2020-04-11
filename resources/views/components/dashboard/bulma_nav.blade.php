<main id="navContainer" class="row nav-row cs-row-mr-0">
    <aside class="menu navbar-dark bg-dark pl-2">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul id="collapsibleNavbar" class="menu-list collapse">
            <li><a class="text-decoration-none" href="/dashboard">Dashboard</a></li>
            <li><a class="text-decoration-none" href="/dashboard/register-delivery-new">Deliver to New person</a></li>
            <li><a class="text-decoration-none" href="/dashboard/register-delivery-existing">Deliver to existing person</a></li>
            <li><a class="text-decoration-none" href="/view-deliveries">View all Deliveries</a></li>
            <li>
                <a class="text-decoration-none" href="/dashboard/view-individual-deliveries">View individuals deliveries</a>
            </li>
            <li><a class="text-decoration-none" href="/dashboard/my-receivers">My Receivers</a></li>
            <li><a class="text-decoration-none" href="/dashboard/settings">Settings</a></li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input class="text-decoration-none cs-nav-link" type="submit" value="Logout">
                </form>
            </li>
        </ul>
    </aside>
</main>
