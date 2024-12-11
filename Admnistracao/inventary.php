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
    <title>Inventário</title>
     <!-- seção de css -->
     <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!-- Seção de js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .section2 {
            padding: 20px;
            background-color: #f9f9f9;
        }
        div.warning{
            padding: 10px;
            border: solid 2px orange;
            margin: 0;
            border-radius: 10px;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px; /* Espaçamento entre as linhas */
            margin-bottom: 1rem;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #343a40;
            color: #ffffff;
            position: sticky;
            top: 0;
        }
        tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        tbody td {
            position: relative;
        }
        tbody td:before {
            content: attr(data-title);
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: bold;
            color: #6c757d;
            display: none;
        }
        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                display: none; 
            }
            tbody td {
                padding-left: 50%;
                text-align: right;
            }
            tbody td:before {
                display: block;
            }
        }
        @media screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none; 
            }
            tbody td {
                padding-left: 50%;
                text-align: right;
            }
            tbody td:before {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="button_cad">
        <a href="cadprod.php">
            <button>
            <i class="material-symbols-outlined">
                add
            </i>
            </button>
        </a>
    </div>
    <div class="container">
        <header class="header">
            <h1>Bem-vindo, <?php echo htmlspecialchars($name); ?>!</h1>
            <a href="functions/logout.php">Sair</a>
        </header>
        <main class="main">
            <section class="section2">
                <?php
                    $stmt = $conn->prepare("SELECT * FROM produtos");
                    $stmt->execute();

                    if($stmt->rowCount() > 0):
                ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                <th>Código do Produto</th>
                                <th>Código de Barras</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço Varejo</th>
                                <th>Preço Atacado</th>
                                <th>Estoque</th>
                                <th>Categoria</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($produtos as $prod => $pd) {
                            ?>
                                <tr>
                                    <td data-title="Código do Produto"><?php echo $pd['codProd']?></td>
                                    <td data-title="Código de Barras"><?php echo $pd['barcode']?></td>
                                    <td data-title="Nome"><?php echo $pd['nome']?></td>
                                    <td data-title="Descrição"><?php echo $pd['descricao']?></td>
                                    <td data-title="Preço Varejo">R$ <?php echo str_replace(".", ",", $pd['precoVarejo'])?></td>
                                    <td data-title="Preço Atacado">R$ <?php echo str_replace(".", ",", $pd['precoAtacado'])?></td>
                                    <td data-title="Estoque"><?php echo $pd['estoque']?></td>
                                    <td data-title="Categoria"><?php echo $pd['categoria']?></td>
                                </tr>
                                <br>
                            <?php
                                } 
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="warning">
                        <h3>Nenhum Produto Registrado</h3>
                    </div>
                <?php endif; ?>
            </section>
        </main>
        <footer class="footer">
            <p>&copy; <?php echo date("Y"); ?> Tudo da Terra. Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>