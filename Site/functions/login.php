<?php
require_once '../../Conection/Conexao.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)){
        echo json_encode(['status' => 'error', 'message' => 'Usuário e senha são obrigatórios.']);
        exit();
    }

    try{
        // Preparar a consulta
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :username");
        
        // Associar os parâmetros
        $stmt->bindValue(':username', $username);
        
        // Executar a consulta
        $stmt->execute();
        
        // Verificar se algum resultado foi retornado
        if($stmt->rowCount() > 0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verificar a senha
            if(password_verify($password, $results['password'])){
                $_SESSION['user'] = ["name" => $results['nome'], "email" => $results['nome']]; // ou outro identificador
                echo json_encode(['status' => 'success', 'message' => 'Login bem-sucedido!', 'redirect' => 'index.php']);
                exit();
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Senha incorreta.']);
            }
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado.']);
        }
    }catch (PDOException $e){
        echo json_encode(['status' => 'error', 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
    }
}else{
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido.']);
}