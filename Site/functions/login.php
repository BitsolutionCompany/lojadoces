<?php
require_once '../../Conection/Conexao.php';
session_start(); // Inicia a sessão

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Sanitização e validação dos dados de entrada
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']);
    
    if(empty($username) || empty($password)){
        echo json_encode(['status' => 'error', 'message' => 'Usuário e senha são obrigatórios.']);
        exit();
    }

    // Validação contra credenciais hardcoded
    // if ($username === "biacosmetico" && $password === "Biacosmetico.2020"){
    //     $_SESSION['user'] = ["name" => $username, "email" => $username];
    //     echo json_encode(['status' => 'success', 'message' => 'Login bem-sucedido!', 'redirect' => 'dashboard.php']);
    //     exit();
    // }
    try{
        // Preparar a consulta
        $stmt = $conn->prepare("SELECT * FROM user WHERE LOWER(email) = :username ");
        
        // Associar os parâmetros
        $stmt->bindValue(':username', $username);
        
        // Executar a consulta
        $stmt->execute();
        
        // Verificar se algum resultado foi retornado
        if($stmt->rowCount() > 0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verificar a senha
            if(password_verify($password, $results['password'])){
                $_SESSION['user'] = ["name" => $results['name'], "email" => $results['email'], "code" => $results['codeuser']]; // ou outro identificador
                // $url = isset($_GET['continue']) ? $_GET['continue'] : null;
                // , 'redirect' => $url
                echo json_encode(['status' => 'success', 'message' => 'Login bem-sucedido!']);
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