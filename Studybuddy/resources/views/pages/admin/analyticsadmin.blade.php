@extends('Layout.appadmin')

@section('content')
    <main>
        <h1>Analytics</h1>
        <!-- Analyses -->
        <div class="analyse">
            <div class="sales">
                <div class="status">
                    <div class="info">
                        <h3 style="text-align: center">Total Akun User</h3>
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
                        <h3 style="text-align: center">Total Tugas User</h3>
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
                        <h3 style="text-align: center">Kategori Catatan</h3>
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
        <div class="analyse">
            <div class="sales">
                <div class="status">
                    <div class="info">
                        <h3 style="text-align: center">Total Akun Users</h3>
                    </div>
                </div>
                <div class="status" style="margin-top: 30%; margin-left:18%; margin-bottom:10%">
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36"
                                style="stroke-dasharray: {{ $userCount * 20 }} 200;">
                            </circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $userCount * 2 }}</p>
                        </div>
                    </div>
                </div>
                <h1 style="text-align: center">{{ $userCount }}</h1>
            </div>
            <div class="visits">
                <div class="status">
                    <div class="info">
                        <h3 style="text-align: center">Total Catatan User</h3>
                    </div>
                </div>
                <div class="status" style="margin-top: 30%; margin-left:18%; margin-bottom:10%">
                    <div class="progresss">
                        <svg>
                            <circle cx="38" cy="38" r="36"
                                style="stroke-dasharray: {{ $catatanCount * 20 }} 200;"></circle>
                        </svg>
                        <div class="percentage">
                            <p>+{{ $catatanCount * 2 }}</p>
                        </div>
                    </div>
                </div>
                <h1 style="text-align: center">{{ $catatanCount }}</h1>
            </div>
            <div class="searches">
                <div class="kategori-usage">
                    <h3>Kategori Penggunaan</h3>
                    <ul>
                        @foreach ($kategoriUsage as $usage)
                            <li>
                                Kategori {{ $usage->nama_kategori }}: {{ $usage->total }} kali dipakai
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="chart-container">
                    <canvas id="kategoriChart"></canvas>
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
