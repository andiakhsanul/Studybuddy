@extends('Layout.appadmin')

@section('content')
    <main>

        <h1>Analytics</h1>
        <!-- Analyses -->
        <div class="analyse">
            <div class="sales">
                <div class="status">
                    <div class="info">
                        <h3></h3>users
                        <h1>{{ $userCount }}</h1>
                    </div>
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36" style="stroke-dasharray: {{ $userCount * 20 }} 200;">
                            </circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $userCount * 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="visits">
                <div class="status">
                    <div class="info">
                        <h3>Tugas</h3>
                        <h1>{{ $tugasCount }}</h1>
                    </div>
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36"
                                style="stroke-dasharray: {{ $tugasCount * 20 }} 200;"></circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $tugasCount * 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="searches">
                <div class="status">
                    <div class="info">
                        <h3>Tugas kategori</h3>
                        <h1>{{ $kategoriCount }}</h1>
                    </div>
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36"
                                style="stroke-dasharray: {{ $kategoriCount * 20 }} 200;"></circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $kategoriCount * 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Analyses -->

        <!-- New Users Section -->
        <div class="new-users">
            <h2>New Users</h2>
            <div class="user-list">
                @foreach($allUsers as $user)
                    <div class="user">
                        <h2>{{ $user->NAMA }}</h2>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

     <!-- Right Section -->
 <div class="right-section">
    <div class="nav">
        <button id="menu-btn">
            <span class="material-icons-sharp">
                menu
            </span>
        </button>
        <div class="dark-mode">
            <span class="material-icons-sharp active">
                light_mode
            </span>
            <span class="material-icons-sharp">
                dark_mode
            </span>
        </div>

        <div class="profile">
            <div class="info">
                <p>Hey, <b>{{ $namaUser }}</b></p>
                <small class="text-muted">Admin</small>
            </div>
            <div class="profile-photo">
                <img src="images/logoTitle/logoweb.png">
            </div>
        </div>

    </div>
    <!-- End of Nav -->

    <div class="user-profile">
        <div class="logo">
            <img src="images/logoTitle/logo.png">
            <h2>hai {{ $namaUser }} </h2>
            <p>ADMIN</p>
        </div>
    </div>

    <div class="reminders">
        <div class="header">
            <h2>Reminders</h2>
            <span class="material-icons-sharp">
                notifications_none
            </span>
        </div>

        <div class="notification">
            <div class="icon">
                <span class="material-icons-sharp">
                    volume_up
                </span>
            </div>
            <div class="content">
                <div class="info">
                    <h3>Workshop</h3>
                    <small class="text_muted">
                        08:00 AM - 12:00 PM
                    </small>
                </div>
                <span class="material-icons-sharp">
                    more_vert
                </span>
            </div>
        </div>

        <div class="notification deactive">
            <div class="icon">
                <span class="material-icons-sharp">
                    edit
                </span>
            </div>
            <div class="content">
                <div class="info">
                    <h3>Workshop</h3>
                    <small class="text_muted">
                        08:00 AM - 12:00 PM
                    </small>
                </div>
                <span class="material-icons-sharp">
                    more_vert
                </span>
            </div>
        </div>

        <div class="notification add-reminder">
            <div>
                <span class="material-icons-sharp">
                    add
                </span>
                <h3>Add Reminder</h3>
            </div>
        </div>

    </div>

</div>




    </div>

    <script src="orders.js"></script>
    <script src="js/admin.js"></script>
@endsection
