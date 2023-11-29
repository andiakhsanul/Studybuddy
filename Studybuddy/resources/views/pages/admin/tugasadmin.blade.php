@extends('Layout.appadmin')

@section('content')
    <main>
        <div class="analyse">
            <div class="searches">
                <div class="status">
                    <div class="info">
                        <h3>Catatan Tugas User</h3>
                    </div>
                </div>
                <div class="status" style="margin-top: 30%; margin-left:18%; margin-bottom:10%">
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
                <h1 style="text-align: center">{{ $tugasCount }}</h1>
            </div>
            <div class="searches">
                <div class="top-users">
                    <h3 style="color: #1B9C85;">Top Users</h3>
                    <ul>
                        @foreach ($topUsers as $user)
                            <li>
                                User {{ $user->nama_user }}: {{ $user->total_tugas }} tugas
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="top-phrases">
                    <h3 style="color: #FF0060;">Kalimat Sering Muncul</h3>
                    <ul>
                        @foreach ($topPhrases as $phrase)
                            <li>
                                Kalimat: {{ $phrase->DESK_TUGAS }} - {{ $phrase->total }} kali digunakan
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="chart-container">
                    <canvas id="topusersChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="topphrasesChart"></canvas>
                </div>
            </div>
        </div>
    </main>
@endsection
