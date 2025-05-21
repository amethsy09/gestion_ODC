<?php
// helpers/functions.php
// require_once __DIR__ . '/../config/database.php';

function connectDB() {
    $host = 'localhost';
    $port = '5432';
    $dbname = 'gestion_odc';
    $username = 'postgres';
    $password = 'aichaly7654321';

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // echo "Connexion réussie !"; // Debug
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
