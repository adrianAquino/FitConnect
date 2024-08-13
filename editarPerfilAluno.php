<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');

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
    // Verificar se 'id' está definido em $_POST
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    // Se 'id' não estiver definido, tratar o erro conforme necessário
    if ($id === null) {
        // Trate o erro conforme necessário
        $mensagemErro1 = "ID não está definido.";
    } else {
        // Recuperar dados do formulário
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $sexo = $_POST['sexo'];
        $dataNascimento = $_POST['dataNascimento'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $observacao = $_POST['observacao'];

        // Validar CPF
        if (!validarCPF($cpf)) {
            // CPF inválido, trate o erro conforme necessário
            $mensagemErro = "CPF inválido. Você será redirecionado para a página de Perfil em 5 segundos.";
        } else {
            // CPF válido, prosseguir com a atualização

            // Preparar a SQL
            $sql = "UPDATE aluno SET
            nome = '$nome',
            email = '$email',
            senha = '$senha',
            sexo = '$sexo',
            dataNascimento = '$dataNascimento',
            cpf = '$cpf',
            telefone = '$telefone',
            cep = '$cep',
            endereco = '$endereco',
            numero = '$numero',
            bairro = '$bairro',
            cidade = '$cidade',
            estado = '$estado',
            observacao = '$observacao' WHERE id = $id";

            if (mysqli_query($conexao, $sql)) {
                // Atualização bem-sucedida
                $mensagem = "Alteração Concluída com Sucesso";

                // Redirecionar de volta para mostrarPerfilAluno.php
                header("Location: mostrarPerfilAluno.php");
                exit(); // Certifique-se de sair após o redirecionamento
            } else {
                // Erro na execução da SQL
                die("Erro na execução da SQL: " . mysqli_error($conexao));
            }
        }
    }
}

// Lembre-se de fechar a conexão, se necessário
// mysqli_close($conexao);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta</title>
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
</head>

<body>
    <main id="main" class="main">
        <?php if (isset($mensagemErro)) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa-solid fa-square-check"></i>
                <?= $mensagemErro ?>
                <br>
                Redirecionando em <span id="contador">5</span> segundos.
            </div>
            <script>
                // Adicionar redirecionamento após 5 segundos
                let tempoRestante = 5;
                const contadorElement = document.getElementById('contador');
                
                setInterval(function () {
                    tempoRestante -= 1;
                    contadorElement.innerText = tempoRestante;

                    if (tempoRestante <= 0) {
                        window.location.href = 'mostrarPerfilAluno.php';
                    }
                }, 1000); // 1000 milissegundos = 1 segundo
            </script>
        <?php } ?>
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
    </main>
</body>

</html>