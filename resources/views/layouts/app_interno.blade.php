@extends('layouts.app')

@section('header')
    @include('layouts.header') 
@endsection

@section('navbar')
    @include('layouts.nav') 
@endsection


@section('content')
<div class="container" style=''>
    <hr>
    
    @if(Request::session()->has('mensagem'))
            <div class="alert alert-{{session('mensagem.type')}} alert-dismissable ">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{session('mensagem.conteudo')}}
            </div>

    @endif
         
       @yield('content_interno')
</div>
@endsection