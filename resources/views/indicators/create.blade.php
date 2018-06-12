@extends('layouts.app_interno')
@section('content_interno')

    
        <h3>Novo Indicador</h3>
        {!! Form::open(['route'=>'indicators.store','class'=>''])!!}
        @include('indicators.form')


        {!! Form::close() !!}


    
@endsection
