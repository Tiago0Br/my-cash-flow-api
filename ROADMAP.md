# Roadmap de Desenvolvimento: My Cashflow API

Este documento contém uma lista de solicitações de novas funcionalidades para o sistema, simulando demandas de um cliente real. O objetivo é aprofundar os conhecimentos em PHP, utilizando boas práticas, padrões de projeto e queries SQL mais complexas.

## 1. Transferências entre Contas (Transações de Banco de Dados)
**História do Usuário:** "Muitas vezes eu transfiro dinheiro da minha conta corrente para a conta poupança. Hoje eu tenho que criar uma 'Saída' em uma conta e uma 'Entrada' na outra manualmente. Seria muito mais fácil se existisse um recurso de 'Transferência' que fizesse isso automaticamente."

**Desafio Técnico:** Utilizar transações de banco de dados (ACID) para garantir que ou as duas operações (débito e crédito) aconteçam, ou nenhuma aconteça em caso de erro, mantendo a consistência dos dados.

- [ ] Criar endpoint `POST /transfers` que receba `conta_origem_id`, `conta_destino_id`, `valor` e `data`.
- [ ] Validar se as duas contas pertencem ao mesmo usuário autenticado.
- [ ] Implementar a lógica no Service utilizando `PDO::beginTransaction()`, `commit()` e `rollback()`.
- [ ] Registrar as duas transações interligadas no banco de dados (opcional: criar uma coluna `transfer_group_id` ou tabela de transferências para vincular as duas pontas).
- [ ] Documentar o endpoint no Swagger.

## 2. Orçamentos Mensais por Categoria (Lógica de Negócio e Agregação)
**História do Usuário:** "Eu gostaria de definir um limite de gastos por categoria a cada mês (por exemplo, no máximo R$ 800,00 em 'Alimentação') e ser capaz de consultar o quanto eu ainda tenho disponível desse orçamento conforme vou registrando minhas despesas."

**Desafio Técnico:** Modelagem de novos dados e cruzamento de informações de tabelas diferentes para calcular o saldo disponível em tempo real.

- [ ] Criar tabela e Entidade `Budget` (Orçamento) com campos como `user_id`, `category_id`, `amount_limit`, `month`, `year`.
- [ ] Criar CRUD para gerenciar os Orçamentos (Endpoints para criar, editar, listar e excluir).
- [ ] Criar um endpoint `GET /budgets/status` que calcule e retorne o limite definido, o quanto já foi gasto no mês para a categoria, e o saldo restante.
- [ ] (Bônus/Design Pattern) Implementar um Event Dispatcher / Observer: toda vez que uma Transação for criada, verificar se ela ultrapassa 80% do orçamento da categoria e registrar um "alerta" (pode ser na tabela de logs para simplificar).

## 3. Relatórios e Dashboard Consolidado (Queries SQL Complexas)
**História do Usuário:** "Preciso de um endpoint que me traga um 'resumo do mês' para que eu possa montar gráficos no front-end. Quero ver o total de receitas, total de despesas, saldo do mês e o total gasto agrupado por categoria (ex: 30% moradia, 20% alimentação)."

**Desafio Técnico:** Escrever consultas SQL complexas usando `GROUP BY`, `JOIN`s, e funções de agregação (`SUM()`), garantindo performance ao invés de buscar todos os registros e somar no PHP.

- [ ] Criar um endpoint `GET /reports/monthly-summary?month=X&year=Y`.
- [ ] Implementar um método no Repositório que retorne o total de receitas e despesas do período.
- [ ] Implementar um método no Repositório que agrupe os gastos por categoria e calcule o valor total e o percentual de cada uma.
- [ ] Retornar os dados formatados em um DTO específico de Relatório.

## 4. Transações Recorrentes e Parceladas (Lógica de Datas e Filas/Jobs)
**História do Usuário:** "Assinaturas como Netflix e Spotify, ou a conta de luz, repetem todo mês. Eu queria cadastrar isso apenas uma vez e pedir para o sistema repetir pelos próximos X meses. Também seria ótimo cadastrar compras parceladas no cartão de crédito."

**Desafio Técnico:** Manipulação complexa de datas (DateTime) no PHP e geração de múltiplos registros a partir de um único request.

- [ ] Modificar o endpoint de criação de transações para aceitar os campos opcionais: `is_recurring`, `recurrence_type` (mensal, semanal) e `installments_count` (número de parcelas).
- [ ] Implementar no Service a lógica que, baseada nesses campos, gera os múltiplos registros no banco de dados com as datas de vencimento corretas (cuidado com meses que não tem dia 29, 30 ou 31).
- [ ] No caso de compras parceladas, adicionar automaticamente no campo de descrição algo como "(1/3)", "(2/3)", etc.

## 5. Importação de Dados via Arquivo (Manipulação de Arquivos)
**História do Usuário:** "Migrar para o seu aplicativo é difícil porque tenho centenas de registros em uma planilha no Excel. Queria poder fazer o upload de um arquivo CSV e o sistema já cadastrar todas as transações para mim."

**Desafio Técnico:** Lidar com requisições `multipart/form-data`, processamento de arquivos em disco, validação de lotes (batch processing) de dados.

- [ ] Criar um endpoint `POST /transactions/import` que receba um arquivo CSV.
- [ ] Ler o arquivo utilizando as funções nativas do PHP (ex: `fgetcsv`) ou alguma biblioteca apropriada.
- [ ] Validar as linhas do CSV (garantir que valores numéricos sejam números, datas sejam válidas, etc).
- [ ] Fazer a inserção em lote (Bulk Insert) no banco de dados para melhorar a performance.
- [ ] Retornar um resumo da importação (ex: "50 registros importados com sucesso, 2 falharam").

## 6. Fluxo de Recuperação de Senha (Segurança e Simulação de E-mail)
**História do Usuário:** "Esqueci minha senha e agora não consigo mais acessar minhas finanças! Preciso de um botão de 'Esqueci minha senha' que me mande um link seguro para cadastrar uma nova."

**Desafio Técnico:** Geração de tokens seguros, controle de expiração (TTL), e integração com serviços externos (envio de e-mail).

- [ ] Criar tabela `password_resets` no banco de dados para armazenar `email`, `token` e `expires_at`.
- [ ] Criar endpoint `POST /auth/forgot-password` que receba o e-mail, gere um token aleatório seguro (ex: `bin2hex(random_bytes())`) e salve no banco.
- [ ] Simular o envio do e-mail (você pode usar ferramentas como o Mailtrap ou apenas escrever no arquivo de log temporariamente).
- [ ] Criar endpoint `POST /auth/reset-password` que receba o `token` e a `nova_senha`, valide a existência e validade do token, atualize o hash da senha do usuário e invalide o token.
