<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

// Buscar exercícios no banco de dados
$sql = "SELECT id, nome FROM exercicio";
$resultado = $conexao->query($sql);

$exercicios = array();
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $exercicios[] = $row;
    }
}

if (isset($_POST['salvar'])) {
    // Obter os dados do formulário
    $nomeFicha = $_POST['nome'];
    $alunoId = $_POST['aluno_id'];
    $personalID = $_POST['personal_id'];
    $numTreinos = $_POST['numTreino'];
    $descricao = $_POST['descricao'];

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    if ($numTreinos != 0) {
        
   
    
    try {
        // Inserir a ficha de treino na tabela
        $sqlInserirFicha = "INSERT INTO ficha_treino (nome, aluno_id, personal_id, num_treinos, descricao) VALUES (?, ?, ?, ?, ?)";
        $stmtFicha = $conexao->prepare($sqlInserirFicha);
        $stmtFicha->bind_param("siiis", $nomeFicha, $alunoId, $personalID, $numTreinos, $descricao);
        $stmtFicha->execute();

        // Obter o ID da ficha de treino inserida
        $fichaId = $stmtFicha->insert_id;

        // Iterar sobre os treinos
        for ($i = 1; $i <= $numTreinos; $i++) {
            // Iterar sobre os exercícios do treino
            if (isset($_POST["exercicio"][$i]) && is_array($_POST["exercicio"][$i])) {
                foreach ($_POST["exercicio"][$i] as $j => $exercicioId) {
                    $treinoId = $i;
                    $series = isset($_POST["series"][$i][$j]) ? $_POST["series"][$i][$j] : "";
                    $repeticoes = isset($_POST["repeticoes"][$i][$j]) ? $_POST["repeticoes"][$i][$j] : "";
                    $cargaVelocidade = isset($_POST["carga_velocidade"][$i][$j]) ? $_POST["carga_velocidade"][$i][$j] : "";
                    $tempoDescanso = isset($_POST["tempo_descanso"][$i][$j]) ? $_POST["tempo_descanso"][$i][$j] : "";

                    // Inserir o exercício na tabela exercicio_treino
                    $sqlInserirExercicio = "INSERT INTO exercicio_treino (ficha_treino_id, treino_id, exercicio_id, series, repeticoes, carga_velocidade, tempo_descanso) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmtExercicio = $conexao->prepare($sqlInserirExercicio);
                    $stmtExercicio->bind_param("iiissss", $fichaId, $treinoId, $exercicioId, $series, $repeticoes, $cargaVelocidade, $tempoDescanso);
                    $stmtExercicio->execute();
                }
            }
        }
        // Commit se todas as operações forem bem-sucedidas
        mysqli_commit($conexao);

        // Mostrar uma mensagem de sucesso ao usuário
        $mensagem = "Plano de Treino criado com sucesso!";
    } catch (Exception $e) {
        // Reverter se houver algum erro
        mysqli_rollback($conexao);
        $mensagemErro = "Erro ao criar o Plano de Treino: " . $e->getMessage();
    }
    } else{
        $mensagemErro = "A Quantidade de Treinos deve ser maior que 1";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Treino</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/dc274ad54e.js" crossorigin="anonymous"></script>


    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">






    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <?php if ($_SESSION['perfil'] == 'aluno') {
        require_once('menuAluno.php');
    } elseif ($_SESSION['perfil'] == 'personal') {
        require_once('menuPersonal.php');
    } elseif ($_SESSION['perfil'] == 'admin') {
        require_once('menu.php');
    } ?>

    <main id="main" class="main">
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <i class="fa-solid fa-square-check"></i>
                <?= $mensagem ?>
            </div>
        <?php } ?>

        <?php if (isset($mensagemErro)) { ?>
            <div class="alert alert-warning" role="alert">
                <i class="fa-solid fa-square-check"></i>
                <?= $mensagemErro ?>
            </div>
        <?php } ?>

        <div class="pagetitle">
            <h1>Plano de Treino</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Aluno</h5>

                            <!-- General Form Elements -->
                            <form action="planoTreinoAluno.php" method="post">
                                <div class="row mb-3">
                                    <label for="nome" class="col-sm-2 col-form-label">Nome da Ficha de Treino:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="nome" name="nome" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nome" class="col-sm-2 col-form-label">Aluno:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <select name="aluno_id" id="" class="form-select" required>
                                        <option value=""></option>
                                        <?php
                                        $sql = "SELECT id, nome FROM aluno ORDER BY nome";
                                        $resultado = mysqli_query($conexao, $sql);

                                        while ($linhaTU = mysqli_fetch_array(($resultado))) {
                                            $id = $linhaTU['id'];
                                            $nome = $linhaTU['nome'];

                                            $selected = ($id == $linha['aluno_id']) ? 'selected' : '';

                                            echo "<option value='{$id}' {$selected}>{$nome}</option>";
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="row mb-3">
                                    <label for="nome" class="col-sm-2 col-form-label">Personal:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <select name="personal_id" id="" class="form-select" required>
                                        <option value=""></option>
                                        <?php
                                        $sql = "SELECT id, nome FROM personal ORDER BY nome";
                                        $resultado = mysqli_query($conexao, $sql);

                                        while ($linhaTU = mysqli_fetch_array(($resultado))) {
                                            $id = $linhaTU['id'];
                                            $nome = $linhaTU['nome'];

                                            $selected = ($id == $linha['personal_id']) ? 'selected' : '';

                                            echo "<option value='{$id}' {$selected}>{$nome}</option>";
                                        }
                                        ?>
                                    </select>

                                </div>

                                <br>
                                <div class="row mb-3">
                                    <label for="num_Treino" class="col-sm-2 col-form-label">Quantidade de
                                        Treinos:<span class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="number" id="num_Treino" name="numTreino" class="form-control"
                                            required max="10" min="0">
                                    </div>
                                </div>
                                <div class="row" id="listas_de_treino" style="overflow-x: auto">
                                    <!-- As listas de treino serão geradas aqui pelo JavaScript -->
                                </div>
                                <br>
                                <br>
                                <div class="row mb-3">
                                    <label for="desc" class="col-sm-2 col-form-label">Descrição:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="descricao" name="descricao"
                                            style="height: 100px"></textarea>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>

                            </form><!-- End General Form Elements -->

                        </div>
                    </div>
                </div>

            </div>
            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                    class="bi bi-arrow-up-short"></i></a>

            <!-- JS Tabelas de Treino Dinamicas-->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.querySelector("#num_Treino").addEventListener("input", function () {
                        var numTreinos = parseInt(this.value);
                        var listasDeTreino = document.getElementById("listas_de_treino");

                        listasDeTreino.innerHTML = ""; // Limpa o conteúdo anterior

                        for (var i = 1; i <= numTreinos; i++) {
                            listasDeTreino.innerHTML += `
                                <!-- Treino ${i} -->
                            
             
                    <div class="card-body">
                        <h5>Treino ${i}</h5>
                        <table class="table" id="tblSample${i}"> <!-- Adicione um ID único -->
                            <thead>
                                <tr>
                                    <th scope="col">Exercício</th>
                                    <th scope="col">Séries</th>
                                    <th scope="col">Repetições</th>
                                    <th scope="col">Carga/Velocidade</th>
                                    <th scope="col">Tempo de Descanso</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="exercicio[${i}][]">
                                            <?php
                                            foreach ($exercicios as $exercicio) {
                                                echo "<option value='{$exercicio['id']}'>{$exercicio['nome']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="series[${i}][]">
                                    </td>
                                    <td><input type="number" name="repeticoes[${i}][]"></td>
                                    <td><input type="text" name="carga_velocidade[${i}][]"></td>
                                    <td><input type="text" name="tempo_descanso[${i}][]"></td>
                                    <td>
                                    <button type="button" value="-Row" class="btn btn-danger btn-sm" onclick="deletarLinha('tblSample${i}', ${i})">Remover Exercício</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" value="+Row" class="btn btn-success btn-sm" onclick="myFunction2('tblSample${i}', ${i})"> + Exercício</button>
                    </div>   
                        `;
                        }
                    });
                });
            </script>

            <script>
                //Função para adicionar novas linhas.
                function myFunction2(myTable, indice) {
                    var table = document.getElementById(myTable);
                    var newRow = table.insertRow(table.rows.length); // Insere uma nova linha

                    // Aqui você pode adicionar células com os inputs e selects conforme necessário
                    newRow.innerHTML = `
        <td>
            <select name="exercicio[${indice}][]">
            <?php
            foreach ($exercicios as $exercicio) {
                echo "<option value='{$exercicio['id']}'>{$exercicio['nome']}</option>";
            }
            ?>
            </select>
        </td>
        <td>
            <input type="number" name="series[${indice}][]">
            </td>
        <td><input type="number" name="repeticoes[${indice}][]"></td>
        <td><input type="text" name="carga_velocidade[${indice}][]"></td>
        <td><input type="text" name="tempo_descanso[${indice}][]"></td>
        <td>
            <button type="button" value="-Row" class="btn btn-danger btn-sm" onclick="deletarLinha('${myTable}', ${indice})">Remover Exercício</button>
        </td>
    `;


                    // Limpa os valores dos inputs da nova linha
                    var inputs = newRow.getElementsByTagName('input');
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].value = '';
                    }

                    // Limpa o valor do select da nova linha
                    var select = newRow.querySelector('select');
                    select.selectedIndex = 0;
                }

                //Clona linha, fail
                function myFunction(myTable) {
                    var table = document.getElementById(myTable);
                    var row = table.getElementsByTagName('tr');
                    var row = row[row.length - 1].outerHTML;
                    table.innerHTML = table.innerHTML + row;
                    var row = table.getElementsByTagName('tr');
                    var row = row[row.length - 1].getElementsByTagName('td');
                    for (a = 0; a < row.length; a++) {
                        row[i].innerHTML = row[i].innerHTML + '<td></td>';;
                    }
                }

                // funcao remove uma linha da tabela
                function deleterow(tblId) {
                    var table = document.getElementById(tblId);
                    var row = table.getElementsByTagName('tr');
                    if (row.length > '1') {
                        row[row.length - 1].outerHTML = '';
                    }
                }

                function deletarLinha(idTabela, indiceLinha) {
                    var table = document.getElementById(idTabela);
                    table.deleteRow(indiceLinha);
                }


                //Funcao limpar linha da tabela

                function limparLinha2(idTabela, indiceLinha) {
                    var select = document.getElementById(idTabela).rows[indiceLinha].cells[0].getElementsByTagName('select')[0];
                    select.selectedIndex = 0;

                    var inputs = document.getElementById(idTabela).rows[indiceLinha].getElementsByTagName('input');
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].value = '';
                    }
                }


            </script>

            </div>
            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                    class="bi bi-arrow-up-short"></i></a>

            <!-- Vendor JS Files -->
            <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/vendor/chart.js/chart.umd.js"></script>
            <script src="assets/vendor/echarts/echarts.min.js"></script>
            <script src="assets/vendor/quill/quill.min.js"></script>
            <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
            <script src="assets/vendor/tinymce/tinymce.min.js"></script>
            <script src="assets/vendor/php-email-form/validate.js"></script>

            <!-- Template Main JS File -->
            <script src="assets/js/main.js"></script>

</body>

</html>