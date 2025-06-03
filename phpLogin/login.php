<?php
session_start();
require_once 'conexao.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    
    if (empty($email)) {
        $errors[] = "O email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Formato de email inválido.";
    }
    if (empty($senha)) {
        $errors[] = "A senha é obrigatória.";
    }
    
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM dados_pessoais WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['nivel'] = $user['nivel']; 
                header("Location: meusCursos.php");
                exit;
            } else {
                $errors[] = "Senha incorreta.";
            }
        } else {
            $errors[] = "Usuário não encontrado.";
        }
    }
}



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Oneway Línguas</title>
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
    .login-left {
      background: #ffffff;
      width: 350px;
      max-width: 30%;
      height: 100vh;
      flex: 1 1 350px;
      padding: 40px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      flex-wrap: wrap;

    }
    .logo-container {
      margin-bottom:45px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .logo-container img {
      height: 150px;
      margin-right: 10px;
      display: flex;
      justify-content:center;
    }
    .login-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 20px;
    }
    .login-form label {
      font-weight: bold;
      color: #555;
    }
    .login-form input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
    }
    .login-form input:focus {
      border-color: #4A90E2;
      outline: none;
    }
    .login-form button {
      padding: 12px;
      background-color: #4A90E2;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .login-form button:hover {
      background-color: #357ABD;
    }
    .extras {
      display: flex;
      justify-content: space-between;
      align-items: center;
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
 
    @media(max-width: 768px) {
      .login-container {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
    <div class="login-left">
      <div class="logo-container">
        <img src="src/Principal.png" alt="Logo Oneway Línguas">
      </div>

      <form class="login-form" action="" method="post">
        <label for="email">E-mail</label>
        <input 
          type="email" 
          name="email" 
          id="email" 
          placeholder="exemplo@dominio.com"
          required
        >

        <label for="senha">Senha</label>
        <input 
          type="password" 
          name="senha" 
          id="senha" 
          placeholder="Digite sua senha"
          required
        >

        <button type="submit">Acessar</button>
      </form>

      <div class="extras">
        <a href="registro.php">Não tem uma conta? Cadastre-se</a>
      </div>

    </div>
  </body>
</html>
