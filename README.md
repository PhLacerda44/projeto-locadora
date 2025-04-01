# Sistema de Locadora de Veículos - Front-end (Fase 1)

Este projeto implementa a interface de usuário (front-end) para um sistema de locadora de veículos utilizando HTML, CSS, Bootstrap e JavaScript. Este é o primeiro passo do desenvolvimento, focando apenas na camada visual para introduzir os conceitos de interface antes de implementar a lógica de back-end.

## Estrutura do Projeto

```
locadora-veiculos-frontend/
├── css/
│   └── styles.css       # Estilos personalizados
├── js/
│   └── scripts.js       # Validação de formulários e outros scripts
├── img/                 # Pasta para imagens (se necessário)
├── index.html           # Página principal (dashboard)
├── login.html           # Página de login
└── README.md            # Instruções do projeto
```

## Tecnologias Utilizadas

- **HTML5**: Estrutura das páginas
- **CSS3**: Estilização personalizada
- **Bootstrap 5**: Framework CSS para layout responsivo e componentes
- **Bootstrap Icons**: Biblioteca de ícones
- **JavaScript**: Validação de formulários e interatividade básica

## Funcionalidades Implementadas (Simuladas)

Nesta fase, apenas a interface visual está implementada, com simulações simples de interação:

1. **Página de Login**:
   - Formulário de autenticação
   - Dicas de acesso com usuários demo
   - Validação de campos obrigatórios

2. **Página Principal (Dashboard)**:
   - Barra superior com informações do usuário
   - Formulário para adicionar veículos (visível apenas para admin)
   - Calculadora de previsão de aluguel
   - Tabela de veículos cadastrados
   - Botões de ação (alugar, devolver, deletar) simulados
   - Interface adaptativa baseada no perfil do usuário

## Como Utilizar

1. Abra o arquivo `login.html` em um navegador web
2. Use um dos seguintes "usuários" para simular o login:
   - Administrador: `admin` / `admin123` (acesso completo)
   - Usuário comum: `usuario` / `user123` (acesso limitado)
3. Após o login, você será redirecionado para a página principal (`index.html`)
4. Para alternar entre os perfis, use os seguintes URLs:
   - Perfil Administrador: `index.html?perfil=admin`
   - Perfil Usuário comum: `index.html?perfil=usuario`

## Simulações de Interface

Como este é apenas o front-end, algumas ações são simuladas através de JavaScript:

- **Login**: Verifica se os campos foram preenchidos e redireciona para o dashboard
- **Adicionar Veículo**: Exibe um alerta de sucesso (sem realmente adicionar à tabela)
- **Alugar/Devolver/Deletar**: Exibe alertas de confirmação (sem alterar dados)
- **Calcular Previsão**: Calcula valores baseados em regras fixas (R$100/dia para carros, R$50/dia para motos)

## Diferenças entre Perfis de Usuário

O sistema simula dois perfis de usuário com diferentes permissões:

### Perfil Administrador (`admin`)
- Acesso ao formulário de adicionar veículos
- Visualização de todos os botões de ação (Alugar, Devolver, Deletar)
- Acesso à calculadora de previsão

### Perfil Usuário Comum (`usuario`)
- Sem acesso ao formulário de adicionar veículos
- Sem visualização dos botões de ação
- Acesso apenas à calculadora de previsão e visualização de veículos

## Próximos Passos (Fase 2)

Na próxima fase do projeto, serão implementadas:

- Lógica de back-end com PHP
- Conexão com banco de dados MySQL
- Autenticação real de usuários
- Operações CRUD para veículos
- Implementação das classes e da arquitetura orientada a objetos
- Sistema de permissões baseado em perfis

## Observações para Desenvolvimento

Esta versão do projeto serve como base para entender a estrutura da interface antes de implementar o back-end. Os alunos devem se familiarizar com:

1. A estrutura HTML das páginas
2. Os componentes Bootstrap utilizados
3. A folha de estilos CSS personalizada
4. A validação de formulários com JavaScript
5. A adaptação da interface baseada em perfis de usuário

Estes conhecimentos serão essenciais para a integração com o back-end na segunda fase do projeto.