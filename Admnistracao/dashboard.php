<?php
// homepage
require_once "../Conection/Conexao.php";
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}else if (isset($_SESSION['user'])) {
    // Aqui você pode acessar o nome de usuário
    $username = $_SESSION['user']['name'];
    $email = $_SESSION['user']['email'];
}
$n = explode(' ', $username);
$n2 = array_pop($n);
$n1 = array_shift($n);

$name = $n1." ".$n2;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if ($username === "biacosmetico"): ?>
            Cadastro de Administrador
        <?php else: ?>
            Dashboard
        <?php endif; ?>
    </title>
    <!-- seção de css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!-- Seção de js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Bem-vindo, <?php echo htmlspecialchars($name); ?>!</h1>
            <a href="functions/logout.php">Sair</a>
        </header>
        <main class="main">
            <?php if ($username === "biacosmetico"): ?>
                <section class="section width-600px">
                    <h3>Cadastro de Administrador</h3>
                    <hr>
                    <br>
                    <form id="registerForm" method="POST" action="functions/register.php" autocomplete="off">
                        <div class="form-group">
                            <label for="newAdminName">Nome:</label>
                            <input type="text" id="newAdminName" name="newAdminName" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gênero:</label>
                            <input type="text" id="gender" name="gender" required>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Data de Nascimento:</label>
                            <input type="text" id="birthdate" name="birthdate" required maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF:</label>
                            <input type="text" id="cpf" name="cpf" required maxlength="14">
                        </div>
                        <div class="form-group">
                            <label for="cep">CEP:</label>
                            <input type="text" id="cep" name="cep" required maxlength="9">
                            <div id="message"></div>
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" readonly>
                        </div>
                        <div class="form-group">
                            <label for="logradouro">logradouro:</label>
                            <input type="text" id="logradouro" name="logradouro" required>
                        </div>
                        <div class="form-group">
                            <label for="number">Número:</label>
                            <input type="text" id="number" name="number" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <input type="text" id="estado" name="estado" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="newAdminPassword">Senha:</label>
                            <input type="password" id="newAdminPassword" name="newAdminPassword" required>
                        </div>
                        <div id="message1"></div>
                        <button type="submit" id="cadAdm">Cadastrar Administrador</button>
                    </form>
                </section>
            <?php else: ?>
                <section class="section1">
                    <ul class="list-functions">
                        <a href="inventary.php">
                            <li>
                                <div class="icon">
                                <i class="material-symbols-outlined">
                                    inventory_2
                                </i>
                                </div>
                                <h2>
                                    Produtos
                                </h2>
                            </li>
                        </a>
                        <a href="cadprod.php">
                            <li>
                                <div class="icon">
                                <i class="material-symbols-outlined">
                                    box_add
                                </i>
                                </div>
                                <h2 style="text-align: center;">
                                    Cadastro de Produtos
                                </h2>
                            </li>
                        </a>
                        <a href="funcionarios.php">
                            <li>
                                <div class="icon">
                                <i class="material-symbols-outlined">
                                    person
                                </i>
                                </div>
                                <h2 style="text-align: center;">
                                    Funcionários
                                </h2>
                            </li>
                        </a>
                        <a href="cadFunc.php">
                            <li>
                                <div class="icon">
                                <i class="material-symbols-outlined">
                                    person_add
                                </i>
                                </div>
                                <h2 style="text-align: center;">
                                    Cadastro de Funcionários
                                </h2>
                            </li>
                        </a>
                    </ul>
                </section>
            <?php endif;?>
        </main>
        <footer class="footer">
            <p>&copy; <?php echo date("Y"); ?> Tudo da Terra. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>