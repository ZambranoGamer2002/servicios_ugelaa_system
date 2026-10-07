@extends('layouts.dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-9">
        <div class="text-center">
            <h1 class="text-dark fw-bold mb-3">
                ¡Bienvenido, {{ Auth::user()->nombres }}!
            </h1>
            <p class="text-muted fw-semibold fs-5">
                Has iniciado sesión correctamente. Aquí se mostrará tu información y herramientas principales.
            </p>
            <img src="{{ asset('assets/media/illustrations/sketchy-1/17.png') }}" alt="" class="mw-100 mh-300px mb-9" />
        </div>
    </div>
</div>
@endsection
