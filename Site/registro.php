<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
            <h1 class="loginh1">Cadastro</h1>
        </header>
        <main class="main">
            <section class="section width-600px">
                <h3>Cadastro de Funcionarios</h3>
                <hr>
                <br>
                <form id="registerForm" method="POST" action="functions/cadFunc.php" autocomplete="off">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>
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
                        <label for="phone">Telefone:</label>
                        <input type="text" id="phone" name="phone" required placeholder="(XX) XXXXX-XXXX" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmemail">Confirmar Email:</label>
                        <input type="email" id="confirmemail" name="confirmemail" required>
                    </div>
                    <div class="form-group">
                        <label for="pass">Senha:</label>
                        <input type="password" id="pass" name="pass" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmpass">Confirmar Senha:</label>
                        <input type="password" id="confirmpass" name="confirmpass" required>
                    </div>
                    <div id="message1"></div>
                    <br>
                    <button type="submit" id="cadUser">Cadastrar</button>
                </form>
            </section>
        </main>
        <footer class="footer">
            <p>
                &copy; <script>const dataAtual = new Date(); const anoAtual = dataAtual.getFullYear(); document.write(anoAtual)</script> Flores da Terra. Todos os direitos reservados.
            </p>
        </footer>
    </div>
    <script>
        $(document).ready(function() {
            $('#cpf').on('input', function() {
                let valor = $(this).val().replace(/\D/g, '');
                valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
                valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
                valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                $(this).val(valor);
            });
            $('#birthdate').on('input', function() {
                let valor = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
            
                if (valor.length > 2 && valor.length <= 4) {
                    valor = valor.replace(/(\d{2})(\d{2})/, '$1/$2'); // Adiciona a primeira barra após os dois primeiros dígitos
                } else if (valor.length > 4) {
                    valor = valor.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3'); // Adiciona a segunda barra após os próximos dois dígitos
                }
            
                // Limita a entrada a 10 caracteres
                if (valor.length > 10) {
                    valor = valor.substring(0, 10);
                }
            
                $(this).val(valor); // Atualiza o valor do campo de entrada
            });
            $('#phone').on('input', function() {
                let value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos

                if (value.length > 10) {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3'); // Formato (XX) XXXXX-XXXX
                } else if (value.length > 6) {
                    value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3'); // Formato (XX) XXXXX-XXXX
                } else if (value.length > 2) {
                    value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2'); // Formato (XX) XXXXX
                } else if (value.length > 0) {
                    value = value.replace(/(\d{0,2})/, '($1'); // Formato (XX
                }

                $(this).val(value);
            });
            $('#registerForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário

                $.ajax({
                    type: 'POST',
                    url: 'functions/registro.php', // URL do seu script PHP
                    data: $(this).serialize(), // Serializa os dados do formulário
                    success: function(response) {
                        const res = JSON.parse(response); // Analisa a resposta JSON
                        $('#message1').html(res.message); // Exibe a mensagem apropriada

                        if (res.status === 'success') {
                            // Redireciona para a página de produtos
                            window.location.href = res.redirect;
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr)
                        alert(status)
                        alert(error)
                        $('#message1').html('Erro ao cadastrar Usuário.');
                    }
                });
            });
        });
    </script>
</body>
</html>