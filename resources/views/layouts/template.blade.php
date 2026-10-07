<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Trámite Documentario - UGELAA</title>
    
    <!-- Fuentes y Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/images/LOGO_UGELAA.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Estilos -->
    @vite(['resources/css/estilos.css'])
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="ugelaa-login">
    @yield('contentLogin')
    
    @yield('scripts')
</body>
</html>
