@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/microsoft-auth.css') }}">
@endpush

@section('content')
<div class="ms-container">
    <div class="ms-card">

        <div class="ms-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg">
            <h2>Microsoft Account</h2>
        </div>

        <p class="ms-description">
            Hubungkan akun Microsoft untuk mengakses Word, OneDrive,
            dan SharePoint dari aplikasi ini.
        </p>

        @if(!$isConnected)
            <div class="ms-status ms-disconnected">● Not Connected</div>

            <a href="{{ route('auth.microsoft') }}" class="ms-btn">
                Connect Microsoft Account
            </a>
        @else
            <div class="ms-status ms-connected">
                ● Connected as <strong>{{ $msEmail }}</strong>
            </div>

            <div class="ms-actions">
                <a href="{{ route('auth.microsoft') }}" class="ms-btn secondary">
                    Reconnect
                </a>

                <form method="POST" action="{{ route('auth.microsoft.disconnect') }}">
                    @csrf
                    <button class="ms-btn danger">Disconnect</button>
                </form>
            </div>
        @endif

        <p class="ms-note">
            Kami tidak menyimpan password Microsoft Anda.
        </p>
    </div>
</div>
@endsection
