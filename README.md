# Projeto Final Dev Evolution

## Instruções para rodar o projeto/sistema

## Diagrama simples do funcionamento

## Explicação dos bônus

## Checklist do que foi implementado
### Usuários

- [X]  Criar (cadastro via formulário HTML)
- [ ]  Editar e deletar (somente próprios dados)
- [ ]  Ver (lista restrita)

### Ingressos

- [ ]  Criar, editar, deletar, visualizar
- [ ]  Reserva de estoque em tempo real (com `data_reserva`)
- [ ]  Bloqueio por 2 minutos ao acessar o último item

### Clientes

- [ ]  Criar, editar, deletar (restrito por usuário)
- [ ]  Visualização restrita por usuário (não veem outros clientes)

### Compras

- [ ]  Comprar produto, com controle de estoque
- [ ]  Cancelar reserva após timeout (2 minutos)
- [ ]  Exibir mensagem de "Produto indisponível" se esgotado

### Segurança
- [X]  Todos os dados enviados via formulário devem ser **validados e limpos** (`htmlspecialchars`, `filter_var` etc.).
- [ ]  Autenticação feita pelo session do PHP deve ser verificada em **todas as páginas protegidas**.
- [ ]  Ações sensíveis (deletar, editar) devem verificar se o usuário **tem permissão**.