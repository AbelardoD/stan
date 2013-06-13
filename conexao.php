<?php
$dsn = "mysql:host={$servidorDB};dbname={$nomeDB};charset=utf8";

$opcoes = array(
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_CASE => PDO::CASE_LOWER
);

try {
    $pdo = new PDO($dsn, $usernameDB, $passwordDB, $opcoes);
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    echo 'Erro: '.$e->getMessage();
}
?>