<?php
require_once('verificaAutenticacao.php');
require_once('conexao.php');

//Permite o acesso somente se o usuário logado na sessão for admin
if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') {
  // Redirecionar para uma página de acesso negado ou qualquer outra página desejada
  header("Location: acessoNegado.php"); // Substitua "acessoNegado.php" pelo caminho da sua página de acesso negado
  exit();
}

//Listar Personais
//Exclusão
if(isset($_GET['id'])) {
  $sql = "delete from personal where id = ".$_GET['id'];
  mysqli_query($conexao, $sql);
  $mensagem = "Exclusão realizada com sucesso.";
}
// preparar a SQL
$sql = "select * from personal";
//Executar a SQL
$resultados = mysqli_query($conexao, $sql);



// Realizar a consulta para obter a quantidade de IDs na tabela aluno
$sqlAluno = "SELECT COUNT(id) as total FROM aluno";
$result = $conexao->query($sqlAluno);

if($result->num_rows > 0) {
  // Retorna a quantidade de IDs
  $row = $result->fetch_assoc();
  $quantidadeIds = $row['total'];
}

// Realizar a consulta para obter a quantidade de IDs na tabela ficha_treino
$sqlTreinos = "SELECT COUNT(id) as total2 FROM ficha_treino";
$resulta = $conexao->query($sqlTreinos);

if($resulta->num_rows > 0) {
  // Retorna a quantidade de IDs
  $row = $resulta->fetch_assoc();
  $quantidadeIdsTreino = $row['total2'];
}

// Realizar a consulta para obter a quantidade de IDs na tabela personal
$sqlPersonais = "SELECT COUNT(id) as total3 FROM personal";
$resultad = $conexao->query($sqlPersonais);

if($resultad->num_rows > 0) {
  // Retorna a quantidade de IDs
  $row = $resultad->fetch_assoc();
  $quantidadeIdsPersonais = $row['total3'];
}


//Listagem de ficha treino
//Exclusão
if(isset($_GET['id'])) {
  $sql = "delete from ficha_treino where id = ".$_GET['id'];
  mysqli_query($conexao, $sql);
  $mensagem = "Exclusão realizada com sucesso.";
}
// preparar a SQL
$sqlFicha = "select * from ficha_treino";
// Preparar a SQL com JOIN para buscar o nome do aluno na tabela aluno e o nome do personal na tabela personal
$sqlFicha = "SELECT ft.*, a.nome AS nome_aluno, p.nome AS nome_personal
      FROM ficha_treino ft
      JOIN aluno a ON ft.aluno_id = a.id
      JOIN personal p ON ft.personal_id = p.id";
//Executar a SQL
$resultados1 = mysqli_query($conexao, $sqlFicha);


//Gráfico de Relatórios
$dataAtual = date('Y-m-d');
$dataCincoDiasAtras = date('Y-m-d', strtotime('-5 days'));




// Consultar personais, alunos e ficha_treino criados nos últimos 5 dias
$sqlPersonais1 = "SELECT COUNT(id) as total4 FROM personal WHERE DATE(dataCadastro) BETWEEN '$dataCincoDiasAtras' AND '$dataAtual'";
$sqlAlunos1 = "SELECT COUNT(id) as total5 FROM aluno WHERE DATE(dataCadastro) BETWEEN '$dataCincoDiasAtras' AND '$dataAtual'";
$sqlFichaTreino1 = "SELECT COUNT(id) as total6 FROM ficha_treino WHERE DATE(dataCadastro) BETWEEN '$dataCincoDiasAtras' AND '$dataAtual'";

$resultPersonais = mysqli_query($conexao, $sqlPersonais1);
$resultAlunos = mysqli_query($conexao, $sqlAlunos1);
$resultFichaTreino = mysqli_query($conexao, $sqlFichaTreino1);

// Extrair os resultados das consultas
$rowPersonais = $resultPersonais->fetch_assoc();
$rowAlunos = $resultAlunos->fetch_assoc();
$rowFichaTreino = $resultFichaTreino->fetch_assoc();

