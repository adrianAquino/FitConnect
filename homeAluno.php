<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 'aluno' && $_SESSION['perfil'] != 'admin')) {
  // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
  header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
  exit();
}

// Realizar a consulta para obter a quantidade de IDs na tabela personal
$sqlPersonais = "SELECT COUNT(id) as total3 FROM personal";
$resultad = $conexao->query($sqlPersonais);

if ($resultad->num_rows > 0) {
  // Retorna a quantidade de IDs
  $row = $resultad->fetch_assoc();
  $quantidadeIdsPersonais = $row['total3'];
}

// Realizar a consulta para obter a quantidade de IDs na tabela exercicio
$sqlExercicio = "SELECT COUNT(id) as total FROM exercicio";
$result = $conexao->query($sqlExercicio);

if ($result->num_rows > 0) {
  // Retorna a quantidade de IDs
  $row = $result->fetch_assoc();
  $quantidadeIdsExercicio = $row['total'];
}


// Obter o ID do aluno logado
$idAlunoLogado = $_SESSION['id'];


// Realizar a consulta para obter a quantidade de IDs na tabela ficha_treino
// Considerando apenas os registros relacionados ao aluno logado
$sqlFichaAluno = "SELECT COUNT(id) as total4 FROM ficha_treino WHERE aluno_id = ?";

// Use prepared statements para evitar injeção de SQL
$stmt = $conexao->prepare($sqlFichaAluno);

// Vincule o parâmetro ID do aluno logado
$stmt->bind_param("i", $idAlunoLogado);

// Execute a consulta
$stmt->execute();

// Obtenha o resultado
$resultad = $stmt->get_result();

if ($resultad->num_rows > 0) {
  // Retorna a quantidade de IDs
  $row = $resultad->fetch_assoc();
  $quantidadeIdsFichaAluno = $row['total4'];
} else {
  $quantidadeIdsFichaAluno = 0; // Define como 0 se não houver registros
}
// Feche o statement após o uso
$stmt->close();



// Exclusão
if (isset($_GET['id'])) {
  $sqlDelete = "DELETE FROM ficha_treino WHERE id = ? AND aluno_id = ?";
  $stmtDelete = $conexao->prepare($sqlDelete);
  $stmtDelete->bind_param("ii", $_GET['id'], $idAlunoLogado);
  $stmtDelete->execute();
  $mensagem = "Exclusão realizada com sucesso.";
}

// mostrar a tabela ficha_treino do aluno
// Preparar a SQL com JOIN para buscar o nome do aluno na tabela aluno e o nome do personal na tabela personal
$sqlSelect = "SELECT ft.*, a.nome AS nome_aluno, p.nome AS nome_personal
              FROM ficha_treino ft
              JOIN aluno a ON ft.aluno_id = a.id
              JOIN personal p ON ft.personal_id = p.id
              WHERE ft.aluno_id = ?";
$stmtSelect = $conexao->prepare($sqlSelect);
$stmtSelect->bind_param("i", $idAlunoLogado);
$stmtSelect->execute();

$resultados = $stmtSelect->get_result();



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Home do Aluno - FitConnect</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/b56b5884c4.js" crossorigin="anonymous"></script>


  <!-- Favicons -->
  <link href="assets/img/halter.png" rel="icon">
  <link href="assets/img/halter.png" rel="apple-touch-icon">

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
  <!--<link rel="stylesheet" href="assets/css/tableFicha.css">-->
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
  <?php require_once('menuAluno.php'); ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Painel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="homeAluno.php">Home</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Minhas Fichas de Treino <span>| Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php echo $quantidadeIdsFichaAluno ?>
                      </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Exercícios <span>| A Disposição</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-bike-line"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php echo $quantidadeIdsExercicio ?>
                      </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Personais <span>| Disponíveis</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php echo $quantidadeIdsPersonais ?>
                      </h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <div class="col-lg-12">

              <div class="card">
                <div class="card-body">
                  <div class="card mt-4 mb-4">
                    <div class="card-body">
                      <h2 class="card-title">Minhas Fichas de Treino <span>| Disponíveis</span>
                      </h2>
                    </div>

                    <!-- Table with stripped rows -->
                    <div style="overflow-x: auto">
                      <table class="table datatable">
                        <thead>
                          <tr>
                            <th scope="col">Número</th>
                            <th scope="col">Nome da Ficha</th>
                            <th scope="col">Personal Responsável</th>
                            <th scope="col">Quantidade de Treinos</th>
                            <th scope="col">Criada em</th>
                            <th scope="col">Ver</th>
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
                                <?= $linha['nome_personal'] ?>
                              </td>
                              <td>
                                <?= $linha['num_treinos'] ?>
                              </td>
                              <td>
                                <?php
                                // Formatação da data
                                $dataCadastro = new DateTime($linha['dataCadastro']);
                                echo $dataCadastro->format('d/m/Y H:i:s');
                                ?>
                              </td>
                              <td>
                                <a href="mostrarFichaTreino.php?id=<?= $linha['id'] ?>" class="btn btn-primary"
                                  data-bs-toggle="tooltip" data-bs-original-title="Abrir a Ficha">
                                  <i class="bi bi-arrow-up-right-square"></i>
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
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <div class="card">

            <div class="card-body pb-0">
              <h5 class="card-title">Precisando de um Novo Treino?<span> | Fale com um personal</span></h5>

              <a href="https://wa.me/554497643857" target="_blank" aria-label="Chat on WhatsApp"><i
                  class="fa fa-whatsapp" aria-hidden="true"></i> Chat on WhatsApp
              </a>

            </div>
          </div><!-- End Chat WhatsApp -->

          <!-- News & Updates Traffic -->
          <div class="card">

            <div class="card-body pb-0">
              <h5 class="card-title">Notícias &amp; Atualizações <span>| Hoje</span></h5>

              <div class="news">
                <div class="post-item clearfix">
                  <h8>Nenhuma Notícia Disponível</h8>
                </div>

              </div><!-- End sidebar recent posts-->

            </div>
          </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

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

  <script>
    // Inicialize os tooltips do Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  </script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>