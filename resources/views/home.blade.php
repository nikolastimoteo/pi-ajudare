@extends('layouts.app')

@section('content')
<!-- Content Header -->
<section class="content-header">
<h1>
    {{ __('Home') }}
    <small>Página inicial</small>
</h1>
</section>

<!-- Main content -->
<section class="content container-fluid">

<!--------------------------
    | Your Page Content Here |
    -------------------------->
    <h3>{{ __('Projeto Integrado - Especialização de Engenharia de Software - PUC Minas') }}</h3>
    <p class="lead">{{ __('Desenvolvido por: Níkolas Timóteo Paulino da Silva') }}</p>
</section>
<!-- /.content -->
@endsection
