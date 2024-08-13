<?php
//Faz logout do sistema

//Destrói as variáveis de sessão
session_start();
session_unset();
session_destroy();
//Redireciona para o login
header("location: index.php");

?>