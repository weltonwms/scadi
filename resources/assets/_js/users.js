$('#myModal').on('show.bs.modal', function (event) {
   
    var button = $(event.relatedTarget); // Button that triggered the modal

    var modal = $(this);
    modal.find('.modal-title').text("Pesquisa por Usuário(s) no Ldap");
    //ajax load
    modal.find('.modal-body').load(button.data('href'), function () {
        gatilhoModal();
    });

});

function gatilhoModal()
{
    $("input[name=filter_cpf]").mask('00000000000');
    $(".pesquisar-ldap").click(function (e) {
        e.preventDefault();
        var url = this.dataset.href;
        var dataForm = $('#form-pesquisa-ldap').serializeArray();


        $.ajax({
            type: 'get', //Definimos o método HTTP usado
            dataType: 'json', //Definimos o tipo de retorno
            data: dataForm,
            url: url, //Definindo o arquivo onde serão buscados os dados
            success: function (dados) {
                var string = "";
                $.each(dados, function (i) {
                    string += "<tr>";
                    string += "<td>" + dados[i].posto + "</td>";
                    string += "<td>" + dados[i].name + "</td>";
                    string += "<td>" + dados[i].guerra + "</td>";
                    string += "<td>" + dados[i].om + "</td>";
                    string += "<td>" + dados[i].username + "</td>";
                    var objetoBase64 = "'" + btoa(JSON.stringify(dados[i])) + "'";
                    string += '<td><a href="#" class="btn btn-default" onclick="setForm(' + objetoBase64 + ')">Selecionar </a></td>';
                    string += "</tr>";
                });
                $("tbody.ldap").html(string);
            }, //fim success
            beforeSend: function () {
                $("tbody.ldap").html("");
                var string = "<div class='preload-img row>";
                string += "<div class='preload-img col-md-5 col-md-offset-3'>";
                string += '<img src=" ' + asset + 'img/loading-2.gif"</img>';
                string += "</div></div>";
                $('.modal-body').append(string);
            },
            complete: function () {
                $('.preload-img').remove();
                 $(".pesquisar-ldap").blur();
            },
            error:function(){
                 $("tbody.ldap").html("<p class='text-danger'>Ocorreu um Erro no Servidor</p>");
            }
        });
    });
}

function setForm(dados)
{
    var decode = atob(dados); //descodificando base64
    var objeto = JSON.parse(decode); //transformando string para Json(novamente)
    //alert(objeto.username);
    $("input[name=username]").val(objeto.username);
    $("input[name=name]").val(objeto.name);
    $("input[name=om]").val(objeto.om);
    $("input[name=guerra]").val(objeto.guerra);
    $("input[name=posto]").val(objeto.posto);
    $('#myModal').modal('hide')
}