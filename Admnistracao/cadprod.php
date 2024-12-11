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
                <h3>Cadastro de Produtos</h3>
                <hr>
                <br>
                <form id="registerForm" method="POST" action="functions/cadprod.php" autocomplete="off">
                    <div class="form-group">
                        <label for="barcode">Codigo de Barras:</label>
                        <input type="text" id="barcode" name="barcode" required>
                        <!-- <span id="error-message" style="color: red; display: none;">Por favor, insira apenas números.</span> -->
                    </div>
                    <div class="form-group">
                        <label for="produto">Produto:</label>
                        <input type="text" id="produto" name="produto" required>
                    </div>
                    <div class="form-group">
                        <label for="priceV">Preço Varejo:</label>
                        <input type="text" id="priceV" name="priceV" required >
                    </div>
                    <div class="form-group">
                        <label for="priceA">Preço Atacado:</label>
                        <input type="text" id="priceA" name="priceA" required>
                    </div>
                    <div class="form-group">
                        <label for="estoque">Estoque:</label>
                        <input type="text" id="estoque" name="estoque" required>
                        <div id="message"></div>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria:</label>
                        <input type="text" id="categoria" name="categoria" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea name="descricao" id="descricao" required></textarea>
                    </div>
                    <div id="message1"></div>
                    <br>
                    <button type="submit" id="cadAdm">Cadastrar Administrador</button>
                </form>
            </section>
        </main>
        <footer class="footer">
            <p>&copy; <?php echo date("Y"); ?> Tudo da Terra. Todos os direitos reservados.</p>
        </footer>
    </div>
    <script>
        const barcodeInput = document.getElementById('barcode');
        const estoque = document.getElementById('estoque');
        // const errorMessage = document.getElementById('error-message');

        barcodeInput.addEventListener('input', function() {
            // Remove caracteres não numéricos
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        estoque.addEventListener('input', function() {
            // Remove caracteres não numéricos
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $(document).ready(function() {
            $('#registerForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário

                $.ajax({
                    type: 'POST',
                    url: 'functions/cadProd.php', // URL do seu script PHP
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
                        $('#message1').html('Erro ao cadastrar produto.');
                    }
                });
            });
        })

        const priceInput = document.getElementById('priceV');
        const priceInputA = document.getElementById('priceA');

        priceInput.addEventListener('input', function() {
            // Remove todos os caracteres que não são dígitos
            let value = this.value.replace(/\D/g, '');

            // Adiciona a máscara de preço
            value = (value / 100).toFixed(2).replace('.', ',');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            this.value = value;
        });
        priceInputA.addEventListener('input', function() {
            // Remove todos os caracteres que não são dígitos
            let value = this.value.replace(/\D/g, '');

            // Adiciona a máscara de preço
            value = (value / 100).toFixed(2).replace('.', ',');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            this.value = value;
        });
    </script>
</body>
</html>