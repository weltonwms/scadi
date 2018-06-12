@extends('layouts.app_interno')
@section('content_interno')

    
        <h3>{{$indicator->sigla}}</h3>
        {!! Form::open(['name'=>'form-calculations','route'=>['calculations.store',$indicator->id],'class'=>''])!!}
        @include('calculations.form')
        

        {!! Form::close() !!}
        {!!Form::hidden('lastCalculation',$indicator->getLastCalculation())!!}

    
@endsection
