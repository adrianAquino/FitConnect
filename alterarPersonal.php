<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'personal' && $_SESSION['perfil'] != 'admin')) {
    // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
    header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
    exit();
}
function validarCPF($cpf)
{
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF possui 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais
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

    // Verifica se os dígitos verificadores estão corretos
    if ($cpf[9] == $digito1 && $cpf[10] == $digito2) {
        return true;
    } else {
        return false;
    }
}


if (isset($_POST['salvar'])) {
    $cpf = $_POST["cpf"];

    if (!validarCPF($cpf)) { //Se o CPF for inválido
        $mensagemErro = "CPF inválido.";
    } else {
        //prossegue com o cadastro pq o cpf foi válido
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $sexo = $_POST['sexo'];
        $dataNascimento = $_POST['dataNascimento'];
        $cref = $_POST['cref'];
        $cpf = $_POST['cpf'];
        $cnpj = $_POST['cnpj'];
        $telefone = $_POST['telefone'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        ///$avaliacao = $_FILES['avaliacao'];
        $observacao = $_POST['observacao'];


        //3 Preparar a SQL
        $sql = "update personal set
    nome = '$nome', 
    email = '$email',
    senha = '$senha', 
    sexo = '$sexo', 
    dataNascimento = '$dataNascimento',
    cref = '$cref', 
    cpf = '$cpf',
    cnpj = '$cnpj',
    telefone = '$telefone',
    cep = '$cep', 
    endereco = '$endereco',
    numero = '$numero',
    bairro = '$bairro', 
    cidade = '$cidade', 
    estado = '$estado', 
    observacao = '$observacao' where id = $id";

        //4 executar a SQL
        mysqli_query($conexao, $sql);

        // 5 Mostrar uma mensagem ao usuário
        $mensagem = "Alteração Concluída com Sucesso";
    }
}
//Bucar usuário selecionado pelo "listarPersonal.php"
$sql = "select * from personal where id = " . $_GET['id'];
$resultados = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_array($resultados);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Alteração de Personal</title>
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
            <h1>Alteração de Cadastro</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Personal</h5>

                            <!-- General Form Elements -->
                            <form action="alterarPersonal.php?id=<?= $_GET['id'] ?>" method="post">
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
                                    <label for="email" class="col-sm-2 col-form-label">Email:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="<?= $linha['email'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Senha:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="senha" class="form-control"
                                            value="<?= $linha['senha'] ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="dataNascimento" class="col-sm-2 col-form-label">Data de Nascimento:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="date" id="dataNascimento" name="dataNascimento"
                                            class="form-control"
                                            value="<?= (isset($linha['dataNascimento']) ? $linha['dataNascimento'] : "") ?>"
                                            required>
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Sexo</legend>
                                    <?php
                                    $checkedM = ($linha['sexo'] == 'Masculino') ? 'checked' : '';
                                    $checkedF = ($linha['sexo'] == 'Feminino') ? 'checked' : '';
                                    ?>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="gridRadios1"
                                                value="Masculino" <?= $checkedM ?>>
                                            <label class="form-check-label" for="gridRadios1">
                                                Masculino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="gridRadios2"
                                                value="Feminino" <?= $checkedF ?>>
                                            <label class="form-check-label" for="gridRadios2">
                                                Feminino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sexo" id="gridRadios3"
                                                value="Não informou">
                                            <label class="form-check-label" for="gridRadios3">
                                                Prefiro não dizer
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="row mb-3">
                                    <label for="cref" class="col-sm-2 col-form-label">CREF:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cref" name="cref" class="form-control"
                                            value="<?= $linha['cref'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cpf" class="col-sm-2 col-form-label">CPF:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cpf" name="cpf" class="form-control"
                                            value="<?= $linha['cpf'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cnpj" class="col-sm-2 col-form-label">CNPJ:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cnpj" name="cnpj" class="form-control"
                                            value="<?= $linha['cnpj'] ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="telefone" class="col-sm-2 col-form-label">Telefone:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="telefone" name="telefone" class="form-control"
                                            value="<?= $linha['telefone'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cep" class="col-sm-2 col-form-label">CEP:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cep" name="cep" class="form-control"
                                            value="<?= $linha['cep'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="endereco" class="col-sm-2 col-form-label">Endereço:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="endereco" name="endereco" class="form-control"
                                            value="<?= $linha['endereco'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nr_end" class="col-sm-2 col-form-label">Número:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="nr_end" name="numero" class="form-control"
                                            value="<?= $linha['numero'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bairro" class="col-sm-2 col-form-label">Bairro:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="bairro" name="bairro" class="form-control"
                                            value="<?= $linha['bairro'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cidade" class="col-sm-2 col-form-label">Cidade:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cidade" name="cidade" class="form-control"
                                            value="<?= $linha['cidade'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uf" class="col-sm-2 col-form-label">Estado:<span
                                            class="campo-obrigatorio">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="estado" id="uf" class="form-control"
                                            value="<?= $linha['estado'] ?>" required>
                                    </div>
                                </div>
                                <!--<div class="row mb-3">
                                    <label for="avaliacao" class="col-sm-2 col-form-label">Avaliação*</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="avaliacao" type="file" id="avaliacao">
                                    </div>
                                </div>-->
                                <div class="row mb-3">
                                    <label for="observacao" class="col-sm-2 col-form-label">Observação</label>
                                    <div class="col-sm-10">
                                        <textarea input class="form-control" id="observacao" name="observacao"
                                            style="height: 100px"><?= $linha['observacao'] ?></textarea>
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