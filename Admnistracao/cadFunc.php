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
    <title>Cadastro de Produtos</title>
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
            <h1>Bem-vindo, <?php echo htmlspecialchars($name); ?>!</h1>
            <a href="functions/logout.php">Sair</a>
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
                        <label for="cargo">Cargo:</label>
                        <input type="text" id="cargo" name="cargo" required>
                    </div>
                    <div class="form-group">
                        <label for="admissao">Data de Admissão:</label>
                        <input type="text" id="admissao" name="admissao" required maxlength="10">
                    </div>
                    <div id="message1"></div>
                    <br>
                    <button type="submit" id="cadAdm">Cadastrar Funcionario</button>
                </form>
            </section>
        </main>
        <footer class="footer">
            <p>&copy; <?php echo date("Y"); ?> Tudo da Terra. Todos os direitos reservados.</p>
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
            $('#cep').on('input', function() {
                let valor = $(this).val().replace(/\D/g, '');
                if (valor.length > 5) {
                    valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
                }
                $(this).val(valor);
            });
            $('#cep').on('input', function() {
                let cep = $(this).val().replace(/\D/g, '');

                if (cep.length === 8){
                    $.ajax({
                        type: 'GET',
                        url: `https://viacep.com.br/ws/${cep}/json/`,
                        dataType: 'json',
                        success: function(data) {
                            if (data.erro) {
                                $('#message').html('CEP não encontrado');
                                $('#cidade').val('');
                                $('#estado').val('');
                            } else {
                                $('#message').html('');
                                $('#cidade').val(data.localidade);
                                $('#estado').val(data.uf);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao preencher cidade e estado:', error);
                        }
                    });
                }else{
                    $('#message').html('');
                    $('#cidade').val('');
                    $('#estado').val('');
                }
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
            $('#admissao').on('input', function() {
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
            $('#registerForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário

                $.ajax({
                    type: 'POST',
                    url: 'functions/cadFunc.php', // URL do seu script PHP
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
                        alert(error)
                        $('#message1').html('Erro ao cadastrar Funcionário.');
                    }
                });
            });
        });
    </script>
</body>
</html>