<?php
if (isset($_POST['login'], $_POST['email'], $_POST['senha'])) {
    // 1. Pegar os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // 2. Preparar a SQL
    $sqlAluno = "SELECT * FROM aluno WHERE email = '{$email}' AND senha = '{$senha}'";
    $sqlPersonal = "SELECT * FROM personal WHERE email = '{$email}' AND senha = '{$senha}'";
    $sqlAdm = "SELECT * FROM adm WHERE email = '{$email}' AND senha = '{$senha}'";

    // 3. Executa a SQL
    require_once("conexao.php");

    $resultadoAluno = mysqli_query($conexao, $sqlAluno);
    $resultadoPersonal = mysqli_query($conexao, $sqlPersonal);
    $resultadoAdm = mysqli_query($conexao, $sqlAdm);

    $registrosAluno = mysqli_num_rows($resultadoAluno);
    $registrosPersonal = mysqli_num_rows($resultadoPersonal);
    $registrosAdm = mysqli_num_rows($resultadoAdm);

    // 4. Verifica em qual tabela o usuário está registrado e redireciona
    if ($registrosAluno > 0) {
        $personal = mysqli_fetch_array($resultadoAluno);
        session_start();
        $_SESSION['id'] = $personal['id'];
        $_SESSION['nome'] = $personal['nome'];
        $_SESSION['email'] = $personal['email'];
        $_SESSION['perfil'] = 'aluno';  // linha para armazenar o perfil
        header("location: homeAluno.php");
    } elseif ($registrosPersonal > 0) {
        $personal = mysqli_fetch_array($resultadoPersonal);
        session_start();
        $_SESSION['id'] = $personal['id'];
        $_SESSION['nome'] = $personal['nome'];
        $_SESSION['email'] = $personal['email'];
        $_SESSION['perfil'] = 'personal';  // linha para armazenar o perfil
        header("location: homePersonal.php");
    } elseif ($registrosAdm > 0) {
        $admin = mysqli_fetch_array($resultadoAdm);
        session_start();
        $_SESSION['id'] = $admin['id'];
        $_SESSION['nome'] = $admin['nome'];
        $_SESSION['email'] = $admin['email'];
        $_SESSION['perfil'] = 'admin';  // linha para armazenar o perfil
        header("location: home.php");
    } else {
        $mensagem = "Usuário/Senha inválidos.";
        session_start();
        $_SESSION['mensagemErro'] = $mensagem;
        header("location: login.php");
    }
} else {
    // Se alguma das variáveis necessárias não estiver definida, redireciona ou exibe uma mensagem de erro.
    $mensagem = "Informe o e-mail e a senha.";
    header("location: index.php?mensagem=$mensagem");
}

?>