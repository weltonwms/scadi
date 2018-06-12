@extends('layouts.app_interno')

@section('content_interno')
    
        <h3>Editar Índice</h3>
        {!! Form::model($index,['route'=>['indices.update',$index->id],'class'=>'','method'=>'PUT'])!!}
        @include('indices.form')


        {!! Form::close() !!}


    
@endsection
