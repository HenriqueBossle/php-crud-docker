<?php
// Carregar variáveis do .env
function loadEnv() {
    $envFile = __DIR__ . '/../.env';
    if (!file_exists($envFile)) {
        die('.env file not found. Please create one based on .env.example');
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }

    // Normalizar nomes comuns
    if (isset($_ENV['DB_DATABASE']) && !isset($_ENV['DB_NAME'])) {
        $_ENV['DB_NAME'] = $_ENV['DB_DATABASE'];
    }
    if (isset($_ENV['DB_USERNAME']) && !isset($_ENV['DB_USER'])) {
        $_ENV['DB_USER'] = $_ENV['DB_USERNAME'];
    }
    if (isset($_ENV['DB_PASSWORD']) && !isset($_ENV['DB_PASS'])) {
        $_ENV['DB_PASS'] = $_ENV['DB_PASSWORD'];
    }
}

// Arquivo de configuração da conexão PDO (PostgreSQL)
function getPDO()
{
    static $pdo = null;
    if ($pdo) return $pdo;

    // Carrega variáveis do .env
    loadEnv();

    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? '5432';
    $dbName = $_ENV['DB_NAME'] ?? 'personagens';
    $user = $_ENV['DB_USER'] ?? $_ENV['DB_USERNAME'] ?? 'postgres';
    $pass = $_ENV['DB_PASS'] ?? $_ENV['DB_PASSWORD'] ?? 'postgres';
    $sslmode = $_ENV['DB_SSLMODE'] ?? null;

    // validar nome do banco para evitar injeção em identificadores
    if (!preg_match('/^[A-Za-z0-9_]+$/', $dbName)) {
        die('DB_NAME contém caracteres inválidos.');
    }

    // DSN para conectar ao banco padrão (postgres) e para o DB alvo
    $dsnBase = "pgsql:host=$host;port=$port";
    $dsnNoDb = $dsnBase . ";dbname=postgres";
    $dsnWithDb = $dsnBase . ";dbname=$dbName";
    if ($sslmode) {
        $dsnNoDb .= ";sslmode=$sslmode";
        $dsnWithDb .= ";sslmode=$sslmode";
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // Conecta ao PostgreSQL usando o DB 'postgres' para operações administrativas
        $pdo = new PDO($dsnNoDb, $user, $pass, $options);

        // Verifica se o banco existe
        $stmt = $pdo->prepare('SELECT 1 FROM pg_database WHERE datname = :dbname');
        $stmt->execute(['dbname' => $dbName]);
        if (!$stmt->fetch()) {
            // Tenta criar o banco (pode falhar se o usuário não tiver permissão)
            $pdo->exec('CREATE DATABASE "' . $dbName . '"');
        }

        // Reconecta selecionando o banco desejado
        $pdo = new PDO($dsnWithDb, $user, $pass, $options);

        // Criar tabela se não existir (usando SERIAL para autoincrement)
        $createTableSql = "CREATE TABLE IF NOT EXISTS tabela_personagens (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            franquia VARCHAR(255) DEFAULT NULL,
            descricao TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";
        $pdo->exec($createTableSql);

        return $pdo;
    } catch (PDOException $e) {
        // Em ambiente real não exibir detalhes sensíveis
        echo "Erro conectando ao banco: " . $e->getMessage();
        exit;
    }
}