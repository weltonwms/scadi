@extends('layouts.app_interno')

@section('content_interno')
    
        <h3>Editar Grupo</h3>
        {!! Form::model($group,['route'=>['groups.update',$group->id],'class'=>'','method'=>'PUT'])!!}
        @include('groups.form')


        {!! Form::close() !!}


    
@endsection
