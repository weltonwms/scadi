<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Group;

class GroupController extends Controller
{
     public function __construct() {
         $this->middleware('adm');
    }
    
   
    public function index()
    {
        $groups=  Group::all();
        return view("groups.index",compact('groups'));
    }

   
    public function create()
    {
        
        return view('groups.create');
    }

   
    public function store(GroupRequest $request)
    {
         $newGroup = Group::create($request->all());
        if ($newGroup->id):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        endif;
        return redirect()->route("groups.index");
    }

  
    
    public function edit(Group $group)
    {
        
       return view('groups.edit',compact('group'));
    }

    
    public function update(GroupRequest $request, Group $group)
    {
        
         $retorno=$group->update($request->all());
       
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionUpdate')]);
        endif;
        return redirect()->route('groups.index');
    }

   
    public function destroy(Group $group)
    {
        
        $retorno = $group->VerifyAndDelete();
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionDelete')]);
        endif;
        return redirect()->route('groups.index');
    }
}
