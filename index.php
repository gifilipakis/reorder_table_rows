<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Avaliação G1</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Roboto:700,400,300' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Fontes dos Ícones -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <style>
    #questoes tr:hover {
        background-color: lightgray;
    }
    #questoes td i {
        width: 50%;
    }
    #questoes td {
        padding:10px;
    }
    </style>

</head>

<body>
<div style="margin: 100px 0;">
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Ordenação
                        </th>
                        <th>
                            Questão
                        </th>
                        <th>
                            Pontucação
                        </th>
                        <th>
                            Grau
                        </th>
                    </tr>
                </thead>
                <!-- Elemento em que serão adicionadas as linhas da tabela -->
                <tbody id="questoes">
                </tbody>
            </table>
            <div class="text-right">
                <input class="btn btn-success" value="Salvar" type="button">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
    // Função para adicionar as linhas da tabela ao carregar
    $(document).ready(function () {        
        $.getJSON('questoes.json',function(data){
            $(data).each(function(key,val){
                content = [val.oid, val.enunciado, val.pontuacao, val.grau, val.id_atividade]
                // Adiciona o elemento ao localStorage
                localStorage.setItem(key,JSON.stringify(content))
                // Insere linhas no elemento com id = #questoes
                $('#questoes').append('<tr><td><i class="btn fa fa-arrow-up fa-fw" aria-hidden="true" id="up' + key + '" onclick="up(this)" ></i><i class="btn fa fa-arrow-down fa-fw" aria-hidden="true" id="down' + key + '" onclick="down(this)" ></i></td><td>'+ val.enunciado + '</td><td>'+ val.pontuacao + '</td><td>'+ val.grau + '</td></tr>');
            });
        });
    });
    // Função para mover linha uma posição acima
    function up(el) {
        key = parseInt(String(el.id).slice(2))   
        $.getJSON('questoes.json',function(data){
            if(key > 0){
                aux = localStorage.getItem(key)
                localStorage.setItem(key, localStorage.getItem(key-1))
                localStorage.setItem(key-1, aux)
                // Atualiza tabela
                update();
            };
        });
    };
    // Função para mover linha uma posição abaixo
    function down(el) {
        key = parseInt(String(el.id).slice(4))
        $.getJSON('questoes.json',function(data){
            if(key < data.length-1){
                aux = localStorage.getItem(key)
                localStorage.setItem(key, localStorage.getItem(key+1))
                localStorage.setItem(key+1, aux)
                // Atualiza tabela
                update();
            };
        });        
    };
    // Função para atualizar a ordem das linhas
    function update() {
        // Deleta o DOM
        var questoes = document.getElementById("questoes");
        var child = questoes.lastElementChild;
        while (child) { 
            questoes.removeChild(child); 
            child = questoes.lastElementChild; 
        }
        // Insere novas linhas
        var i = 0
        while (localStorage.getItem(i) !== null){
            // questao = [oid, enunciado, pontuacao, grau]
            questao = JSON.parse(localStorage.getItem(i))
            $('#questoes').append('<tr><td><i class="btn fa fa-arrow-up fa-fw" aria-hidden="true" id="up' + i + '" onclick="up(this)" ></i><i class="btn fa fa-arrow-down fa-fw" aria-hidden="true" id="down' + i + '" onclick="down(this)" ></i></td><td>'+ questao[1] + '</td><td>'+ questao[2] + '</td><td>'+ questao[3] + '</td></tr>');
            i++
        }
    };
</script>
</body>
</html>
