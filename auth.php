<?php
session_start();

if (isset($_GET['code'])) {
    // Processar autenticação com GitHub
    // Receber dados do usuário e salvar na sessão
    $_SESSION['user'] = 'usuario_github'; // Substitua pelo dado real recebido
    header('Location: index.php');
    exit();
} else {
    // Redirecionar para o GitHub para autenticação
    $clientId = 'SUA_CLIENT_ID';
    $redirectUri = 'http://seusite.com/auth.php';
    $url = "https://github.com/login/oauth/authorize?client_id=$clientId&redirect_uri=$redirectUri";
    header('Location: ' . $url);
    exit();
}
