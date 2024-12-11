<?php
require '../../Conection/Conexao.php'; // Inclua o arquivo de conexão

// Cria uma nova instância da classe Database
$conn = $database->getConnection();

// Obtém os dados do JSON
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se o código foi enviado
if (isset($data['code']) && !empty($data['code'])) {
    $code = $data['code'];

    $sql = "UPDATE funcionarios SET deletado = 1 WHERE codFunc = :code";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":code", $code);

    try {
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Deletado com sucesso.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar: ' . $e->getMessage()]);
    }
} else {
    // Retorna um erro se o código não foi enviado
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Código não fornecido.']);
}
