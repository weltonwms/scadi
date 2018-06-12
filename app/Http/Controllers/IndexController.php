<?php

namespace App\Http\Controllers;

use App\Index;
use App\Http\Requests\IndexRequest;

class IndexController extends Controller
{
    
    public function __construct() {
         $this->middleware('adm')->except('index');
         $this->middleware('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indices=  Index::all();
       return view("indices.index",compact('indices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
        return view('indices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndexRequest $request)
    {
         $newIndex = Index::create($request->all());
        if ($newIndex->id):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        endif;
        return redirect()->route("indices.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function show(Index $index)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function edit(Index $index)
    {
        return view('indices.edit',compact('index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function update(IndexRequest $request, Index $index)
    {
         $retorno=$index->update($request->all());
       
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionUpdate')]);
        endif;
        return redirect()->route('indices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Index  $index
     * @return \Illuminate\Http\Response
     */
    public function destroy(Index $index)
    {
        $retorno = $index->VerifyAndDelete();
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionDelete')]);
        endif;
        return redirect()->route('indices.index');
    }
}
