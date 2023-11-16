<div class="container">
    <!-- Sidebar Section -->
    <aside>
        <div class="toggle">
            <div class="logo">
                <img src="images/logoTitle/logoweb.png">
                <h2>Study<span class="danger">Buddy</span></h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">
                    close
                </span>
            </div>
        </div>

        <div class="sidebar">
            <a href="{{ route('usersadmin') }}" class="{{ Request::is('manageusers*') ? 'active' : '' }}">
                <span class="material-icons-sharp">
                    person_outline
                </span>
                <h3>Users</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp">
                    receipt_long
                </span>
                <h3>Tugas</h3>
                <span class="message-count">27</span>
            </a>
            <a href="{{ route('adminPage') }}" class="{{ Request::is('admin*') ? 'active' : '' }}">
                <span class="material-icons-sharp">
                    insights
                </span>
                <h3>Analytics</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp">
                    mail_outline
                </span>
                <h3>Pesan</h3>
                <span class="message-count">27</span>
            </a>
            <a href="#">
                <span class="material-icons-sharp">
                    inventory
                </span>
                <h3>Kategori</h3>
                <span class="message-count">27</span>
            </a>
            <a href="{{ route('logout') }}">
                <span class="material-icons-sharp">
                    logout
                </span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>
    <!-- End of Sidebar Section -->
