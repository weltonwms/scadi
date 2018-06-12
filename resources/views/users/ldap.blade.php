

<h4>Pesquisa de Usuário(s) no LDAP</h4>
<hr>
<?php $militares=array(); //ACTION do formulário controlado pelo javascript users ?>

<form class="form-inline" id="form-pesquisa-ldap">
    <div class="form-group">
        
        <input type="text" class="form-control" id="filter_cpf" name="filter_cpf" placeholder="CPF">
    </div>
    <div class="form-group">
        
        <input type="text" class="form-control" id="filter_guerra"  name="filter_guerra"placeholder="Nome Guerra">
    </div>
    <div class="form-group">
        
        <input type="text" class="form-control" id="filter_name"  name="filter_name"placeholder="Nome Completo">
    </div>
    <div class="form-group">
        
        <input type="text" class="form-control" id="filter_om"  name="filter_om"placeholder="OM">
    </div>
    <div class="form-group">
        
        <input type="text" class="form-control" id="filter_posto"  name="filter_posto"placeholder="Posto">
    </div>
    <input type="hidden" name="search" value="1">
    <button type="submit" class="btn btn-default pesquisar-ldap"  data-href="{{url('militares-json')}}" >Procurar</button>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Posto/Grad</th>
            <th>Nome</th>
            <th>Nome de Guerra</th>
            <th>Om</th>
            <th>CPF/Username</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody class="ldap">

        @foreach($militares as $militar)
        <tr>
            <td>{{$militar->posto}}</td>
            <td>{{$militar->name}}</td>
            <td>{{$militar->guerra}}</td>
            <td>{{$militar->om}}</td>
            <td>{{$militar->username}}</td>


        </tr>

        @endforeach

    </tbody>

</table>




