@extends('layouts.app_interno')
@section('content_interno')

    
        <h3>Novo Grupo</h3>
        {!! Form::open(['route'=>'groups.store','class'=>''])!!}
        @include('groups.form')


        {!! Form::close() !!}


    
@endsection
