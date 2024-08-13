<?php
require_once("conexao.php");


if(isset($_GET['idFichaTreino']) && isset($_GET['numeroTreino'])) {
    $idFichaTreino = $_GET['idFichaTreino'];
    $numeroTreino = $_GET['numeroTreino'];

    $sqlExercicios = "SELECT et.id AS idExercicioTreino, et.series, et.repeticoes, et.carga_velocidade, et.tempo_descanso, e.id AS idExercicio, e.nome AS nomeExercicio, e.imagem AS imagemExercicio, e.descricao AS descricaoExercicio
                      FROM exercicio_treino et
                      JOIN exercicio e ON et.exercicio_id = e.id
                      WHERE et.ficha_treino_id = $idFichaTreino AND et.treino_id = $numeroTreino";

    $resultadoExercicios = mysqli_query($conexao, $sqlExercicios);

    if($resultadoExercicios) {
        // Gera o HTML dos exercícios filtrados
        while($linhaExercicio = mysqli_fetch_array($resultadoExercicios)) {
            ?>
            <tr class="alert" role="alert">
                <td>
                    <div class="img" style="background-image: url(imagensproduto/<?= $linhaExercicio['imagemExercicio']; ?>);">
                    </div>
                </td>
                <td>
                    <div class="email">
                        <span>
                            <?php echo $linhaExercicio['nomeExercicio']; ?>
                        </span>
                        <span>
                            <?php echo $linhaExercicio['descricaoExercicio']; ?>
                        </span>
                    </div>
                </td>
                <td>
                    <?php echo $linhaExercicio['series']; ?>
                </td>
                <td>
                    <?php echo $linhaExercicio['repeticoes']; ?>
                </td>
                <td>
                    <?php echo $linhaExercicio['carga_velocidade']; ?>
                </td>
                <td>
                    <?php echo $linhaExercicio['tempo_descanso']; ?>
                </td>
                <td>
                    <a href="mostrarExercicio.php?id=<?= $linhaExercicio['idExercicio'] ?>" class="btn btn-warning"
                        data-bs-toggle="tooltip" data-bs-original-title="Ver detalhes do Exercício">
                        <i class="bi bi-arrow-up-right-square"></i>
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "Erro na consulta SQL: ".mysqli_error($conexao);
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
<script>
        // Inicialize os tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>