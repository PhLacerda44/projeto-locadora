<?php
// Start the session
session_start();

// --- Database Simulation (REMOVE THIS FOR A REAL DATABASE!) ---
$users = [
    'organizador' => [
        'password_hash' => password_hash('eventoAdmin123', PASSWORD_DEFAULT),
        'role' => 'admin',
        'id' => 1
    ],
    'convidado' => [
        'password_hash' => password_hash('festaUser456', PASSWORD_DEFAULT),
        'role' => 'user',
        'id' => 2
    ],
];
// --- End Database Simulation ---

// Function to redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // --- Database Query Simulation (REPLACE THIS WITH REAL QUERY) ---
    $user_found = null;
    foreach ($users as $uname => $data) {
        if (strtolower($uname) === strtolower($username)) {
            $user_found = $data;
            $user_found['username'] = $uname;
            break;
        }
    }
    // --- End Query Simulation ---

    if ($user_found && password_verify($password, $user_found['password_hash'])) {
        // --- Login Successful ---
        session_regenerate_id(true);  // Security: prevent session fixation
        $_SESSION['user_id'] = $user_found['id'];
        $_SESSION['username'] = $user_found['username'];
        $_SESSION['role'] = $user_found['role'];
        redirect('reservas.php');

    } else {
        // --- Login Failed ---
        $_SESSION['login_error'] = "Usuário ou senha inválidos.";
        redirect('login.php');
    }

} else {
    // If accessed directly without POST, redirect to login
    redirect('login.php');
}
?>