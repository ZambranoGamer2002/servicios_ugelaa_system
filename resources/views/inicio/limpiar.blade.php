@extends('layouts.template')

@section('titlePage', 'Limpiar | Ugel Alto Amazonas')

@section('contentLogin')

<div class="row" style="text-align: center; color: #0f172a; margin-top: 100px;">
   <h1>Limpiado correctamente</h1>
   <p>Serás redirigido en 5 segundos...</p>
</div>

<script>
    setTimeout(function() {
        window.location.href = "{{ $previousUrl }}";
    }, 5000);
</script>

@endsection
