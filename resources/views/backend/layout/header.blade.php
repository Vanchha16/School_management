<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/image.png') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/noti.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <!-- Page Loader -->

   <style>
    /* --- Loader Container --- */
    .tech-loader-container {
        position: fixed; /* Keeps it overlaying everything */
        top: 0;
        left: 0;
        z-index: 9999; 
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
        background-color: #ffffff; 
        /* Transition for the fade out */
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .tech-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* --- Spinner Core --- */
    .spinner-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Concentric Rings */
    .ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid transparent;
    }

    .ring-1 {
        width: 140px;
        height: 140px;
        border-top: 2px solid #111111;
        border-right: 2px solid #f0f0f0;
        animation: spin 2.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
    }

    .ring-2 {
        width: 100px;
        height: 100px;
        border-bottom: 2px solid #0070f3;
        border-left: 2px solid #f0f0f0;
        animation: spin 1.8s linear infinite reverse;
    }

    .ring-3 {
        width: 60px;
        height: 60px;
        border-top: 2px solid #cccccc;
        animation: spin 1.2s ease-in-out infinite;
    }

    /* Pulsing Data Core */
    .core {
        width: 16px;
        height: 16px;
        background-color: #0070f3;
        border-radius: 50%;
        box-shadow: 0 0 15px rgba(0, 112, 243, 0.5);
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* --- Animations --- */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(0.8); opacity: 0.7; }
        50% { transform: scale(1.3); opacity: 1; box-shadow: 0 0 25px rgba(0, 112, 243, 0.8); }
    }
</style>

<div class="tech-loader-container" id="page-loader">
    <div class="tech-loader">
        <div class="spinner-wrapper">
            <div class="ring ring-1"></div>
            <div class="ring ring-2"></div>
            <div class="ring ring-3"></div>
            <div class="core"></div>
        </div>
    </div>
</div>
