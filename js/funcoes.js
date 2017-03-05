$(document).ready(function () {
    carregar();

    $("#cadastrar").click(function () {
        $.ajax({
            type: "POST",
            url: "movie/cadastro.php",
            dataType: "json",
            data: {tipo: 'cadastro', id: $('#id').val(), nome: $('#nome').val(), sobrenome: $('#sobrenome').val(), endereco: $('#endereco').val()},
            success: function (response) {
                if (response.erro == "erro") {
                    alert(response.mensagem);
                } else {
                    carregar();
                    limparIn();
                    alert(response.mensagem);
                }
            },
            error: function () {
                alert("problema com retorno")
            }
        });
    });
    $("#delete").click(function () {
        if (confirm("Deseja apagar o usuario " + $('#nome').val())) {
            $.ajax({
                type: "POST",
                url: "movie/cadastro.php",
                dataType: "json",
                data: {tipo: 'delete', id: $('#id').val()},
                success: function (response) {
                    if (response.erro == "erro") {
                        alert(response.mensagem);
                    } else {
                        carregar();
                        limparIn();
                        alert(response.mensagem);
                    }
                },
                error: function () {

                }
            });
        } else {
            return false;
        }

    });

});

function limparIn() {
    $('#nome').focus();
    var elements = document.getElementsByTagName("input");
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].type == "text") {
            elements[i].value = "";
        }
    }
}


function carregar() {
    $('#nome').focus();
    var out = "";
    $('.linha').remove();
    $.ajax({
        type: "POST",
        url: "movie/cadastro.php",
        dataType: "json",
        data: {tipo: 'listar'},
        success: function (response) {
            var cor = '#BEBEBE';
            for (var i = 0; i < response.length; i++) {
                if (i % 2)
                {
                    cor = '#BEBEBE';
                }
                else
                {
                    cor = '#EEE9E9';
                }
                out = "<tr style='background-color:" + cor + "'; class='linha'>\n\
                            <td>" + response[i].nome + "</td>\n\
                            <td>" + response[i].sobrenome + "</td>\n\
                            <td>" + response[i].endereco + "</td>\n\
                            <td id='buscaId'><a href='javascript://' onclick='javascript:buscaId(" + response[i].id + ");'>editar</a></td>\n\
                        </tr>";
                $("#cadastro").append(out);
            }
        },
        error: function () {
            alert("sem retorno");
        }
    });
}

function buscaId(id) {
    $.ajax({
        type: "POST",
        url: "movie/cadastro.php",
        dataType: "json",
        data: {tipo: 'buscarId', id: id},
        success: function (response) {
            $('#id').val(response[0].id);
            $('#nome').val(response[0].nome);
            $('#sobrenome').val(response[0].sobrenome);
            $('#endereco').val(response[0].endereco);
        },
        error: function () {

        }
    });
}
