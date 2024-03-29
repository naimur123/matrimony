<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if( isset($system))
        <title>Dashboard | {{ $system->application_name }}</title>
        <!-- Favicon icon -->
        <link rel="icon" href="{{asset($system->favicon)}}" type="image/x-icon">
        <meta name="author" content="{{ $system->application_name }}">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- jquery lib-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Yazra Datatable-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Required Fremwork -->

    <link rel="stylesheet" type="text/css" href="{{asset('backEnd/components/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"  crossorigin="anonymous">

    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('backEnd/assets/icon/feather/css/feather.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('backEnd/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backEnd/assets/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backEnd/style.css')}}?v=01" media="all">

</head>
