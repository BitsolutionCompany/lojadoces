<?php
session_start(); // Inicia a sessão

// Destrói todas as variáveis de sessão
$_SESSION = array(); // Limpa a sessão

// Se você deseja destruir a sessão completamente, também pode usar:
session_destroy(); // Destrói a sessão

// Redireciona para a página de login
header("Location: ../index.php");
exit(); // Certifique-se de sair após o redirecionamento
?>