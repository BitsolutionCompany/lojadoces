<?php
require '../../Conection/Conexao.php'; // Inclua o arquivo de conexão

// Cria uma nova instância da classe Database
$conn = $database->getConnection();

// Recebe dados do formulário via POST
$newAdminName = $_POST["newAdminName"];
$gender = $_POST["gender"];
$birthdate = $_POST["birthdate"];
$cpf = $_POST["cpf"];
$cep = $_POST["cep"];
$cidade = $_POST["cidade"];
$logradouro = $_POST["logradouro"];
$number = $_POST["number"];
$estado = $_POST["estado"];
$email = $_POST["email"];
$newAdminPassword = $_POST["newAdminPassword"];
$loja = "Tudo da Terra";

// Verifica se os campos estão preenchidos
if (empty($newAdminName) || empty($gender) || empty($birthdate) || empty($cpf) || empty($cep) || empty($cidade) || empty($logradouro) || empty($number) || empty($estado) || empty($email) || empty($newAdminPassword)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}

// Converter data
function converter_data($data_str){
    $data = DateTime::createFromFormat('d/m/Y', $data_str);
    if(!$data){
        return json_encode(['status' => 'error', 'message' => 'Data Inválida']);
    }
    return $data->format('Y-m-d');
}
// Valida CPF
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $digito1 = 11 - ($soma % 11);
    $digito1 = ($digito1 >= 10) ? 0 : $digito1;

    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $digito2 = 11 - ($soma % 11);
    $digito2 = ($digito2 >= 10) ? 0 : $digito2;

    return ($digito1 == $cpf[9] && $digito2 == $cpf[10]);
}

// Verifica se o CPF é válido
if (!validarCPF($cpf)) {
    echo json_encode(['status' => 'error', 'message' => 'CPF inválido.']);
    exit;
}

// Verifica se o CEP é válido
if (!preg_match("/^\d{5}-\d{3}$/", $cep)) {
    echo json_encode(['status' => 'error', 'message' => 'CEP inválido.']);
    exit;
}

// Verifica se o e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'E-mail inválido.']);
    exit;
}

// Verifica se o usuário já está cadastrado pelo CPF ou e-mail
$sqlCheck = "SELECT COUNT(*) FROM adm WHERE cpf = :cpf OR email = :email";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bindParam(':cpf', $cpf);
$stmtCheck->bindParam(':email', $email);
$stmtCheck->execute();

if ($stmtCheck->fetchColumn() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Um administrador com este CPF ou e-mail já está cadastrado.']);
    exit;
}

// Hash da senha
$newAdminPassword = password_hash($newAdminPassword, PASSWORD_DEFAULT);
// Codigo do administrador
$adminCode = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
// Data sql
$data_sql = converter_data($birthdate);

// Prepara a inserção no banco de dados
$sql = "INSERT INTO adm (codeAdm, nome, loja, gender, birthdate, cpf, cep, cidade, logradouro, numero, estado, email, password) VALUES (:code, :nome, :loja, :genero, :data_nascimento, :cpf, :cep, :cidade, :logradouro, :numero, :estado, :email, :senha)";
$stmt = $conn->prepare($sql);

// Bind dos parâmetros
$stmt->bindParam(':code', $adminCode);
$stmt->bindParam(':nome', $newAdminName);
$stmt->bindParam(':genero', $gender);
$stmt->bindParam(':loja', $loja);
$stmt->bindParam(':data_nascimento', $data_sql);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':cep', $cep);
$stmt->bindParam(':cidade', $cidade);
$stmt->bindParam(':logradouro', $logradouro);
$stmt->bindParam(':numero', $number);
$stmt->bindParam(':estado', $estado);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $newAdminPassword);

// Executa a inserção e verifica se foi bem-sucedida
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Administrador cadastrado com sucesso.', 'redirect' => 'index.php']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o administrador.']);
}
?>