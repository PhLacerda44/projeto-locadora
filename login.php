<?php
// Start the session AT THE VERY TOP
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        body { background-color: #e8f5e9; }
        .login-container { max-width: 500px; margin-top: 5vh;}
        .card-header { background-color: #2e7d32; }
        .btn-success { background-color: #4caf50; border-color: #4caf50; }
        .btn-success:hover { background-color: #388e3c; border-color: #388e3c; }
        .forgot-password-link a { font-size: 0.85rem; text-decoration: none; }
        .forgot-password-link a:hover { text-decoration: underline; }
        .login-tip { background-color: #f1f8e9; border-color: #dcedc8; }
    </style>
</head>
<body class="bg-light">

    <div class="login-container container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Acesso ao Sistema de Eventos</h4>
            </div>
            <div class="card-body">

                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<div id="errorMessage" class="alert alert-danger" role="alert">';
                    echo htmlspecialchars($_SESSION['login_error']);
                    echo '</div>';
                    unset($_SESSION['login_error']);
                } else {
                     echo '<div id="errorMessage" class="alert alert-danger d-none" role="alert">Mensagem de erro aparecerá aqui</div>';
                }
                ?>

                <form id="loginForm" method="post" action="process_login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label"><i class="bi bi-person me-1"></i>Usuário ou Email</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Digite seu usuário ou email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="bi bi-key me-1"></i>Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Digite sua senha">
                    </div>
                    <div class="text-end mb-3 forgot-password-link">
                        <a href="forgot_password.php">Esqueci minha senha</a>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                    </button>
                </form>

                <div class="login-tip mt-4 p-3 border rounded bg-light">
                    <h5 class="text-success"><i class="bi bi-info-circle me-2"></i>Dica de Acesso</h5>
                    <p class="small mb-1">Use <strong>organizador</strong> / <strong>eventoAdmin123</strong> para acesso total.</p>
                    <p class="small mb-0">Use <strong>convidado</strong> / <strong>festaUser456</strong> para acesso limitado.</p>
                </div>
            </div>
            <div class="card-footer text-center">
                <small class="text-muted">© <span id="ano-atual"></span> Sistema de Gerenciamento de Festas e Eventos</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('ano-atual').textContent = new Date().getFullYear();
    </script>
</body>
</html>