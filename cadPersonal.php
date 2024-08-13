<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');

//permite o acesso somente se o usuário na sessão estiver logado como personal ou admin.
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

//Permite o acesso somente se o usuário logado na sessão for admin
/*if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}*/

require_once("verificaAutenticacao.php");
require_once('conexao.php');

if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}

function validarCPF($cpf)
{
    // Remover caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verificar se o CPF possui 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verificar se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verificar se os dígitos verificadores estão corretos
    return ($cpf[9] == $digito1 && $cpf[10] == $digito2);
}

if (isset($_POST['salvar'])) {


    // Verificar se 'cpf' e 'email' estão definidos em $_POST
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    // Se 'cpf' ou 'email' não estiverem definidos, tratar o erro conforme necessário
    if ($cpf === null || $email === null) {
        // Trate o erro conforme necessário
        $mensagemErro1 = "CPF ou e-mail não estão definidos.";
    } else {
        // Validar CPF
        if (!validarCPF($cpf)) {
            // CPF inválido, trate o erro conforme necessário
            $mensagemErro = "CPF inválido.";
        } else {
            // Verificar se o CPF ou e-mail já existem no banco
            $sqlVerificacao = "SELECT COUNT(*) as total FROM personal WHERE cpf = '$cpf' OR email = '$email'";
            $resultVerificacao = mysqli_query($conexao, $sqlVerificacao);
            $rowVerificacao = mysqli_fetch_assoc($resultVerificacao);

            if ($rowVerificacao['total'] > 0) {
                // Já existe um registro com o mesmo CPF ou e-mail, trate o erro conforme necessário
                $mensagemErro = "Erro: CPF ou e-mail já cadastrados. Tente Novamente";
            } else {
                // CPF e e-mail são válidos e não existem no banco, prosseguir com o cadastro
                // Restante do código para inserir no banco de dados
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $sexo = $_POST['sexo'];
                if ($sexo == "option1") {
                    $sexo = "Masculino";
                } else if ($sexo == "option2") {
                    $sexo = "Feminino";
                } else {
                    $sexo = "Não informou";
                }
                $dataNascimento = $_POST['dataNascimento'];
                $cref = $_POST['cref'];
                $cnpj = $_POST['cnpj'];
                $telefone = $_POST['telefone'];
                $cep = $_POST['cep'];
                $endereco = $_POST['endereco'];
                $numero = $_POST['numero'];
                $bairro = $_POST['bairro'];
                $cidade = $_POST['cidade'];
                $estado = $_POST['estado'];
                $observacao = $_POST['observacao'];

                // Preparar a SQL
                $sql = "INSERT INTO personal (nome, email, senha, sexo, dataNascimento, cpf, cref, cnpj, telefone, cep, endereco, numero, bairro, cidade, estado, observacao) VALUES ('$nome', '$email', '$senha', '$sexo', '$dataNascimento', '$cpf', '$cref', '$cnpj', '$telefone', '$cep', '$endereco', '$numero', '$bairro', '$cidade', '$estado', '$observacao')";

                // Executar a SQL
                if (mysqli_query($conexao, $sql)) {
                    // Cadastro bem-sucedido
                    $mensagem = "Personal Cadastrado com Sucesso";

                    // Redirecionar de volta para a página desejada (fora do bloco anterior)
                    header("Location: cadPersonal.php?mensagem=" . urlencode($mensagem));
                    exit(); // Certifique-se de sair após o redirecionamento
                } else {
                    // Erro na execução da SQL
                    die("Erro na execução da SQL: " . mysqli_error($conexao));
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Personal</title>
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

        <?php if (isset($mensagemErro1)) { ?>
            <div class="alert alert-warning" role="alert">
                <i class="fa-solid fa-square-check"></i>
                <?= $mensagemErro1 ?>
            </div>
        <?php } ?>

        <div class="pagetitle">
            <h1>Cadastro de Personal</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Personal</h5>

                            <!-- General Form Elements -->
                            <form action="cadPersonal.php" method="post">
                                <div class="row mb-3">
                                    <label for="nome" class="col-sm-1 col-form-label">Nome:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="nome" name="nome" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-1 col-form-label">Email:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                    <label for="inputPassword" class="col-sm-1 col-form-label">Senha:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="password" name="senha" class="form-control" required>
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-1 pt-0">Sexo</legend>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="gridRadios1"
                                                value="option1" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Masculino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="gridRadios2"
                                                value="option2">
                                            <label class="form-check-label" for="gridRadios2">
                                                Feminino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="gridRadios3"
                                                value="option3">
                                            <label class="form-check-label" for="gridRadios3">
                                                Prefiro não dizer
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label for="dataNascimento" class="col-sm-1 col-form-label">Data de Nascimento:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="date" id="dataNascimento" name="dataNascimento"
                                            class="form-control" required>
                                    </div>
                                    <label for="cref" class="col-sm-1 col-form-label">CREF:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="cref" name="cref" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cpf" class="col-sm-1 col-form-label">CPF:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="cpf" name="cpf" class="form-control" required>
                                    </div>
                                    <label for="cnpj" class="col-sm-1 col-form-label">CNPJ</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="cnpj" name="cnpj" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="telefone" class="col-sm-1 col-form-label">Telefone:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="telefone" name="telefone" class="form-control" required>
                                    </div>
                                    <label for="cep" class="col-sm-1 col-form-label">CEP:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="cep" name="cep" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="endereco" class="col-sm-1 col-form-label">Endereço:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="endereco" name="endereco" class="form-control" required>
                                    </div>
                                    <label for="nr_end" class="col-sm-1 col-form-label">Número:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="numero" name="nr_end" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bairro" class="col-sm-1 col-form-label">Bairro:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="bairro" name="bairro" class="form-control" required>
                                    </div>
                                    <label for="cidade" class="col-sm-1 col-form-label">Cidade:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" id="cidade" name="cidade" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uf" class="col-sm-1 col-form-label">Estado:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="estado" id="uf" class="form-control" required>
                                    </div>
                                </div>
                                <!--<div class="row mb-3">
                                <label for="avaliacao" class="col-sm-2 col-form-label">Avaliação*</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="avaliacao" type="file" id="avaliacao">
                                </div>
                            </div>-->
                                <div class="row mb-3">
                                    <label for="observacao" class="col-sm-1 col-form-label">Observação</label>
                                    <div class="col-sm-9">
                                        <textarea input class="form-control" id="observacao" name="observacao"
                                            style="height: 100px"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
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

                <!-- AutoCompletar o endereco-->
                <script src="https://code.jquery.com/jquery-3.0.0.min.js" type="text/javascript"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"
                    type="text/javascript"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#cep").mask("99999-999", {
                            completed: function () {
                                var cep = $(this).val().replace(/[^0-9]/, "");

                                // Validação do CEP; caso o CEP não possua 8 números, então cancela
                                // a consulta
                                if (cep.length != 8) {
                                    return false;
                                }

                                // A url de pesquisa consiste no endereço do webservice + o cep que
                                // o usuário informou + o tipo de retorno desejado (entre "json",
                                // "jsonp", "xml", "piped" ou "querty")
                                var url = "https://viacep.com.br/ws/" + cep + "/json/";

                                $.getJSON(url, function (dadosRetorno) {
                                    try {
                                        // Preenche os campos de acordo com o retorno da pesquisa
                                        $("#endereco").val(dadosRetorno.logradouro);
                                        $("#bairro").val(dadosRetorno.bairro);
                                        $("#cidade").val(dadosRetorno.localidade);
                                        $("#uf").val(dadosRetorno.uf);
                                        $("#nr_end").focus();
                                    } catch (ex) { }
                                });
                            }
                        });

                    });
                </script>

</body>

</html>