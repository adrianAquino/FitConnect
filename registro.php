<?php
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

    // Preparar a SQL
    require_once("conexao.php");

    // Verificar se o email já existe no banco de dados
    $sqlVerificaEmail = "SELECT COUNT(*) as count FROM aluno WHERE email = '$email'";
    $resultVerificaEmail = mysqli_query($conexao, $sqlVerificaEmail);

    if (!$resultVerificaEmail) {
      die('Erro na consulta SQL: ' . mysqli_error($conexao));
    }

    $rowVerificaEmail = mysqli_fetch_assoc($resultVerificaEmail);

    // Verificar se o email já existe no banco de dados
    $sqlVerificaEmail2 = "SELECT COUNT(*) as count FROM personal WHERE email = '$email'";
    $resultVerificaEmail2 = mysqli_query($conexao, $sqlVerificaEmail2);

    if (!$resultVerificaEmail2) {
      die('Erro na consulta SQL: ' . mysqli_error($conexao));
    }

    $rowVerificaEmail2 = mysqli_fetch_assoc($resultVerificaEmail2);


    if ($rowVerificaEmail['count'] > 0 || $rowVerificaEmail2['count'] > 0) {
      $mensagemErro = "Este email já está cadastrado. Por favor, escolha outro.";
      header("location: registro.php?mensagem=$mensagemErro");
      exit();
    } else {
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
        header("location: index.php");
        exit();
      } else {
        $mensagem = "Erro ao cadastrar usuário.";
        header("location: registro.php?mensagem=$mensagem");
        exit();
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

  <title>Registro - FitConnect</title>
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
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">


      <?php if ($mensagem !== null) { ?>
        <div class="alert alert-warning" role="alert">
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

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">FitConnect</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Criar a sua conta</h5>
                    <p class="text-center small">Informe seus dados pessoais para criar uma conta</p>
                  </div>

                  <form method="post" action="registro.php" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nome:<span class="campo-obrigatorio">*</span></label>
                      <input type="text" name="nome" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Por favor, informe seu nome!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email:<span class="campo-obrigatorio">*</span></label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Por favor, informe seu email corretamente</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Senha:<span
                          class="campo-obrigatorio">*</span></label>
                      <div class="input-group">
                        <input type="password" name="senha" class="form-control" id="yourPassword" required>
                        <button type="button" class="btn btn-outline-secondary" id="showPasswordBtn"
                          onclick="togglePasswordVisibility()">
                          <i class="bi bi-eye"></i>
                        </button>
                      </div>
                      <div class="invalid-feedback">Por favor, informe sua senha!</div>
                    </div>

                    <div class="col-12">
                      <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0"></legend>
                        <div class="col-sm-10">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_usuario" id="gridRadios1"
                              value="option1" checked>
                            <label class="form-check-label" for="gridRadios1">
                              Sou Aluno
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_usuario" id="gridRadios2"
                              value="option2">
                            <label class="form-check-label" for="gridRadios2">
                              Sou Personal
                            </label>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="cadastrar" type="submit">Criar Conta</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Já tem uma conta? <a href="index.php">Login</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Developed by <a href=""> AG Soluções Tecnológicas</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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
</body>

</html>