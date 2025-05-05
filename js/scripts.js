// Função para mostrar as mensagens 
function showMessage(message, type = 'info') {
    const messageDiv = document.getElementById('sistema-mensagem');
    const messageText = document.getElementById('mensagem-texto');
    if (!messageDiv || !messageText) return; // Sair se o elemento não for encontrado

    messageText.textContent = message;
    // Remova as classes de alerta existentes e adicione a nova
    messageDiv.className = `alert alert-${type} alert-dismissible fade show`; // Reseta as classes 

    // Certifique-se de que esteja visível
    messageDiv.classList.remove('d-none');
}

// Função para carregar reservas do localStorage
function loadReservations() {
    const reservationsJSON = localStorage.getItem('partyReservations');
    try {
        return reservationsJSON ? JSON.parse(reservationsJSON) : [];
    } catch (e) {
        console.error("Error parsing reservations from localStorage", e);
        return []; // Retornar array vazio em caso de erro
    }
}

// Função para salvar reservas no localStorage
function saveReservations(reservations) {
    localStorage.setItem('partyReservations', JSON.stringify(reservations));
}

// Função para renderizar a tabela de reservas
function renderReservationsTable() {
    const tableBody = document.getElementById('package-table-body');
    if (!tableBody) return; // Sair se o corpo da tabela não for encontrado

    const reservations = loadReservations();
    tableBody.innerHTML = ''; // Limpar linhas da tabela existentes

    if (reservations.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Nenhuma reserva encontrada.</td></tr>';
        return;
    }

    const currentUser = localStorage.getItem('username'); // Obter usuário atual para verificações de permissão

    reservations.forEach(res => {
        const row = document.createElement('tr');
        row.setAttribute('data-id', res.id); // Adicionar data-id para possíveis ações futuras

        // Determine status display
        let statusBadge;
        switch (res.status) {
            case 'Reservado':
                statusBadge = '<span class="badge bg-success">Reservado</span>';
                break;
            case 'Disponível': 
                statusBadge = '<span class="badge bg-info">Disponível</span>';
                 break;
            case 'Cancelado': 
                statusBadge = '<span class="badge bg-danger">Cancelado</span>';
                break;
            default:
                statusBadge = `<span class="badge bg-secondary">${res.status || 'Indefinido'}</span>`;
        }

        // Formatar a data caso ela exista
        let formattedDate = 'N/D';
        if (res.data) {
            try {
                const dateObj = new Date(res.data + 'T00:00:00'); // Garantir a análise correta
                 formattedDate = dateObj.toLocaleDateString('pt-BR');
            } catch(e) { console.error("Invalid date format:", res.data); }
        }


        row.innerHTML = `
            <td>${res.tipo || 'N/D'}</td>
            <td>${res.tema || 'N/D'}</td> <!-- Assuming tipo acts as Pacote, maybe add Tema later -->
            <td>${statusBadge}</td>
            <td>${formattedDate}</td>
            <td>${res.cores || 'N/D'}</td>
            <td class="action-wrapper"> <!-- Action buttons -->
                 <div class="btn-group btn-group-actions w-100" role="group">
                     ${currentUser === 'organizador' ? `
                         <button class="btn btn-sm btn-danger delete-reservation-btn" data-id="${res.id}">
                             <i class="bi bi-trash me-1"></i>Excluir
                         </button>
                         <button class="btn btn-sm btn-warning cancel-reservation-btn" data-id="${res.id}">
                             <i class="bi bi-x-circle me-1"></i>Cancelar
                         </button>
                     ` : `
                         <button class="btn btn-sm btn-info" disabled>
                             <i class="bi bi-eye me-1"></i>Ver Detalhes
                         </button>
                     `}
                 </div>
            </td>
        `;
        tableBody.appendChild(row);
    });

     // Adicione ouvintes de eventos para novos botões (se necessário - veja o manipulador de envio abaixo para um exemplo de exclusão/cancelamento)
    addTableActionListeners();
}

// Função de adicionar ouvintes a tabela
function addTableActionListeners() {
    const deleteButtons = document.querySelectorAll('.delete-reservation-btn');
    deleteButtons.forEach(button => {
        // Remova o ouvinte existente para evitar duplicatas se forem chamadas várias vezes
        button.replaceWith(button.cloneNode(true));
    });
     // Reselecione os botões após a clonagem
     document.querySelectorAll('.delete-reservation-btn').forEach(button => {
        button.addEventListener('click', handleDeleteReservation);
     });

     const cancelButtons = document.querySelectorAll('.cancel-reservation-btn');
     cancelButtons.forEach(button => {
        button.replaceWith(button.cloneNode(true));
     });
     document.querySelectorAll('.cancel-reservation-btn').forEach(button => {
         button.addEventListener('click', handleCancelReservation);
     });
}

// Botão para exclusão de uma reserva
function handleDeleteReservation(event) {
     const button = event.currentTarget;
     const reservationId = parseInt(button.getAttribute('data-id')); 

     if (confirm('Tem certeza que deseja excluir permanentemente esta reserva?')) {
         let reservations = loadReservations();
         reservations = reservations.filter(res => res.id !== reservationId);
         saveReservations(reservations);
         renderReservationsTable(); // Renderizar a tabela
         showMessage('Reserva excluída com sucesso.', 'success');
     }
}

