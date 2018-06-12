@extends('layouts.app_interno')
@section('content_interno')

    
        <h3>Novo Índice</h3>
        {!! Form::open(['route'=>'indices.store','class'=>''])!!}
        @include('indices.form')


        {!! Form::close() !!}


    
@endsection
