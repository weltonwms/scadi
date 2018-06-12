@extends('layouts.app_interno')
@section('content_interno')

<div class="container">
    <hr>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Painel Inicial</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Você está Logado!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
