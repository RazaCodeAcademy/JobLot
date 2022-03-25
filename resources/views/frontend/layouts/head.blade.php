<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Font Awesome Css -->
    <link rel="stylesheet" href="{{ asset('/public/frontend/css/font-awesome/css/all.css') }}" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/public/frontend/css/bootstrap.min.css') }}" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/public/frontend/css/main.css') }}" />
    <link href="{{asset('public/toast/toastr1.css')}}" rel="stylesheet">
    <link href="{{asset('public/toast/toastr2.css')}}" rel="styleshee">
    
    <title>{{__('JobLot')}}</title>
    <link rel="shortcut icon" href="{{ asset('/public/frontend/img/logo-color.png') }}">

    <style>
        .icon-color{
            color: #45adec;
        }

        .button-success{
            outline: 0;
            border: 0;
            font-size: 1.4rem;
            color: #fff;
            font-weight: bold;
            padding: 1rem 3rem;
            background-color: #28a745;
            transition: all 0.3s;
            border-radius: 0.5rem;
        }

        .header .header-search-dropdown .recent-footer i {
            margin-right: 0rem !important;
        }
    </style>
</head>