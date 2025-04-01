<?php
// Start the session AT THE VERY TOP
session_start();

// **SECURITY CHECK**: Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = "Você precisa fazer login para acessar esta página.";
    header("Location: login.php");
    exit();
}

// Get user information from the session
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Usuário';
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';


// --- Code to handle form submissions (add package, reserve, etc.) would go here ---
// This would involve database interactions

// Example for processing package addition form
//if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adicionar_pacote'])) {
//    // 1. Check if the user is an admin
//    if ($userRole === 'admin') {
//
//        // 2. Retrieve data from the $_POST array (ensure to sanitize)
//        $nome_pacote = $_POST['nome_pacote'];
//
//        // 3. Connect to the database and insert the data.
//
//
//    } else {
//        // If user is not admin
//        $systemMessage = "Você não tem permissão para adicionar pacotes.";
//    }
//}


// Retrieve system message if set. Example system messages
$systemMessage = null;
if (isset($_SESSION['system_message'])) {
    $systemMessage = $_SESSION['system_message'];
    unset($_SESSION['system_message']); // Clear the message
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Locadora de Eventos e Festas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .action-wrapper .booking-group > *, .action-wrapper .reserved-info > * { margin-bottom: 0.5rem; }
        .action-wrapper .booking-group input[type="date"], .action-wrapper .booking-group input[type="text"] { max-width: 180px; display: inline-block; margin-right: 5px; }
        .reserved-info span { display: block; font-size: 0.9em; }
    </style>
</head>
<body class="container py-4">
    <div class="container py-4">

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Sistema de Locadora de Eventos e Festas</h1>
                    <div class="d-flex align-items-center gap-3 user-info">
                        <span class="user-icon">
                            <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                        </span>
                        <span class="welcome-text">Bem-vindo, <strong id="username-display"><?php echo htmlspecialchars($username); ?></strong></span>
                        <a href="logout.php" class="btn btn-outline-danger d-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i>
                            Sair
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($systemMessage): ?>
        <div id="sistema-mensagem" class="alert alert-info alert-dismissible fade show" role="alert">
            <span id="mensagem-texto"><?php echo htmlspecialchars($systemMessage); ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row same-height-row">
            <?php if ($userRole === 'admin'): ?>
            <div class="col-md-6 admin-only" id="secao-adicionar-pacote">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Adicionar Novo Pacote de Festa</h4>
                    </div>
                    <div class="card-body">
                        <form id="addPackageForm" method="post" action="reservas.php">  <!-- Point to self -->
                            <div class="mb-3"><label class="form-label">Nome do Pacote</label><input type="text" name="nome_pacote" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Tema Principal</label><input type="text" name="tema" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Descrição Curta</label><input type="text" name="descricao" class="form-control"></div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">Capacidade (Pessoas)</label><input type="number" name="capacidade" class="form-control" min="1"></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Preço Base (R$)</label><input type="number" name="preco_base" class="form-control" step="0.01" min="0"></div>
                            </div>
                            <button type="submit" name="adicionar_pacote" class="btn btn-primary w-100"><i class="bi bi-plus-lg me-1"></i>Adicionar Pacote</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="<?php echo ($userRole === 'admin') ? 'col-md-6' : 'col-md-12'; ?>" id="secao-reservar">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="bi bi-calendar2-check me-2"></i>Reservar Festa / Verificar Data</h4>
                    </div>
                    <div class="card-body">
                        <form id="reserveForm" method="post" action="reservas.php">
                            <div class="mb-3"><label class="form-label">Tipo de Evento/Pacote</label><select name="tipo_evento_reserva" class="form-select"><option value="Aniversário Infantil">Aniversário Infantil</option><option value="Casamento">Casamento</option><option value="Festa Corporativa">Festa Corporativa</option><option value="Outro">Outro</option></select></div>
                            <div class="mb-3"><label class="form-label">Data da Festa</label><input type="date" name="data_festa" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Preferência de Cores</label><input type="text" name="cores_preferencia" class="form-control" placeholder="Ex: Azul, Branco, Dourado"><small class="form-text text-muted">Sugestão de cores para a decoração.</small></div>
                            <div class="mb-3"><label class="form-label">Número Estimado de Convidados</label><input type="number" name="num_convidados" class="form-control" min="1"></div>
                            <button type="submit" name="verificar_reserva" class="btn btn-success w-100"><i class="bi bi-search me-1"></i>Verificar Disponibilidade / Reservar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="bi bi-list-stars me-2"></i>Pacotes de Festa Disponíveis</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Pacote</th>
                                        <th>Tema</th>
                                        <th>Status</th>
                                        <th>Data Reservada</th>
                                        <th>Cores Escolhidas</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="bi bi-balloon-heart me-1"></i>Aniversário Mágico</td>
                                        <td>Unicórnios</td>
                                        <td>
                                            <span class="badge bg-info">
                                                <i class="bi bi-calendar-check me-1"></i>Reservado
                                            </span>
                                        </td>
                                         <td>2024-12-15</td>
                                         <td>Rosa, Lilás, Dourado</td>
                                        <td>
                                            <div class="action-wrapper">
                                                <form class="btn-group-actions" method="post" action="reservas.php">  <!-- Point to self -->
                                                    <input type="hidden" name="id_pacote" value="1">
                                                    <input type="hidden" name="nome_pacote" value="Aniversário Mágico">
                                                    <button type="submit" name="deletar_pacote" class="btn btn-danger btn-sm delete-btn admin-only mb-1">
                                                        <i class="bi bi-trash me-1"></i>Deletar Pacote
                                                    </button>
                                                    <button type="submit" name="cancelar_reserva" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-calendar-x me-1"></i>Cancelar Reserva
                                                    </button>
                                                     <!-- <button type="submit" name="concluir_evento" class="btn btn-secondary btn-sm admin-only">
                                                        <i class="bi bi-check2-circle me-1"></i>Marcar Concluído
                                                    </button> -->
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><i class="bi bi-stars me-1"></i>Festa Galáctica</td>
                                        <td>Espaço Sideral</td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Disponível
                                            </span>
                                        </td>
                                         <td>-</td>
                                         <td>-</td>
                                        <td>
                                             <div class="action-wrapper">
                                                <form class="btn-group-actions booking-group" method="post" action="reservas.php"> <!-- Point to self -->
                                                    <input type="hidden" name="id_pacote" value="2">
                                                    <input type="hidden" name="nome_pacote" value="Festa Galáctica">
                                                    <button type="submit" name="deletar_pacote" class="btn btn-danger btn-sm delete-btn admin-only mb-2">
                                                        <i class="bi bi-trash me-1"></i>Deletar Pacote
                                                    </button>
                                                    <div>
                                                      <label for="data_reserva_2" class="form-label visually-hidden">Data</label>
                                                      <input type="date" id="data_reserva_2" name="data_reserva" class="form-control form-control-sm" required title="Escolha a data do evento">
                                                    </div>
                                                     <div>
                                                        <label for="cores_2" class="form-label visually-hidden">Cores</label>
                                                        <input type="text" id="cores_2" name="cores_escolhidas" class="form-control form-control-sm" placeholder="Cores (ex: Azul, Prata)" title="Digite as cores desejadas">
                                                    </div>
                                                    <button type="submit" name="reservar_pacote" class="btn btn-success btn-sm">
                                                        <i class="bi bi-calendar-plus me-1"></i>Reservar este Pacote
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                     <tr>
                                        <td><i class="bi bi-flower1 me-1"></i>Jardim Encantado</td>
                                        <td>Flores e Fadas</td>
                                         <td>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Disponível
                                            </span>
                                        </td>
                                         <td>-</td>
                                         <td>-</td>
                                        <td>
                                             <div class="action-wrapper">
                                                <form class="btn-group-actions booking-group" method="post" action="reservas.php">  <!-- Point to self -->
                                                    <input type="hidden" name="id_pacote" value="3">
                                                    <input type="hidden" name="nome_pacote" value="Jardim Encantado">
                                                    <button type="submit" name="deletar_pacote" class="btn btn-danger btn-sm delete-btn admin-only mb-2">
                                                        <i class="bi bi-trash me-1"></i>Deletar Pacote
                                                    </button>
                                                     <div>
                                                      <label for="data_reserva_3" class="form-label visually-hidden">Data</label>
                                                      <input type="date" id="data_reserva_3" name="data_reserva" class="form-control form-control-sm" required title="Escolha a data do evento">
                                                    </div>
                                                     <div>
                                                        <label for="cores_3" class="form-label visually-hidden">Cores</label>
                                                        <input type="text" id="cores_3" name="cores_escolhidas" class="form-control form-control-sm" placeholder="Cores (ex: Verde, Rosa)" title="Digite as cores desejadas">
                                                    </div>
                                                    <button type="submit" name="reservar_pacote" class="btn btn-success btn-sm">
                                                        <i class="bi bi-calendar-plus me-1"></i>Reservar este Pacote
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rodapé -->
        <footer class="mt-5 text-center text-muted">
            <hr>
            <p>Sistema de Locadora de Eventos e Festas © <span id="ano-atual">2024</span> - Sua festa começa aqui!</p>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts customizados -->
    <script src="js/scripts.js"></script>
    <script>
        document.getElementById('ano-atual').textContent = new Date().getFullYear();

        const userRole = '<?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'guest'; ?>';
        const isAdmin = userRole === 'admin';
        const adminOnlyElements = document.querySelectorAll('.admin-only');

        if (!isAdmin) {
            adminOnlyElements.forEach(el => {
                if (el.id === 'secao-adicionar-pacote') {
                     el.style.display = 'none';
                     document.getElementById('secao-reservar')?.classList.replace('col-md-6', 'col-md-12');
                } else {
                    el.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>