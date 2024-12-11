<?php
    require_once '../Conection/Conexao.php';

    if (isset($_SESSION['user'])) {
        // Aqui você pode acessar o nome de usuário
        $username = $_SESSION['user']['name'];
        $email = $_SESSION['user']['email'];
    } 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flores da Terra - HOMEPAGE</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!-- CSS -->
     <link rel="stylesheet" href="css/style.css">
     <!-- JS -->
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="images/logo2.png" alt="logo empresa" class="logo">
            </div>
        </header>
        <nav class="navbar">
            <ul class="list-menu1">
                <a href="index.php" class="active">
                    <li>
                        Home
                    </li>
                </a>
                <a href="produtos.php">
                    <li>
                        Produtos
                    </li>
                </a>
                <a href="favoritos.php">
                    <li>
                        Favoritos
                    </li>
                </a>
                <a href="sejarevenda.php">
                    <li>
                        Seja Revenda
                    </li>
                </a>
                <a href="sejafranqueado.php">
                    <li>
                        Seja Franqueado
                    </li>
                </a>
            </ul>
            <ul class="list-menu2">
                <?php
                    if (isset($_SESSION['user'])) {
                    // Aqui você pode acessar o nome de usuário
                        $username = $_SESSION['user']['name'];
                        $email = $_SESSION['user']['email'];
                ?>
                <?php
                    }else{
                ?>
                <a href="login.php">
                    <li>
                        Entrar
                    </li>
                </a>
                <a href="registro.php">
                    <li>
                        Cadastro
                    </li>
                </a>
                <?php
                    }
                ?>
                
            </ul>
        </nav>
        <main class="main">
            <section class="section3"></section>
        </main>
        <footer class="footer">
            <p>
                &copy; <script>const dataAtual = new Date(); const anoAtual = dataAtual.getFullYear(); document.write(anoAtual)</script> Flores da Terra. Todos os direitos reservados.
            </p>
        </footer>
    </div>
</body>
</html>