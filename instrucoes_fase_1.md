# Roteiro de Desenvolvimento - Front-end da Locadora de Veículos

Este roteiro guiará você através do processo de construção do front-end do Sistema de Locadora de Veículos. O objetivo é criar apenas a estrutura visual que servirá como base para a implementação do back-end na próxima fase.

## Preparação do Ambiente

1. **Configurar a estrutura de pastas:**
   ```
   locadora-veiculos-frontend/
   ├── css/
   ├── js/
   ├── img/
   ```

2. **Criar os arquivos iniciais:**
   - Crie o arquivo `css/styles.css`
   - Crie o arquivo `js/scripts.js`
   - Crie os arquivos `login.html` e `index.html`
   <!-- Obs: Estrutura já fornecida pelo professor -->

## Etapa 1: Estilos CSS

1. Abra o arquivo `css/styles.css` e adicione os seguintes estilos:

```css

/* Fornecido completo pelo Professor */

```

## Etapa 2: JavaScript Simples

1. Abra o arquivo `js/scripts.js` e adicione o seguinte código:

```javascript

// Fornecido completo pelo Professor

```

## Etapa 3: Página de Login

1. Abra o arquivo `login.html` e adicione o seguinte código:

```html

<!-- 1ª Digitação (Conforme código na pasta Códigos) -->

```

## Etapa 4: Página Principal

1. Abra o arquivo `index.html` e adicione o seguinte código:

```html

<!-- 2ª Digitação (Conforme código na pasta Códigos) -->
 
```

## Etapa 5: Testando o Front-end

1. Abra o arquivo `login.html` em um navegador
2. Observe a interface visual do formulário de login
3. Clique no botão "Entrar" para navegar para a página principal
4. Na página principal, teste os dois links de perfil:
   - Admin: `index.html?perfil=admin`
   - Usuário comum: `index.html?perfil=usuario`
5. Observe como a interface se adapta para cada perfil

## Preparação para a Fase 2 (Back-end)

Na próxima etapa, implementaremos o back-end com PHP e MySQL. Identifique os seguintes pontos que precisarão de implementação:

1. **Formulários**: Todos os formulários têm o atributo `method="post"` e estão prontos para receber ações PHP.

2. **Botões de ação**: Todos os botões têm o atributo `name` definido (`adicionar`, `calcular`, `alugar`, `devolver`, `deletar`), o que facilitará a identificação das ações no PHP.

3. **Formulário de login**: Precisará ser conectado a um sistema de autenticação real.

4. **Seções condicionais**: Os elementos com a classe `admin-only` já estão preparados para serem condicionados por verificações de permissão no PHP.

5. **Tabela de veículos**: O HTML está pronto para ser gerado dinamicamente com dados do banco de dados.

## Pontos-chave para a transição para o PHP

1. **Alterações nos arquivos**:
   - Renomear `login.html` para `login.php`
   - Renomear `index.html` para `index.php`
   - Atualizar links e referências entre os arquivos

2. **Para o sistema de login**:
   - Modificar o formulário para apontar para um script de processamento PHP
   - Implementar a verificação de credenciais no banco de dados
   - Criar sistema de sessões para manter o usuário logado

3. **Para o sistema de permissões**:
   - Substituir o código JavaScript que oculta elementos para usuários não-admin por verificações PHP
   - Verificar o perfil do usuário armazenado na sessão
   - Renderizar condicionalmente os elementos da interface

4. **Para os formulários**:
   - Implementar a validação dos dados enviados
   - Processar as ações (adicionar, calcular, alugar, etc.)
   - Exibir mensagens de feedback após cada ação

Este front-end servirá como base sólida para a implementação do back-end, minimizando as alterações necessárias na estrutura HTML.