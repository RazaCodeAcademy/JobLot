<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__('JobLot')}}</title>
    <link rel="shortcut icon" href="{{ asset('/public/') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('/public/asset/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/public/asset/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('/public/asset/css/themify-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/et-line.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/bootstrap-select.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/plyr.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/flag.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/slick.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/public/asset/css/jquery.nstSlider.min.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{asset('/public/css/main.css')}}">

    <link href="{{asset('/public/public/toast/toastr1.css')}}" rel="stylesheet">
    <link href="{{asset('/public/public/toast/toastr2.css')}}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600%7CRoboto:300i,400,500" rel="stylesheet">

    <link rel="icon" href="{{asset('/public/asset/images/logo.png')}}">
    <link rel="apple-touch-icon" href="{{asset('/public/asset/images/logo.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/public/asset/images/logo.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/public/asset/images/logo.png')}}">

    <style>
        .main3 {
            padding:5px;


            color:#fff;
        }
        .main3 div {
            margin:20px;
            padding:20px;
            background-color: #273238;
            text-align: center;
            border-radius: 5px;
            font-weight: 700;
            font-size: 22px;
        }
        .main3 div i{
            font-size: 25px;
        }
        .main3   a{
            display: block;
        }
        .main3.activated div{
            background-color: #f04d42;
            color:#fff;

        }
        .main3:hover div{
            background-color: #f04d42;
            color:#fff;
        }
        .headerSeparator{
            width:100%; height:60px;
        }

    </style>

    @yield('css')
</head>
