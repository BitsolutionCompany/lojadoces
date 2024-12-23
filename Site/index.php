<?php
    require_once '../Conection/Conexao.php';
    session_start();

    if (isset($_SESSION['user'])) {
        // Aqui você pode acessar o nome de usuário
        $username = $_SESSION['user']['name'];
        $email = $_SESSION['user']['email'];
        $code = $_SESSION['user']['code'];

        $n = $username;
        $a = explode(' ', $n);
        $p1 = array_shift($a);
        $p2 = array_pop($a);
        $nome = $p1.' '.$p2;
    }
    
    
function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    
    return $protocol . $host . $uri;
}

// Uso da função
$currentUrl = getCurrentUrl();
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!-- JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> -->
    <script src="js/mobile-menu.js" defer></script>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="images/logo2.png" alt="logo empresa" class="logo">
            </div>
            <nav class="mobile-menu">
                <label for="menu-mobile">
                    <input type="checkbox" id="menu-mobile" class="mobile-menu1">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <div class="modal">
                    <ul class="list-menu-mobile">
                        <div class="center">
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
                            <div class="login-user">
                            <?php
                                if (isset($_SESSION['user'])) {
                            ?>
                            <a href="configuracoes.php?code=<?php echo $code; ?>">
                                <li>
                                    Configurações
                                </li>
                            </a>
                            <a href="functions/logout.php?continue=<?php echo $currentUrl ?>">
                                <li>
                                    Sair
                                </li>
                            </a>
                            <?php
                                }else{
                            ?>
                            <a href="login.php?continue=<?php echo $currentUrl ?>">
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
                            </div>
                        </div>
                    </ul>
                </div>
            </nav>
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
                ?>
                <li id="subm">       
                    <label for="submenu-toggle">
                        <?php echo $nome; ?>
                    </label>
                    <ul class="submenu">
                        <li><a href="editar_perfil.php">Editar Perfil</a></li>
                        <li><a href="configuracoes.php">Configurações</a></li>
                        <li><a href="functions/logout.php?continue=<?php echo $currentUrl ?>">Sair</a></li>
                    </ul>
                </li>
                <a href="configuracao.php?code=<?php echo $code; ?></a>">
                    <li>
                        Configurações
                    </li>
                </a>
                <?php
                    }else{
                ?>
                <a href="login.php?continue=<?php echo $currentUrl ?>">
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