// Manipulador para cancelamento de reserva (exemplo: alterar status)
function handleCancelReservation(event) {
    const button = event.currentTarget;
    const reservationId = parseInt(button.getAttribute('data-id')); // Identifique ID como um número

    if (confirm('Tem certeza que deseja cancelar esta reserva?')) {
        let reservations = loadReservations();
        const reservationIndex = reservations.findIndex(res => res.id === reservationId);
        if (reservationIndex !== -1) {
            reservations[reservationIndex].status = 'Cancelado'; // Mudar os status
            saveReservations(reservations);
            renderReservationsTable(); // Renderizar a tabela
            showMessage('Reserva cancelada.', 'warning');
        } else {
             showMessage('Erro: Reserva não encontrada.', 'danger');
        }
    }
}


document.addEventListener('DOMContentLoaded', () => {
    // --- Gerenciamento de login/usuário existente ---
    const username = localStorage.getItem('username');
    const usernameDisplay = document.getElementById('username-display');

    if (!username) {
        // Se nenhum usuário estiver logado (e.g., direct access to reservas.html), redirecionar para o login
        console.warn("Nenhum usuário logado, acesso pode ser limitado.");
         if (usernameDisplay) usernameDisplay.textContent = 'Visitante';
    } else {
        if (usernameDisplay) usernameDisplay.textContent = username;

        // --- Admin/User Controle de visibilidade ---
        const adminOnlyElements = document.querySelectorAll('.admin-only');
        const reserveSection = document.getElementById('secao-reservar'); // The reservation section

        if (username === 'organizador') {
            adminOnlyElements.forEach(el => el.style.display = 'block'); // Show admin sections
            // Se for admin, a seção de reserva pode ocupar toda a largura se a seção adicional estiver visível
            if (document.getElementById('secao-adicionar-pacote')?.style.display === 'block') {
                 // Se o pacote adicional estiver visível, mantenha a reserva em col-md-6
                 if(reserveSection) reserveSection.className = 'col-md-6';
            } else {
                 // Se o pacote adicional estiver oculto, faça a reserva em largura total
                  if(reserveSection) reserveSection.className = 'col-md-12'; // Tornar a seção de reserva em largura total se admin E add estiverem ocultosTornar a seção de reserva em largura total se admin E add estiverem ocultos
            }
        } else {
            // se User for 'convidado' 
            adminOnlyElements.forEach(el => el.style.display = 'none'); // Esconder seção dos admins
             if(reserveSection) reserveSection.className = 'col-md-12'; // Tornar a seção de reserva em largura total para não administradores
        }
    }

    // --- Ano no rodapé ---
    const anoAtualElement = document.getElementById('ano-atual');
    if (anoAtualElement) {
        anoAtualElement.textContent = new Date().getFullYear();
    }

    // --- Renderização da tabela ---
    renderReservationsTable(); // Carregar e exibir reservas existentes

    // --- Adicionar manipulador de formulário de pacote (somente administrador - simula adição) ---
    const addPackageForm = document.getElementById('addPackageForm');
    if (addPackageForm && username === 'organizador') {
        addPackageForm.addEventListener('submit', (event) => {
            event.preventDefault();
            // Mensagem de sucesso
            showMessage('Pacote adicionado com sucesso (Simulação)!', 'success');
            addPackageForm.reset(); // Reset
        });
    }

    // --- Formulário da reserva ---
    const reserveForm = document.getElementById('reserveForm');
    if (reserveForm) {
        reserveForm.addEventListener('submit', (event) => {
            event.preventDefault();

            // Obtenha dados do formulário
            const tipoEvento = reserveForm.querySelector('[name="tipo_evento_reserva"]').value;
            const dataFesta = reserveForm.querySelector('[name="data_festa"]').value;
            const coresPreferencia = reserveForm.querySelector('[name="cores_preferencia"]').value;
            const numConvidados = reserveForm.querySelector('[name="num_convidados"]').value;

            // Validação básica
            if (!dataFesta) {
                showMessage('Por favor, selecione a data da festa.', 'warning');
                reserveForm.querySelector('[name="data_festa"]').focus();
                return;
            }

            // Criar um novo objeto de reserva
            const newReservation = {
                id: Date.now(), // Use o registro de data e hora como um ID único simples para esta demonstração
                tipo: tipoEvento,
                data: dataFesta,
                cores: coresPreferencia || 'Não especificado', // Se estiver vazio, dar aviso
                convidados: numConvidados || 'N/D', // Número não informado de convidados
                status: 'Reservado', // Mudar status para 'Reservado'
                tema: '' // Adicionar tema depois se necessário
            };

            // Carregar reservas já existentes, adicionar a nova, e salvar
            const reservations = loadReservations();
            reservations.push(newReservation);
            saveReservations(reservations);

            // Atualizar a tabela
            renderReservationsTable();

            // Mostrar mensagem de sucesso
            showMessage(`Reserva para ${tipoEvento} em ${new Date(dataFesta + 'T00:00:00').toLocaleDateString('pt-BR')} realizada com sucesso!`, 'success');

            // Limpar o formulário
            reserveForm.reset();
        });
    }

     // --- Botão de sair ---
    const logoutButton = document.querySelector('a[href="login.html"]'); // Selecionar o botão de sair
    if (logoutButton) {
        logoutButton.addEventListener('click', (event) => {
             event.preventDefault(); // Impedir o comportamento padrão do link
             localStorage.removeItem('username'); // Limpe o nome de usuário armazenado
             showMessage('Logout realizado com sucesso. Redirecionando...', 'info');
             // Redirecionar a página de login
             setTimeout(() => {
                 window.location.href = 'index.html'; // Redirecionar para index.html 
             }, 1500);
        });
    }

}); 