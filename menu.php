<?php
require_once("verificaAutenticacao.php");
require_once('conexao.php');
$admin_name = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Nome Padrão'; // Corrigido de $_SESSION['admin_name'] para $_SESSION['nome']
$admin_role = isset($_SESSION['email']) ? $_SESSION['email'] : 'Email Padrão'; // Corrigido de $_SESSION['admin_role'] para $_SESSION['email']

?>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center">
        <img src="assets/img/halter.png" alt="">
        <span class="d-none d-lg-block">FitConnect</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!--<img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">-->
            <span class="d-none d-md-block dropdown-toggle ps-2">
              <?php echo $admin_name; ?>
            </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>
                <?php echo $admin_name; ?>
              </h6>
              <span>
                <?php echo $admin_role; ?>
              </span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="sair.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sair</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="home.php">
          <i class="bi bi-grid"></i>
          <span>Início</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Gerenciamentos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="listarAluno.php">
              <i class="bi bi-circle"></i><span>Alunos</span>
            </a>
          </li>
          <li>
            <a href="listarGrupoMuscular.php">
              <i class="bi bi-circle"></i><span>Grupos Musculares</span>
            </a>
          </li>
          <li>
            <a href="listarFichaTreino.php">
              <i class="bi bi-circle"></i><span>Treinos</span>
            </a>
          </li>
          <li>
            <a href="listarExercicio.php">
              <i class="bi bi-circle"></i><span>Exercícios</span>
            </a>
          </li>
          <li>
            <a href="listarPersonal.php">
              <i class="bi bi-circle"></i><span>Personais</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Novo Treino</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="planoTreinoAluno.php">
              <i class="bi bi-circle"></i><span>Criar Plano de Treino para Aluno</span>
            </a>
          </li>
          <li>
            <a href="planoTreino.php">
              <i class="bi bi-circle"></i><span>Criar Plano de Treino Modelo</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Meus Planos de Treino</span><i
            class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="listarFichaTreino.php">
              <i class="bi bi-circle"></i><span>Planos de Treino Encaminhados</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Planos de Treino Criados</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-fill"></i><span>Alunos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="cadAluno.php">
              <i class="bi bi-person-plus-fill"></i><span>Cadastrar Novo Aluno</span>
            </a>
          </li>
          <li>
            <a href="listarAluno.php">
              <i class="bi bi-person-lines-fill"></i><span>Meus Alunos</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contatos</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="registro2.php">
          <i class="bi bi-card-list"></i>
          <span>Cadastro Simples</span>
        </a>
      </li><!-- End Register Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->
</body>

</html>