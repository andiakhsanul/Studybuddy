@extends('Layout.appadmin')

@section('content')
    <main>
        <h1>Analytics</h1>
        <!-- Analyses -->
        <div class="analyse">
            <div class="sales">
                <div class="status">
                    <div class="info">
                        <h3 style="text-align: center">Total Akun Users</h3>
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
                        <h3 style="text-align: center">Total Tugas</h3>
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
                        <h3 style="text-align: center">Kategori Tugas</h3>
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
                @foreach ($allUsers as $user)
                    <div class="user">
                        <h2>{{ $user->NAMA }}</h2>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
