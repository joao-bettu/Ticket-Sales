# Projeto Final Dev Evolution

## Instruções para rodar o projeto/sistema
1. Inicar o server com "php -S localhost:8000"
2. Acessar "http://127.0.0.1:8000/public/login.html"
3. 

## Diagrama simples do funcionamento

## Explicação dos bônus

## Checklist do que foi implementado
### Usuários

- [X]  Criar (cadastro via formulário HTML)
- [X]  Editar e deletar (somente próprios dados)
- [X]  Ver (lista restrita)

### Ingressos

- [X]  Criar, editar, deletar, visualizar
- [X]  Reserva de estoque em tempo real (com `data_reserva`)
- [X]  Bloqueio por 2 minutos ao acessar o último item

### Clientes

- [X]  Criar, editar, deletar (restrito por usuário)
- [X]  Visualização restrita por usuário (não veem outros clientes)

### Compras

- [X]  Comprar produto, com controle de estoque
- [X]  Cancelar reserva após timeout (2 minutos)
- [X]  Exibir mensagem de "Produto indisponível" se esgotado

### Segurança
- [X]  Todos os dados enviados via formulário devem ser **validados e limpos** (`htmlspecialchars`, `filter_var` etc.).
- [X]  Autenticação feita pelo session do PHP deve ser verificada em **todas as páginas protegidas**.
- [X]  Ações sensíveis (deletar, editar) devem verificar se o usuário **tem permissão**.