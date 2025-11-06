# PHP CRUD MVC — Personagens

Projeto exemplo: CRUD em PHP seguindo um padrão MVC simples para gerenciar "personagens" com campos:
- nome
- franquia
- descrição

Estrutura mínima criada:

- `index.php` — front controller / roteador simples
- `config/database.php` — conexão PDO (PostgreSQL) com criação automática do banco e da tabela
- `models/Personagem.php` — model com métodos CRUD
- `controllers/PersonagemController.php` — controller com ações
- `views/` — views (layout + personagens)

Observação: o projeto cria automaticamente o banco `personagens` e a tabela `tabela_personagens` na primeira conexão com o PostgreSQL.

Como usar (PostgreSQL / Windows)

1. Instale o PostgreSQL se ainda não tiver (https://www.postgresql.org/download/windows/)
2. Copie/clone este projeto para `c:\xampp\htdocs\php-crud-docker`
3. Ajuste credenciais em `config/database.php` se necessário:
   ```php
   $host = 'localhost';  // ou IP do servidor PostgreSQL
   $port = '5432';       // porta padrão do PostgreSQL
   $user = 'postgres';   // seu usuário
   $pass = 'postgres';   // sua senha
   ```
4. Certifique-se que a extensão `pdo_pgsql` está habilitada no PHP (php.ini)
5. Abra no navegador: http://localhost/php-crud-docker/index.php

Notas rápidas
- O banco `personagens` e a tabela `tabela_personagens` serão criados automaticamente na primeira conexão
- A tabela usa SERIAL para auto-incremento do ID
- Em produção ajuste as credenciais, valide melhor os inputs e adicione proteção CSRF