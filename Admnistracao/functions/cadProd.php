<?php
require '../../Conection/Conexao.php'; // Inclua o arquivo de conexão

// Cria uma nova instância da classe Database
$conn = $database->getConnection();

// Recebe dados do formulário via POST
$barcode = $_POST["barcode"];
$produto = $_POST["produto"];
$priceV = $_POST["priceV"];
$priceV = str_replace(',', '.', $priceV);
$priceA = $_POST["priceA"];
$priceA = str_replace(',', '.', $priceA);
$estoque = $_POST["estoque"];
$categoria = $_POST["categoria"];
$descricao = $_POST["descricao"];

// Verifica se todos os campos estão preenchidos
if(empty($barcode) || empty($produto) || empty($priceV) || empty($priceA) || empty($estoque) || empty($categoria) || empty($descricao)){
    echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}

// Verifica se os preços e o estoque são numéricos
// if (!is_numeric($priceV) || !is_numeric($priceA) || !is_numeric($estoque)) {
//     echo json_encode(['status' => 'error', 'message' => 'Os preços e o estoque devem ser números.']);
//     exit;
// }

// Verifica se o código de barras já existe
$sqlCheck = "SELECT COUNT(*) FROM produtos WHERE barcode = :barcode";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bindParam(':barcode', $barcode);
$stmtCheck->execute();

if ($stmtCheck->fetchColumn() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Já existe um produto cadastrado com esse código de barras.']);
    exit;
}

// Código do administrador
$ProdCode = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);

// Prepara a inserção no banco
$sql = "INSERT INTO produtos (codProd, nome, descricao, precoVarejo, precoAtacado, estoque, categoria, barcode) 
        VALUES (:code, :nome, :descricao, :precoV, :precoA, :estoque, :categoria, :barcode)";

$stmt = $conn->prepare($sql); // Prepare a instrução SQL

// Vincula os parâmetros
$stmt->bindParam(':code', $ProdCode);
$stmt->bindParam(':nome', $produto);
$stmt->bindParam(':descricao', $descricao);
$stmt->bindParam(':precoV', $priceV); // Corrigido para usar $priceV
$stmt->bindParam(':precoA', $priceA); // Corrigido para usar $priceA
$stmt->bindParam(':estoque', $estoque);
$stmt->bindParam(':categoria', $categoria);
$stmt->bindParam(':barcode', $barcode);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Produto cadastrado com sucesso.', 'redirect' => 'inventary.php']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o Produto.']);
}
?>