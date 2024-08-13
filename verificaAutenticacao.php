<?php
/*Verifica se o usuário está logado, para dara acesso ao sistema administrativo */

if (!isset($_SESSION)) {
    session_start();
}

//Verifica se exite um usuário logado
if (!isset($_SESSION['id'])) {
    $mensagem = "Sessão experiada. Faça o login novamente.";
    header("location: index.php?mensagem={$mensagem}");
}