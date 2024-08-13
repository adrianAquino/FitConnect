<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');

// Obter o ID do aluno da sessão
$idPersonal = $_SESSION['id'];

// Consultar o banco de dados para obter as informações do personal
$sql = "SELECT * FROM personal WHERE id = $idPersonal";
$resultado = mysqli_query($conexao, $sql);

// Verificar se a consulta foi bem-sucedida
if ($resultado) {
    $personal = mysqli_fetch_assoc($resultado);

    // Formatando a data de nascimento
    $dataNascimentoFormatada = date('d/m/Y', strtotime($personal['dataNascimento']));

    // Formatando a data de cadastro
    $dataCadastroFormatada = date('d/m/Y H:i:s', strtotime($personal['dataCadastro']));
} else {
    // Tratar erro, redirecionar ou exibir mensagem, conforme necessário
    die("Erro na consulta ao banco de dados: " . mysqli_error($conexao));
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Meu Perfil</title>
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
    <?php require_once('menuPersonal.php'); ?>

    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <!--<img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">-->
                            <h2>
                                <?php echo $personal['nome']; ?>
                            </h2>
                            <h3>
                                <?php echo $personal['email']; ?>
                            </h3>
                            <!--<div class="social-links mt-2">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>-->
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Sobre</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar
                                        Perfil</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-settings">Configurações</button>
                                </li>


                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Observações</h5>
                                    <p class="small fst-italic">
                                        <?php echo $personal['observacao']; ?>
                                    </p>

                                    <h5 class="card-title">Detalhes</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">ID</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['id']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nome</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['nome']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['email']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Senha</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['senha']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Sexo</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['sexo']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Data de Nascimento</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $dataNascimentoFormatada; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">CPF</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['cpf']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Telefone</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['telefone']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">CEP</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['cep']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Endereço</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['endereco']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Número</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['numero']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Bairro</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['bairro']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Cidade</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['cidade']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Estado</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $personal['estado']; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Data de Cadastro</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo $dataCadastroFormatada; ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="editarPerfilPersonal.php" method="post">

                                        <!-- Adicione o campo hidden para enviar o ID do aluno -->
                                        <input type="hidden" name="id" value="<?php echo $personal['id']; ?>">
                                        <!--<div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="assets/img/profile-img.jpg" alt="Profile">
                                                <div class="pt-2">
                                                    <a href="#" class="btn btn-primary btn-sm"
                                                        title="Upload new profile image"><i
                                                            class="bi bi-upload"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"
                                                        title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>-->

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome
                                                Completo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nome" type="text" class="form-control" id="fullName"
                                                    value="<?php echo $personal['nome']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="observacao"
                                                class="col-md-4 col-lg-3 col-form-label">Observações</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="observacao" class="form-control" id="observacao"
                                                    style="height: 100px"><?php echo $personal['observacao']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="email"
                                                    value="<?php echo $personal['email']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="senha" class="col-md-4 col-lg-3 col-form-label">Senha</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="senha" type="password" class="form-control" id="senha"
                                                    value="<?php echo $personal['senha']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                                <label for="senha" class="col-md-4 col-lg-3 col-form-label">Sexo:</label>
                                                <?php
                                                $checkedM = ($personal['sexo'] == 'Masculino') ? 'checked' : '';
                                                $checkedF = ($personal['sexo'] == 'Feminino') ? 'checked' : '';
                                                ?>
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sexo"
                                                            id="gridRadios1" value="Masculino" <?= $checkedM ?>>
                                                        <label class="form-check-label" for="gridRadios1">
                                                            Masculino
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sexo"
                                                            id="gridRadios2" value="Feminino" <?= $checkedF ?>>
                                                        <label class="form-check-label" for="gridRadios2">
                                                            Feminino
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sexo"
                                                            id="gridRadios3" value="Não informou">
                                                        <label class="form-check-label" for="gridRadios3">
                                                            Prefiro não dizer
                                                        </label>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Data de
                                                Nascimento</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="date" id="dataNascimento" name="dataNascimento"
                                                    class="form-control"
                                                    value="<?= (isset($personal['dataNascimento']) ? $personal['dataNascimento'] : "") ?>"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="cref" class="col-md-4 col-lg-3 col-form-label">CREF</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="cref" type="text" class="form-control" id="cpf"
                                                    value="<?php echo $personal['cref']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="cpf" class="col-md-4 col-lg-3 col-form-label">CPF</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="cpf" type="text" class="form-control" id="cpf"
                                                    value="<?php echo $personal['cpf']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="cnpj" class="col-md-4 col-lg-3 col-form-label">CNPJ</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="cnpj" type="text" class="form-control" id="cpf"
                                                    value="<?php echo $personal['cnpj']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="telefone" class="col-md-4 col-lg-3 col-form-label">Telefone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="telefone" type="text" class="form-control" id="telefone"
                                                    value="<?php echo $personal['telefone']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="cep" class="col-md-4 col-lg-3 col-form-label">CEP</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="cep" type="text" class="form-control" id="cep"
                                                    value="<?php echo $personal['cep']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="endereco"
                                                class="col-md-4 col-lg-3 col-form-label">Endereço</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="endereco" type="text" class="form-control" id="endereco"
                                                    value="<?php echo $personal['endereco']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="numero"
                                                class="col-md-4 col-lg-3 col-form-label">Número</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="numero" type="text" class="form-control" id="numero"
                                                    value="<?php echo $personal['numero']; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="bairro"
                                                class="col-md-4 col-lg-3 col-form-label">Bairro</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="bairro" type="text" class="form-control" id="bairro"
                                                    value="<?php echo $personal['bairro']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="cidade"
                                                class="col-md-4 col-lg-3 col-form-label">Cidade</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="cidade" type="text" class="form-control" id="cidade"
                                                    value="<?php echo $personal['cidade']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="estado"
                                                class="col-md-4 col-lg-3 col-form-label">Estado</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="estado" type="text" class="form-control" id="estado"
                                                    value="<?php echo $personal['estado']; ?>">
                                            </div>
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" name="salvar" class="btn btn-primary">Salvar
                                                Alterações</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-settings">

                                    <!-- Settings Form -->
                                    <form>

                                    </form><!-- End settings Form -->

                                </div>



                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>FitConnect</span></strong>. Todos os direitos reservados
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Developed by <a href="https://bootstrapmade.com/">AG Soluções Tecnológicas</a>
        </div>
    </footer><!-- End Footer -->

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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var urlParams = new URLSearchParams(window.location.search);
        var action = urlParams.get('action');

        if (action === 'edit-profile') {
            // Ativar a guia "Editar Perfil"
            var editProfileTab = document.querySelector('[data-bs-target="#profile-edit"]');
            if (editProfileTab) {
                editProfileTab.click(); // Simular um clique para ativar a guia

                // Mostrar o conteúdo da guia "Editar Perfil"
                var tabContent = document.getElementById('profile-edit');
                if (tabContent) {
                    tabContent.classList.add('show', 'active');
                }
            }
        }
    });
</script>


</body>

</html>