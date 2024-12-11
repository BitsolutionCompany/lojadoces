<?php
require '../../Conection/Conexao.php'; // Inclua o arquivo de conexão

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cria uma nova instância da classe Database
$conn = $database->getConnection();

// Recebe os dados do formulário via post
$nome = $_POST['nome'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$birthdate = $_POST['birthdate'];
$cpf = $_POST['cpf'];
$cep = $_POST['cep'];
$city = $_POST['cidade'];
$logradouro = $_POST['logradouro'];
$number = $_POST['number'];
$estado = $_POST['estado'];
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$admissao = $_POST['admissao'];

// var_dump($_POST);
// exit;
// Verifica se os campos estão preenchidos
if (empty($nome) || empty($gender) || empty($birthdate) || empty($cpf) || empty($cep) || empty($city) || empty($logradouro) || empty($number) || empty($estado) || empty($email) || empty($cargo) || empty($admissao)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}
// Converter data
function converter_birthdate($data_str){
    $data = DateTime::createFromFormat('d/m/Y', $data_str);
    if(!$data){
        return json_encode(['status' => 'error', 'message' => 'Data Inválida']);
    }
    return $data->format('Y-m-d');
}
function converter_admissao($data_str){
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
$sqlCheck = "SELECT COUNT(*) FROM funcionarios WHERE cpf = :cpf OR email = :email";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bindParam(':cpf', $cpf);
$stmtCheck->bindParam(':email', $email);
$stmtCheck->execute();

if ($stmtCheck->fetchColumn() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Um Funcionário com este CPF ou e-mail já está cadastrado.']);
    exit;
}

// Codigo FUNCIONARIO
$funcCode = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
// Data sql
$birthdate = converter_birthdate($birthdate);
$admissao = converter_admissao($admissao);

// Prepara a inserção no banco de dados
$sql = "INSERT INTO funcionarios (codFunc, nome, birthdate, cpf, cep, cidade, numero, estado, logradouro, cargo, data_admissao, email, gender) VALUES (:code, :nome, :birthdate, :cpf, :cep, :cidade, :numero, :estado, :logradouro, :cargo, :data_admissao, :email, :gender)";
$stmt = $conn->prepare($sql);
// Bind dos parâmetros
$stmt->bindParam(':code', $funcCode);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':cep', $cep);
$stmt->bindParam(':cidade', $city);
$stmt->bindParam(':numero', $number);
$stmt->bindParam(':estado', $estado);
$stmt->bindParam(':logradouro', $logradouro);
$stmt->bindParam(':cargo', $cargo);
$stmt->bindParam(':data_admissao', $admissao);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':gender', $gender);

// Executa a inserção e verifica se foi bem-sucedida

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Funcionário cadastrado com sucesso.', 'redirect' => 'funcionarios.php']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o administrador.']);
}