@extends('layouts.app_interno')

@section('content_interno')
    
        <h3>Editar Indicador</h3>
        {!! Form::model($indicator,['route'=>['indicators.update',$indicator->id],'class'=>'','method'=>'PUT'])!!}
        @include('indicators.form')


        {!! Form::close() !!}


    
@endsection
