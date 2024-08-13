<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

//Exclusão
if (isset($_GET['id'])) {
    $sql = "delete from personal where id = " . $_GET['id'];
    mysqli_query($conexao, $sql);
    $mensagem = "Exclusão realizada com sucesso.";
}
// preparar a SQL
$sql = "select * from personal";
//Executar a SQL
$resultados = mysqli_query($conexao, $sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Listagem de Personais</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>-->
    <script src="https://kit.fontawesome.com/b56b5884c4.js" crossorigin="anonymous"></script>

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

        <div class="pagetitle">
            <h1>Personais</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="card mt-4 mb-4">
                                <div class="card-body">
                                    <h2 class="card-title">Listagem de Personais
                                        <a href="cadPersonal.php" class="btn btn-primary btn-sn">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </h2>
                                </div>



                                <!-- Table with stripped rows -->
                                <div style="overflow-x: auto">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">CREF</th>
                                                <th scope="col">Telefone</th>
                                                <th scope="col">Cidade</th>
                                                <th scope="col">Data de Cadastro</th>
                                                <th scope="col">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($linha = mysqli_fetch_array($resultados)) { ?>
                                                <tr>
                                                    <td>
                                                        <?= $linha['id'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $linha['nome'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $linha['email'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $linha['cref'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $linha['telefone'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $linha['cidade'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $linha['dataCadastro'] ?>
                                                    </td>
                                                    <td>
                                                        <a href="alterarPersonal.php?id=<?= $linha['id'] ?>"
                                                            class="btn btn-warning">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <a href="listarPersonal.php?id=<?= $linha['id'] ?>"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Confirma exclusão?')">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Table with stripped rows -->

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

</body>

</html>