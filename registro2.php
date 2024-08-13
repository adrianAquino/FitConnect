<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');

if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    if (isset($_POST['cadastrar'])) {
        if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['tipo_usuario'])) {

            // Pegar os dados do formulário
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $tipoUsuario = $_POST['tipo_usuario'];
            if ($tipoUsuario == "option1") {
                $tipoUsuario = "Aluno";
            }
            if ($tipoUsuario == "option2") {
                $tipoUsuario = "Personal";
            }

            // Verificar se o email já existe no banco de dados
            $sqlVerificaEmail = "SELECT COUNT(*) as count FROM aluno WHERE email = '$email'";
            $resultVerificaEmail = mysqli_query($conexao, $sqlVerificaEmail);
            $rowVerificaEmail = mysqli_fetch_assoc($resultVerificaEmail);

            // Verificar se o email já existe no banco de dados
            $sqlVerificaEmail2 = "SELECT COUNT(*) as count FROM personal WHERE email = '$email'";
            $resultVerificaEmail2 = mysqli_query($conexao, $sqlVerificaEmail2);
            $rowVerificaEmail2 = mysqli_fetch_assoc($resultVerificaEmail2);

            if ($rowVerificaEmail['count'] > 0 || $rowVerificaEmail2['count'] > 0)  {
                $mensagemErro = "Este email já está cadastrado. Por favor, escolha outro.";
            } else {
                // Preparar a SQL
                require_once("conexao.php");

                // Inicializar a variável $sql

                // Verificar o tipo de usuário e executar a SQL correspondente
                if ($tipoUsuario == "Aluno") {
                    $sql = "INSERT INTO aluno (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
                }
                if ($tipoUsuario == "Personal") {
                    $sql = "INSERT INTO personal (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
                }

                // Executar a SQL
                $resultado = mysqli_query($conexao, $sql);

                // Verificar se o cadastro foi bem-sucedido
                if ($resultado) {
                    // Redirecionar para a página de login após o cadastro bem-sucedido
                    $mensagem = "Usuário Cadastrado com Sucesso";
                    header("location: registro2.php?mensagem=" . urlencode($mensagem));
                    exit();
                } else {
                    $mensagemErro = "Erro ao Cadastrar Usuário.";
                    header("location: registro2.php");
                    exit();
                }
            }
        }
    }
}
$mensagem = isset($_GET['mensagem']) ? $_GET['mensagem'] : null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Cadastro Simples de Usuário</title>
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
        <?php if ($mensagem !== null) { ?>
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
            <h1>Cadastro Simplificado</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usuário</h5>

                            <!-- General Form Elements -->
                            <form action="registro2.php" method="post">
                                <div class="row mb-3">
                                    <label for="nome" class="col-sm-1 col-form-label">Nome:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="nome" name="nome" class="form-control"
                                            placeholder="Informe um Nome" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-1 col-form-label">Email:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Informe um Email" required>
                                    </div>
                                    <label for="yourPassword" class="col-sm-1 col-form-label">Senha:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="password" name="senha" id="yourPassword" class="form-control"
                                            placeholder="Informe uma Senha" required>
                                        <div class="form-check">
                                            <br>
                                            <div class="col-sm-4">
                                                <input class="form-check-input" type="checkbox"
                                                    id="showPasswordCheckbox" onclick="togglePasswordVisibility()">
                                                <label class="form-check-label" for="showPasswordCheckbox">Mostrar
                                                    Senha</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <br>

                                <div class="col-12">
                                    <fieldset class="row mb-3">
                                        <legend class="col-form-label col-sm-1 pt-0">Usuário:</legend>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipo_usuario"
                                                    id="gridRadios1" value="Aluno" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Aluno
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipo_usuario"
                                                    id="gridRadios2" value="Personal">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Personal
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <button type="submit" name="cadastrar"
                                                class="btn btn-primary">Cadastrar</button>
                                        </div>
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

                <!-- Máscara dos campos em JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
                    integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>
                    $('#cpf').mask('000.000.000-00', {
                        reverse: true
                    });
                    $('#telefone').mask('(00) 00000-0000');
                    $('#cep').mask('00000-000');
                </script>

                <!--  Função de exibir senha -->
                <script>
                    function togglePasswordVisibility() {
                        var passwordInput = document.getElementById("yourPassword");

                        if (passwordInput.type === "password") {
                            passwordInput.type = "text";
                        } else {
                            passwordInput.type = "password";
                        }
                    }
                </script>

                <!-- Template Main JS File -->
                <script src="assets/js/main.js"></script>

</body>

</html>