<?php
require_once("verificaAutenticacao.php");
//conectar no banco de dados (ip. usuario, senha, nome do banco)
require_once('conexao.php');

if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

if (isset($_POST['salvar'])) {

    $nome = $_POST['nome'];

    $diretorio = "imagensproduto/";
    $arquivoDestino = $diretorio . $_FILES['arquivo']['name'];

    $nomeArquivo = "";

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivoDestino)) {
        $nomeArquivo = $_FILES['arquivo']['name'];
    }
    $descricao = $_POST['descricao'];

    $grupomuscular_id = $_POST['grupoMuscular_id'];

    //3 Preparar a SQL
    $sql = "insert into exercicio (nome, imagem, descricao, grupomuscular_id) values ('$nome', '$nomeArquivo','$descricao', $grupomuscular_id)";

    //4 executar a SQL
    mysqli_query($conexao, $sql);

    // 5 Mostrar uma mensagem ao usuário
    $mensagem = "Registro Inserido com Sucesso";

}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Cadastro de Exercício</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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
            <h1>Cadastro de Exercício</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Exercício</h5>

                            <!-- General Form Elements -->
                            <form method="post" action="cadExercicio.php" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Nome:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nome" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="arquivo" class="col-sm-2 col-form-label">Imagem</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" name="arquivo" id="arquivo">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="descricao" class="col-sm-2 col-form-label">Descrição</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="descricao"
                                            style="height: 100px"></textarea>
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


                                        <!-- List group With Checkboxes and radios -->
                                        <!--<ul class="list-group">
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    aria-label="...">
                                                First checkbox
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    aria-label="...">
                                                Second checkbox
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    aria-label="...">
                                                Third checkbox
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    aria-label="...">
                                                Fourth checkbox
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    aria-label="...">
                                                Fifth checkbox
                                            </li>
                                        </ul>
                                        <!-- End List Checkboxes and radios -->

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <button type="submit" name="salvar" class="btn btn-primary">Cadastrar</button>
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


                <!-- Template Main JS File -->
                <script src="assets/js/main.js"></script>

</body>

</html>