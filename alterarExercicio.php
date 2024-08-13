<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    $diretorio = "imagensproduto/";
    $arquivoDestino = $diretorio . $_FILES['arquivo']['name'];

    $nomeArquivo = "";

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivoDestino)) {
        $nomeArquivo = $_FILES['arquivo']['name'];
    }

    $descricao = $_POST['descricao'];
    $grupoMuscular_id = $_POST['grupoMuscular_id'];

    //3 Preparar a SQL
    $sql = "UPDATE exercicio 
            SET nome = '$nome', 
                imagem = '$nomeArquivo',
                descricao = '$descricao',
                grupoMuscular_id = '$grupoMuscular_id' 
            WHERE id = $id";

    //4 executar a SQL
    mysqli_query($conexao, $sql);

    // 5 Mostrar uma mensagem ao usuário
    $mensagem = "Alteração Realizada com Sucesso";
}


//Bucar usuário selecionado pelo "listarExercicio.php"
$sql = "select * from exercicio where id = " . $_GET['id'];
$resultados = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_array($resultados);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Alteração de Exercício</title>
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

        <div class="pagetitle">
            <h1>Alteração de Cadastro</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Exercício</h5>

                            <!-- General Form Elements -->
                            <form action="alterarExercicio.php?id=<?= $_GET['id'] ?>" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <div class="row mb-3">
                                    <label for="nome" class="col-sm-2 col-form-label">Nome:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="nome" name="nome" class="form-control"
                                            value="<?= $linha['nome'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="arquivo" class="col-sm-2 col-form-label">Imagem</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" name="arquivo" id="arquivo">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="desc" class="col-sm-2 col-form-label">Descrição</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="descricao" name="descricao"
                                            style="height: 100px"><?= $linha['descricao'] ?></textarea>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Grupos Musculares</h5>
                                        <select name="grupoMuscular_id" id="" class="form-select">
                                            <option value=""> -- Selecione -- </option>
                                            <?php
                                            $sql = "select * from grupomuscular order by nome";
                                            $resultado = mysqli_query($conexao, $sql);

                                            while ($linhaTU = mysqli_fetch_array(($resultado))) {
                                                $id = $linhaTU['id'];
                                                $nome = $linhaTU['nome'];

                                                $selected = ($id == $linha['grupomuscular_id']) ? 'selected' : '';

                                                echo "<option value = '{$id}' {$selected}>{$nome}</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <button type="submit" name="salvar" class="btn btn-primary">Alterar</button>
                                        <button type="button" class="btn btn-warning" onclick="voltar()">Voltar</button>
                                    </div>
                                </div>

                            </form><!-- End General Form Elements -->

                        </div>
                    </div>

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

                <script>
                    function voltar() {
                        window.history.back();
                    }
                </script>
                <!-- Template Main JS File -->
                <script src="assets/js/main.js"></script>

</body>

</html>