<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');


if (isset($_GET['id'])) {
    $idFichaTreino = $_GET['id'];


    // Adicione esta consulta para obter o número de treinos
    $sqlNumTreinos = "SELECT COUNT(DISTINCT treino_id) AS numTreinos FROM exercicio_treino WHERE ficha_treino_id = $idFichaTreino";
    $resultadoNumTreinos = mysqli_query($conexao, $sqlNumTreinos);

    if (!$resultadoNumTreinos) {
        die('Erro na consulta SQL: ' . mysqli_error($conexao));
    }

    $linhaNumTreinos = mysqli_fetch_assoc($resultadoNumTreinos);
    $numTreinos = $linhaNumTreinos['numTreinos'];

    // fim da consulta de num treinos

    $sqlFichaTreino = "SELECT * FROM ficha_treino WHERE id = $idFichaTreino";
    $resultadoFichaTreino = mysqli_query($conexao, $sqlFichaTreino);

    if ($linhaFichaTreino = mysqli_fetch_assoc($resultadoFichaTreino)) {
        $idFichaTreino = $linhaFichaTreino['id'];
        $nomeFichaTreino = $linhaFichaTreino['nome'];
        $personalFichaTreino = $linhaFichaTreino['personal_id'];
        $descricaoFichaTreino = $linhaFichaTreino['descricao'];

        $sqlExercicios = "SELECT et.id AS idExercicioTreino, et.series, et.repeticoes, et.carga_velocidade, et.tempo_descanso, e.id AS idExercicio, e.nome AS nomeExercicio, e.imagem AS imagemExercicio, e.descricao AS descricaoExercicio
                  FROM exercicio_treino et
                  JOIN exercicio e ON et.exercicio_id = e.id
                  WHERE et.ficha_treino_id = $idFichaTreino AND et.treino_id = 1";

        $resultadoExercicios = mysqli_query($conexao, $sqlExercicios);
    } else {
        header("Location: erro.php");
        exit();
    }
} else {
    header("Location: erro.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Exercícios</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>-->
    <script src="https://kit.fontawesome.com/b56b5884c4.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <!--<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/treino.css" rel="stylesheet">


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
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-2">
                        <h2 class="heading-section">Treino #<span id="numeroTreinoAtual">1</span></h2>
                        <div class="btn-group" role="group" aria-label="Treino">
                            <?php
                            for ($i = 1; $i <= $numTreinos; $i++) {
                                echo '<button type="button" class="btn btn-light" onclick="filtrarTreino(' . $i . ')">' . $i . '</button>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="h5 mb-4 text-center">Exercícios</h3>
                        <div class="table-wrap">
                            <table id="tabelaExercicios" class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Exercício</th>
                                        <th>Séries</th>
                                        <th>Repetições</th>
                                        <th>Carga</th>
                                        <th>Descanso</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop através dos dados do exercicio_treino
                                    while ($linhaExercicio = mysqli_fetch_array($resultadoExercicios)) {
                                        ?>
                                        <tr class="alert" role="alert">
                                            <td>
                                                <div class="img"
                                                    style="background-image: url(imagensproduto/<?= $linhaExercicio['imagemExercicio']; ?>);">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="email">
                                                    <span>
                                                        <?php echo $linhaExercicio['nomeExercicio']; ?>
                                                    </span>
                                                    <span>
                                                        <?php echo $linhaExercicio['descricaoExercicio']; ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $linhaExercicio['series']; ?>
                                            </td>
                                            <td>
                                                <?php echo $linhaExercicio['repeticoes']; ?>
                                            </td>
                                            <td>
                                                <?php echo $linhaExercicio['carga_velocidade']; ?>
                                            </td>
                                            <td>
                                                <?php echo $linhaExercicio['tempo_descanso']; ?>
                                            </td>
                                            <td>
                                                <a href="mostrarExercicio.php?id=<?= $linhaExercicio['idExercicio'] ?>"
                                                    class="btn btn-warning" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Ver detalhes do Exercício">
                                                    <i class="bi bi-arrow-up-right-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main1.js"></script>


    <script>
        function filtrarTreino(numeroTreino) {
            // Atualiza o número do treino no título
            $('#numeroTreinoAtual').text(numeroTreino);

            // Faz uma requisição AJAX para obter os exercícios do treino selecionado
            $.ajax({
                type: 'GET',
                url: 'filtrar_treino.php', // Crie um arquivo PHP para processar a requisição AJAX
                data: { idFichaTreino: <?= $idFichaTreino ?>, numeroTreino: numeroTreino },
                success: function (response) {
                    // Atualiza a tabela com os exercícios filtrados
                    $('#tabelaExercicios tbody').html(response);
                },
                error: function () {
                    alert('Erro ao filtrar os exercícios.');
                }
            });
        }
    </script>

    <script>
        // Inicialize os tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>


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