// Montar o array de dados para o gráfico
$dataTreinos = $rowFichaTreino['total6'];
$dataPersonais = $rowPersonais['total4'];
$dataAlunos = $rowAlunos['total5'];

// Montar o array para o gráfico de datas
$categories = [];
$end_date = new DateTime($dataAtual);
while ($end_date >= new DateTime($dataCincoDiasAtras)) {
    $categories[] = $end_date->format('Y-m-d'); // Inclui a parte do horário
    $end_date->modify('-1 day');
}
$categories = array_reverse($categories);

// Consultar personais, alunos e ficha_treino criados nos últimos 5 dias
$sqlPersonais1 = "SELECT COUNT(id) as total4 FROM personal WHERE dataCadastro BETWEEN '$dataCincoDiasAtras' AND '$dataAtual'";
$sqlAlunos1 = "SELECT COUNT(id) as total5 FROM aluno WHERE dataCadastro BETWEEN '$dataCincoDiasAtras' AND '$dataAtual'";
$sqlFichaTreino1 = "SELECT COUNT(id) as total6 FROM ficha_treino WHERE dataCadastro BETWEEN '$dataCincoDiasAtras' AND '$dataAtual'";

$resultPersonais = mysqli_query($conexao, $sqlPersonais1);
$resultAlunos = mysqli_query($conexao, $sqlAlunos1);
$resultFichaTreino = mysqli_query($conexao, $sqlFichaTreino1);

// Extrair os resultados das consultas
$rowPersonais = $resultPersonais->fetch_assoc();
$rowAlunos = $resultAlunos->fetch_assoc();
$rowFichaTreino = $resultFichaTreino->fetch_assoc();

// Montar o array de dados para o gráfico
$dataTreinos = [];
$dataPersonais = [];
$dataAlunos = [];

foreach ($categories as $categoria) {
    // Inicializa com 0
    $dataTreinos[] = 0;
    $dataPersonais[] = 0;
    $dataAlunos[] = 0;

    // Compara as datas sem considerar a parte do horário
    if (date('Y-m-d', strtotime($categoria)) === date('Y-m-d', strtotime($dataAtual))) {
        $dataTreinos[] = $rowFichaTreino['total6'];
        $dataPersonais[] = $rowPersonais['total4'];
        $dataAlunos[] = $rowAlunos['total5'];
    }
}

