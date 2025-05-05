<?php
session_start();

//Configurações de conexão
$host = "localhost";
$usuario = "root";
$senha = "Senai@118";
$banco = "projeto_locadora";

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = "Você precisa fazer login para acessar esta página.";
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados (ajuste conforme seu banco)
$conn = new mysqli("localhost", "root", "", "projeto_locadora");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Pega dados da sessão
$username = htmlspecialchars($_SESSION['username'] ?? 'Usuário');
$userRole = $_SESSION['role'] ?? 'guest';

// Inicializa mensagem do sistema
$systemMessage = null;

// --- LÓGICA DE FORMULÁRIOS ---

// Adicionar novo pacote (somente admin)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['adicionar_pacote']) && $userRole === 'admin') {
    $nome = $conn->real_escape_string($_POST['nome_pacote']);
    $tema = $conn->real_escape_string($_POST['tema']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $capacidade = intval($_POST['capacidade']);
    $preco = floatval($_POST['preco_base']);

    $sql = "INSERT INTO pacotes (nome, tema, descricao, capacidade, preco_base, status) VALUES ('$nome', '$tema', '$descricao', $capacidade, $preco, 'disponivel')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['system_message'] = "Pacote adicionado com sucesso!";
    } else {
        $_SESSION['system_message'] = "Erro ao adicionar pacote: " . $conn->error;
    }
    header("Location: reservas.php");
    exit();
}

// Reservar um pacote
if (isset($_POST['reservar_pacote'])) {
    $id_pacote = intval($_POST['id_pacote']);
    $data_reserva = $conn->real_escape_string($_POST['data_reserva']);
    $cores = $conn->real_escape_string($_POST['cores_escolhidas']);

    $sql = "UPDATE pacotes SET status='reservado', data_reservada='$data_reserva', cores_escolhidas='$cores' WHERE id=$id_pacote";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['system_message'] = "Pacote reservado com sucesso!";
    } else {
        $_SESSION['system_message'] = "Erro ao reservar: " . $conn->error;
    }
    header("Location: reservas.php");
    exit();
}



// Cancelar reserva
if (isset($_POST['cancelar_reserva'])) {
    $id_pacote = intval($_POST['id_pacote']);
    $sql = "UPDATE pacotes SET status='disponivel', data_reservada=NULL, cores_escolhidas=NULL WHERE id=$id_pacote";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['system_message'] = "Reserva cancelada com sucesso!";
    } else {
        $_SESSION['system_message'] = "Erro ao cancelar reserva: " . $conn->error;
    }
    header("Location: reservas.php");
    exit();
}

// Deletar pacote (somente admin)
if (isset($_POST['deletar_pacote']) && $userRole === 'admin') {
    $id_pacote = intval($_POST['id_pacote']);
    $sql = "DELETE FROM pacotes WHERE id=$id_pacote";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['system_message'] = "Pacote deletado com sucesso!";
    } else {
        $_SESSION['system_message'] = "Erro ao deletar: " . $conn->error;
    }
    header("Location: reservas.php");
    exit();
}

// Recupera mensagem de sistema
if (isset($_SESSION['system_message'])) {
    $systemMessage = $_SESSION['system_message'];
    unset($_SESSION['system_message']);
}
?>
