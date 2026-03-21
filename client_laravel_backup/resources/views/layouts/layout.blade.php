<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yeuthich-add-url" content="{{ route('yeuthich.add') }}">
    <meta name="yeuthich-remove-url" content="{{ route('yeuthich.remove') }}">
    <meta name="is-logged-in" content="{{ auth()->check() ? '1' : '0' }}">
    <title>@yield('title')</title>
      <link rel="icon" href="{{ asset('logo/HungThinh.png') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    {{-- boostrap --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
@yield('styles')

<body style="background-color: #dde7f5">

    <div class="container-fluid d-none d-md-block" style="background-color:#80bb35">
        <div class="container d-flex gap-3 justify-content-between align-items-center">
            <h5 class="text-white p-1"><i class="bi bi-telephone-fill text-white" style="font-size: 24px;"></i> Hotline:
                0325568596</h5>
            <h5 class="text-white p-1"><i class="bi bi-geo-alt-fill" style="font-size: 24px;"></i> Địa chỉ: Công viên
                phần mềm Quang Trung</h5>
        </div>
    </div>
    <header class="container-fluid d-none d-md-block bg-body-tertiary">
        @include('layouts.header')
    </header>
    <nav style="background-color:#80bb35"> @include('layouts.nav')</nav>
    <main class="container mt-4">
        <div class="mb-4">
            <a class="text-success" href="{{ route('client.home') }}">@yield('title')</a>
            /
            <a class="text-success" href="@yield('subtitle_url')">@yield('subtitle')</a>
            @if (View::hasSection('subsubtitle'))
                /
                <a class="text-success" href="@yield('subtitle_url')">
                    @yield('subsubtitle')
                </a>
                @if (View::hasSection('nameProduct'))
                    /
                    <a class="text-success" href="@yield('subtitle_url')">
                        @yield('nameProduct')
                    </a>
                @endif
            @endif
        </div>


        @yield('content')
    </main>
    <footer class="container-fluid p-0 mt-4">
        @include('layouts.footer')
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    @yield('scripts')


</body>

</html>
