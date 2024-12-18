<?php
$url = isset($_GET['continue']) ? $_GET['continue'] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <!-- seção de css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!-- Seção de js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
<div class="container">
        <header class="header">
            <h1 class="loginh1">Tela de Login</h1>
        </header>
        <main class="main">
            <section class="section">
                <h2>Login</h2>
                <hr><br>
                <form id="loginForm" method="POST" autocomplete="off">
                    <input type="text" style="display:none">
                    <input type="password" style="display:none">
                    <div class="form-group">
                        <label for="username">Usuário:</label>
                        <input type="text" id="username" name="username" required placeholder="Email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" required placeholder="Senha" autocomplete="off">
                    </div>
                    <button type="submit" id="login">Entrar</button>
                    <div class="link">
                        <a href="registro.php">Cadastro</a>
                    </div>
                    <div id="message"></div>
                </form>
            </section>
        </main>
        <footer class="footer">
            <p>
                &copy; <script>const dataAtual = new Date(); const anoAtual = dataAtual.getFullYear(); document.write(anoAtual)</script> Tudo da Terra. Todos os direitos reservados.
            </p>
        </footer>
    </div>
    <script>
        $(document).ready(function() {
            
            var continueUrl = "<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>";

            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio normal do formulário

                $.ajax({
                    url: 'functions/login.php',
                    type: 'POST',
                    data: $(this).serialize(), // Serializa os dados do formulário
                    success: function(response) {
                        const res = JSON.parse(response); // Analisa a resposta JSON
                        $('#message').html(res.message); // Exibe a mensagem apropriada

                        if (res.status === 'success') {
                            // Redireciona para a página de dashboard
                            window.location.href = continueUrl || 'login.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr)
                        alert(status)
                        alert(error)
                        // Exibe uma mensagem de erro genérica
                        $('#message').html('<p>Erro ao processar a solicitação. Por favor, tente novamente.</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>