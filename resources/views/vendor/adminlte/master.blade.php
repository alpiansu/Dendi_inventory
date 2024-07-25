<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>
    
    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')
    
    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

        @if(config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-basic').select2();
            // Mendeteksi perubahan pada input harga_beli
            $('#qty_beli').on('input', function () {
                // Mengambil nilai dari input qty dan harga_beli
                var qty = parseFloat($(this).val()) || 0;
                var hargaBeli = parseFloat($('input[name="harga_beli"]').val()) || 0;

                // Menghitung nilai gross_beli dan mengisinya ke dalam input gross_beli
                var grossBeli = qty * hargaBeli;
                $('input[name="gross_beli"]').val(grossBeli.toFixed(0));
            });

            $('#harga_beli').on('input', function () {
                // Mengambil nilai dari input qty dan harga_beli
                var qty = parseFloat($('input[name="qty"]').val()) || 0;
                var hargaBeli = parseFloat($(this).val()) || 0;

                // Menghitung nilai gross_beli dan mengisinya ke dalam input gross_beli
                var grossBeli = qty * hargaBeli;
                $('input[name="gross_beli"]').val(grossBeli.toFixed(0));
            });

            $('.tbl-datatable').DataTable({
                "searching": true,
                "paging": true,
                scrollY: '60vh',
                scrollCollapse: true,
                responsive: true,
                drawCallback: function(settings) {
                    // Memperbaiki lebar kolom setiap kali tabel digambar ulang
                    this.api().columns.adjust();
                }
            });

            $('#tbl-master-barang').DataTable({
                "searching": true,
                "paging": true,
                "scrollX": true,
                scrollY: '50vh',
                scrollCollapse: true,
                responsive: true,
            });

            $('#tbl-history-npb').DataTable({
                "searching": true,
                "paging": true,
                "scrollX": true,
                scrollY: '50vh',
                "aaSorting": [7,'desc'],
                scrollCollapse: true,
                responsive: true,
            });

            $('#history-so-table').DataTable({
                "searching": true,
                "paging": true,
                "aaSorting": [0,'desc'],
                scrollY: '50vh',
                scrollCollapse: true,
                responsive: true,
            });

            $('#tbl-list-mobileuser').DataTable({
                "searching": true,
                "paging": true,
                "aaSorting": [2,'desc'],
                scrollY: '50vh',
                scrollCollapse: true,
                responsive: true,
            });

            $('#tbl-so-initial').DataTable({
                "searching": true,
                "paging": true,
                "aaSorting": [4,'desc'],
                scrollY: '50vh',
                scrollCollapse: true,
                responsive: true,
            });

            $(document).on('click', '.btnback', function(e){
                e.preventDefault();
                window.history.back();
            });

            $(document).on('click', '.btn-hapus-view', function(e){
                var kode = $(this).data('kode');
                var nama = $(this).data('nama');
                return confirm("Apakah Anda yakin ingin menghapus "+kode+" - " + nama + "?");
            });

            // Tambahkan event listener untuk mematikan tombol submit jika form tidak valid [FORM USER MOBILE CREATE]
            $('#btnSubmit').click(function(event) {
                var username = $('#username').val();
                var namaUser = $('#nama_user').val();
                var password = $('#password').val();
                var confirmPassword = $('#password_confirmation').val();

                if (username === '' || namaUser === '' || password === '' || confirmPassword === '') {
                    // Form tidak valid
                    alert('Harap isi terlebih dahulu semua field.');
                    event.preventDefault();
                } else if (password !== confirmPassword) {
                    // Password dan password konfirmasi tidak sama
                    alert('Password dengan password konfirmasi tidak sama!');
                    event.preventDefault();
                }
            });
        });
    </script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
