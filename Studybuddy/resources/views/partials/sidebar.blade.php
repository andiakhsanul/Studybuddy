<div class="col-2 sidebar bg-primary flex-grow-0">
    <div class="d-flex align-items-center justify-content-center mt-3 mb-4">
        <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
            <img src="images/logoTitle/logoweb.png" alt="Logo" width="40" height="40" class="mr-2"
                style="margin-right: 10px;">
            <h4 class="text-white mb-0" style="font-size: 24px;">StudyBuddy</h4>
        </a>
    </div>
    <hr class="sidebar-divider bg-white border-1">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link btn-primary border text-white rounded {{ $title === 'Home' ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    <i class='bx bxs-home-alt-2' class="mr-2" width="25" height="25" style="margin-right: 10px;"></i>
                    <span style="font-weight: bold;">Home</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-success border text-white rounded {{ Request::is('search*') ? 'active' : '' }}" href="{{ route('search') }}">
                <div class="d-flex align-items-center">
                    <i class='bx bxs-search' class="mr-2" width="25" height="25" style="margin-right: 10px;"></i>
                    <span style="margin-right: 10px;">
                        <span style="font-weight: bold;">Search</span>
                    </span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-success border text-white rounded {{ Request::is('notifikasi*') ? 'active' : '' }}" href="{{ route('notifikasi') }}">
                <div class="d-flex align-items-center">
                    <i class='bx bxs-bell-ring' class="mr-2" width="25" height="25" style="margin-right: 10px;"></i>
                    <span style="margin-right: 10px;">
                        <span style="font-weight: bold;">Notifikasi</span>
                    </span>
                </div>
            </a>
        </li>
    </ul>
    <div style="margin-top: auto; margin-bottom: 400px;"></div>
    <ul class="nav flex-column">
        <li class="nav-item text-center">
            <a class="nav-link btn btn-danger rounded ml-2" href="{{ route('logout') }}"><span style="font-weight: bold;">Logout</span></a>
        </li>
    </ul>
</div>
