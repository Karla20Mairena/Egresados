<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/select.dataTables.min.css')}}">

<script type="text/javascript" src="{{asset('JS/jquery-3.5.1.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('JS/buttons.print.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('JS/dataTables.select.min.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

        <title>@yield('title')</title>
        <!-- Favicon -->
        <link href="{{ asset('imagen/logo.png') }}" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->
        <script src="{{ asset("JS/sweetalert2.all.min.js") }}"></script>
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <style>
            body{
                background-color: white !important;
            }
            th{

              
              color: white !important;
              }

            .main-content{
                background-color: white;
                padding-left: 10px;
                padding-right: 10px;
                min-height: 80%;
            }
        </style>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content ">        
            @include('layouts.navbars.navbar')
                @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')

       <script src="{{ asset('JS/jquery.dataTables.min.js') }}"></script>
       <script src="{{ asset('JS/dataTables.bootstrap.min.js') }}"></script>
       <script src="{{ asset('JS/dataTables.buttons.min.js') }}"></script>

       <script src="{{ asset('JS/dataTables.fixedHeader.min.js') }}"></script>
       <script src="{{ asset('JS/dataTables.keyTable.min.js') }}"></script>
       <script src="{{ asset('JS/dataTables.responsive.min.js') }}"></script>

       <script src="{{ asset('JS/dataTables.scroller.min.js') }}"></script>

       <script src="{{ asset('JS/buttons.html5.min.js') }}"></script>
       <script src="{{ asset('JS/buttons.print.min.js') }}"></script>

       <script src="{{ asset('JS/buttons.bootstrap.min.js') }}"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>