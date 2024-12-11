<?php
    require_once '../Conection/Conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Incluindo jQuery -->
    <script>
        function formatInput() {
            const input = document.getElementById('username');
            const value = input.value;

            // Remove caracteres não numéricos para o CPF
            const onlyNumbers = value.replace(/\D/g, '');

            if (onlyNumbers.length === 11) {
                // Aplica a máscara do CPF
                input.value = onlyNumbers.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else if (onlyNumbers.length > 5) {
                // Se tiver mais de 5 dígitos, assume que é CPF e aplica a máscara
                if (onlyNumbers.length <= 11) {
                    input.value = onlyNumbers.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                } else {
                    // Limita a entrada a 11 dígitos (sem máscara)
                    input.value = onlyNumbers.substring(0, 11).replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                }
            } else {
                // Se for email ou código de usuário, apenas mantém o valor
                input.value = value;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Bem-vindo ao Sistema</h1>
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
                        <input type="text" id="username" name="username" required placeholder="Codigo, email ou cpf" oninput="formatInput(this)" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" required placeholder="Senha" autocomplete="off">
                    </div>
                    <button type="submit" id="login">Entrar</button>
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
                            window.location.href = res.redirect;
                        }
                    },
                    error: function(xhr, status, error) {
                        // Exibe uma mensagem de erro genérica
                        $('#message').html('<p>Erro ao processar a solicitação. Por favor, tente novamente.</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>