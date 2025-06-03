<?php
session_start();
require_once 'conexao.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $nivel  = trim($_POST['nivel']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    
    if (empty($nome)) {
        $errors[] = "O nome é obrigatório.";
    }
    if (empty($nivel)) {
      $errors[] = "O nível é obrigatório.";
  }
    if (empty($email)) {
        $errors[] = "O email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Formato de email inválido.";
    }
    if (empty($senha)) {
        $errors[] = "A senha é obrigatória.";
    }
    
    
    $stmt = $pdo->prepare("SELECT * FROM dados_pessoais WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email já cadastrado.";
    }
    
    if (empty($errors)) {
       
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO dados_pessoais (nome, nivel, email, senha) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nome, $nivel, $email, $hash])) {
            $_SESSION['success'] = "Cadastro realizado com sucesso! Faça login.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Erro ao cadastrar usuário.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Oneway Línguas</title>
  <link rel="icon" href="../sistema/img/icone.ico" type="image/x-icon">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      padding-left: 3%;
      background-image: url('src/fundoLogin.png');
      background-size: cover;
      background-repeat: no-repeat;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      height: 100%;
    }

    .cadastro-left {
      background: #ffffff;
      width: 450px;
      max-width: 30%;
      height: 110vh;
      padding: 40px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .logo-container {
      margin-bottom: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .logo-container img {
      height: 100px;
    }

    .cadastro-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 20px;
    }

    .cadastro-form label {
      font-weight: bold;
      color: #555;
    }

    .cadastro-form input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
    }

    .cadastro-form input:focus {
      border-color: #4A90E2;
      outline: none;
    }

    .cadastro-form button {
      padding: 12px;
      background-color: #4A90E2;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .cadastro-form button:hover {
      background-color: #357ABD;
    }

    .extras {
      margin-top: 10px;
    }

    .extras a {
      text-decoration: none;
      color: #4A90E2;
      font-size: 0.9rem;
      transition: color 0.3s ease;
    }

    .extras a:hover {
      color: #357ABD;
    }

  </style>
</head>
<body>
  <div class="cadastro-left">
    <div class="logo-container">
      <img src="src/Principal.png" alt="Logo Oneway Línguas">
    </div>
    <form class="cadastro-form" action="registro.php" method="post">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" placeholder="Nome completo" required>

      <label for="nivel">Nível</label>
      <input type="text" name="nivel" id="nivel" placeholder="NS1 or TW5" required>

      <label for="email">E-mail</label>
      <input type="email" name="email" id="email" placeholder="exemplo@dominio.com" required>

      <label for="senha">Senha</label>
      <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

      <button type="submit">Cadastrar</button>
    </form>
    <div class="extras">
      <a href="login.php">Já tem uma conta? Login</a>
    </div>
  </div>
</body>
</html>
