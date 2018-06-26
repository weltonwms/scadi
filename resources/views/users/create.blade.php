@extends('layouts.app_interno')
@section('content_interno')


<h3>Novo Usuário</h3>
<div class="col-md-8 ">
    <button class="btn btn-primary btn-block" 
            data-href="{{url('users-ldap')}}"
            data-toggle="modal" data-target="#myModal">Clique aqui para Pesquisar Remotamente
    </button>
</div>
{!! Form::open(['route'=>'users.store','class'=>'form col-md-8 '])!!}
@include('users.form')


{!! Form::close() !!}


@include('users.modal') 
@endsection

@push('scripts')
<script src="{{ asset('js/users.js') }}"></script>
@endpush
