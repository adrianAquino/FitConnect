<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
// Verifique se o parâmetro exercicio_id foi passado na URL
if (isset($_GET['id'])) {
    $exercicioId = $_GET['id'];
    // Consulta ao banco de dados para obter informações do exercício
    $sqlExercicio = "SELECT e.*, gm.nome AS nomeGrupoMuscular
                    FROM exercicio e
                    JOIN grupomuscular gm ON e.grupomuscular_id = gm.id
                    WHERE e.id = $exercicioId";

    $resultadoExercicio = mysqli_query($conexao, $sqlExercicio);

    if ($linhaExercicio = mysqli_fetch_assoc($resultadoExercicio)) {
        $nomeExercicio = $linhaExercicio['nome'];
        $nomeGrupoMuscular = $linhaExercicio['nomeGrupoMuscular'];
        $descricaoExercicio = $linhaExercicio['descricao'];
        $caminhoImagem = $linhaExercicio['imagem'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Exibir Detalhes do Exercício</title>
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
        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-10 col-xl-12">
                        <div class="card" style="border-radius: 15px;">
                            <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                                data-mdb-ripple-color="light">
                                <img src="imagensproduto/<?= $linhaExercicio['imagem']; ?>"
                                    style="border-top-left-radius: 15px; border-top-right-radius: 15px;"
                                    class="img-fluid" alt="Imagem do Exercício" />
                                <a href="#!">
                                    <div class="mask"></div>
                                </a>
                            </div>
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p><a href="#!" class="text-dark">Nome:
                                                <?php echo $nomeExercicio; ?>
                                            </a></p>
                                        <p class="small text-muted">Grupo Muscular:
                                            <?php echo $nomeGrupoMuscular; ?>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="d-flex flex-row justify-content-end mt-1 mb-4 text-danger">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="small text-muted">ID do Exercício:
                                            <?php echo $exercicioId; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark">Descrição:
                                        <?php echo $descricaoExercicio; ?>
                                    </p>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center pb-2 mb-1">
                                    <a href="#!" id="btnVoltar" class="text-dark fw-bold">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Adicione um ouvinte de evento de clique ao botão "Voltar"
                document.getElementById('btnVoltar').addEventListener('click', function () {
                    // Use a função history.back() para voltar para a tela anterior
                    window.history.back();
                });
            });
        </script>

</body>

</html>