// Saída em formato JSON para ser utilizada no script do gráfico
$output = [
    'series' => [
        [
            'name' => 'Treinos',
            'data' => $dataTreinos,
        ],
        [
            'name' => 'Personais',
            'data' => $dataPersonais,
        ],
        [
            'name' => 'Alunos',
            'data' => $dataAlunos,
        ],
    ],
    'chart' => [
        'height' => 350,
        'type' => 'area',
        'toolbar' => [
            'show' => false,
        ],
    ],
    'markers' => [
        'size' => 4,
    ],
    'colors' => ['#4154f1', '#2eca6a', '#ff771d'],
    'fill' => [
        'type' => "gradient",
        'gradient' => [
            'shadeIntensity' => 1,
            'opacityFrom' => 0.3,
            'opacityTo' => 0.4,
            'stops' => [0, 90, 100],
        ],
    ],
    'dataLabels' => [
        'enabled' => false,
    ],
    'stroke' => [
        'curve' => 'smooth',
        'width' => 2,
    ],
    'xaxis' => [
        'type' => 'datetime',
        'categories' => $categories,
    ],
    'tooltip' => [
        'x' => [
            'format' => 'dd/MM/yy',
        ],
    ],
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Home - FitConnect</title>
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
  <?php require_once('menu.php'); ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Painel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
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
                  <h5 class="card-title">Treinos <span>| Atual</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php echo $quantidadeIdsTreino ?>
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
                  <h5 class="card-title">Personais <span>| Atual</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person-check"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php echo $quantidadeIdsPersonais ?>
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
                  <h5 class="card-title">Alunos <span>| Atual</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php echo $quantidadeIds ?>
                      </h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Relatórios -->
            <div class="col-12">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Relatórios <span>/5 dias atrás - Hoje</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {

                      // Substitua esta parte com o script PHP que gera o JSON dinâmico
                      var jsonData = <?php echo json_encode($output); ?>;

                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: jsonData.series,
                        chart: jsonData.chart,
                        markers: jsonData.markers,
                        colors: jsonData.colors,
                        fill: jsonData.fill,
                        dataLabels: jsonData.dataLabels,
                        stroke: jsonData.stroke,
                        xaxis: jsonData.xaxis,
                        tooltip: jsonData.tooltip,
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Relatórios -->

            <div class="col-lg-12">

              <div class="card">
                <div class="card-body">
                  <div class="card mt-4 mb-4">
                    <div class="card-body">
                      <h2 class="card-title">Lista de Personais
                        <a href="cadPersonal.php" class="btn btn-primary btn-sn">
                          <i class="fa-solid fa-plus"></i>
                        </a>
                      </h2>
                    </div>



                    <!-- Table with stripped rows -->
                    <div style="overflow-x: auto">
                      <table class="table datatable">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">CREF</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Data de Cadastro</th>
                            <th scope="col">Ações</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while($linha = mysqli_fetch_array($resultados)) { ?>
                            <tr>
                              <td>
                                <?= $linha['id'] ?>
                              </td>
                              <td>
                                <?= $linha['nome'] ?>
                              </td>
                              <td>
                                <?= $linha['email'] ?>
                              </td>
                              <td>
                                <?= $linha['cref'] ?>
                              </td>
                              <td>
                                <?= $linha['telefone'] ?>
                              </td>
                              <td>
                                <?= $linha['cidade'] ?>
                              </td>
                              <td>
                                <?= $linha['dataCadastro'] ?>
                              </td>
                              <td>
                                <a href="alterarPersonal.php?id=<?= $linha['id'] ?>" class="btn btn-warning">
                                  <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="home.php?id=<?= $linha['id'] ?>" class="btn btn-danger"
                                  onclick="return confirm('Confirma exclusão?')">
                                  <i class="fa-solid fa-trash-can"></i>
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

            <div class="col-lg-12">

              <div class="card">
                <div class="card-body">
                  <div class="card mt-4 mb-4">
                    <div class="card-body">
                      <h2 class="card-title">Fichas de Treino
                        <a href="planoTreinoAluno.php" class="btn btn-primary btn-sn">
                          <i class="fa-solid fa-plus"></i>
                        </a>
                      </h2>
                    </div>

                    <!-- Table with stripped rows -->
                    <div style="overflow-x: auto">
                      <table class="table datatable">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Aluno</th>
                            <th scope="col">Personal</th>
                            <th scope="col">Número de Treinos</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Data de Cadastro</th>
                            <th scope="col">Ações</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while($linha2 = mysqli_fetch_array($resultados1)) { ?>
                            <tr>
                              <td>
                                <?= $linha2['id'] ?>
                              </td>
                              <td>
                                <?= $linha2['nome'] ?>
                              </td>
                              <td>
                                <?= $linha2['nome_aluno'] ?>
                              </td>
                              <td>
                                <?= $linha2['nome_personal'] ?>
                              </td>
                              <td>
                                <?= $linha2['num_treinos'] ?>
                              </td>
                              <td>
                                <?= $linha2['descricao'] ?>
                              </td>
                              <td>
                                <?php
                                // Formatação da data
                                $dataCadastro = new DateTime($linha2['dataCadastro']);
                                echo $dataCadastro->format('d/m/Y H:i:s');
                                ?>
                              </td>
                              <td>
                                <a href="mostrarFichaTreino.php?id=<?= $linha2['id'] ?>" class="btn btn-primary">
                                  <i class="bi bi-arrow-up-right-square"></i>
                                </a>
                                <a href="home.php?id=<?= $linha2['id'] ?>" class="btn btn-danger"
                                  onclick="return confirm('Confirma exclusão?')">
                                  <i class="fa-solid fa-trash-can"></i>
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

          <!-- News & Updates Traffic -->
          <div class="card">

            <div class="card-body pb-0">
              <h5 class="card-title">Notícias &amp; Atualizações <span>| Hoje</span></h5>

              <div class="news">
                <h8>Nenhuma Notícia Disponível</h8>
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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>