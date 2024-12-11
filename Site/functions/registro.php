<?php
require_once '../../Conection/Conexao.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = $database->getConnection();

$nome = $_POST['nome'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$cpf = $_POST['cpf'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$email = strtolower($email);
$confirmemail = $_POST['confirmemail'];
$confirmemail = strtolower($confirmemail);
$pass = $_POST['pass'];
$confirmpass = $_POST['confirmpass'];

if (empty($nome) || empty($gender) || empty($birthdate) || empty($cpf) || empty($phone) || empty($email) || empty($confirmemail) || empty($pass) || empty($confirmpass)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}
// Convert data
function convert_birthdate($data_str){
    $data = DateTime::createFromFormat('d/m/Y', $data_str);
    if(!$data){
        return json_encode(['status' => 'error', 'message' => 'Data Inválida']);
    }
    return $data->format('Y-m-d');
}

// Valida cpf
function validarCpf($cpf){
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if(strlen($cpf) != 11){
        return false;
    }

    if(preg_match('/^(\d)\1{10}$/', $cpf)){
        return false;
    }

    $soma = 0;
    for($i = 0; $i < 9; $i++){
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

// Verifica se o e-mail é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'E-mail inválido.']);
    exit;
}

if($email != $confirmemail){
    echo json_encode(['status' => 'error', 'message' => 'Os emails não coincidem.']);
    exit;
}
if($pass != $confirmpass){
    echo json_encode(['status' => 'error', 'message' => 'As Senhas Não Conferem!.']);
    exit;
}
// Verifica se o usuário já está cadastrado pelo CPF ou e-mail
$sqlCheck = "SELECT COUNT(*) FROM user WHERE lower(email) = :email";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bindParam(':email', $email);
$stmtCheck->execute();

if ($stmtCheck->fetchColumn() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Um Usuário com este CPF ou e-mail já está cadastrado.']);
    exit;
}

$codeuser = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);

$birthdate = convert_birthdate($birthdate);

$pass = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO user(codeuser, name, cpf, email, gender, phone, birthdate, password) VALUES(:code, :name, :cpf, :email, :gender, :phone, :birthdate, :password)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':code', $codeuser);
$stmt->bindParam(':name', $nome);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':password', $pass);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Usuario cadastrado com sucesso.', 'redirect' => 'login.php']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar Usuario.']);
}