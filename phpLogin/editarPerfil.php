<?php
session_start();
require_once 'conexao.php';


if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}



$userId = $_SESSION['user_id'];



$stmtUser = $pdo->prepare("SELECT nome, nivel, email, senha FROM dados_pessoais WHERE id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);



if (!$user) {
  header("Location: login.php");
  exit;
}


$errors = [];
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $novoEmail  = trim($_POST['email'] ?? '');
    $novaSenha  = trim($_POST['senha'] ?? '');

  
    if (empty($novoEmail)) {
        $errors[] = "O email é obrigatório.";
    } elseif (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Formato de email inválido.";
    }

   
    if (empty($errors)) {
        $stmtCheck = $pdo->prepare("SELECT id FROM dados_pessoais WHERE email = ? AND id != ?");
        $stmtCheck->execute([$novoEmail, $userId]);
        if ($stmtCheck->rowCount() > 0) {
            $errors[] = "Este email já está em uso por outro usuário.";
        }
    }

 
    if (empty($errors)) {
      
        if (!empty($novaSenha)) {
           
            $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $stmtUpdate = $pdo->prepare("UPDATE dados_pessoais SET email = ?, senha = ? WHERE id = ?");
            $updateOk = $stmtUpdate->execute([$novoEmail, $hash, $userId]);
        } else {
        
            $stmtUpdate = $pdo->prepare("UPDATE dados_pessoais SET email = ? WHERE id = ?");
            $updateOk = $stmtUpdate->execute([$novoEmail, $userId]);
        }

        if ($updateOk) {
            $successMessage = "Dados atualizados com sucesso!";
           
            $_SESSION['email'] = $novoEmail;
        } else {
            $errors[] = "Erro ao atualizar dados no banco de dados.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil - OneWay</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
 
  <link rel="icon" href="../sistema/img/icone.ico" type="image/x-icon">

 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap">


  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif; 
    }


    body {
      background-color: #F0F2F5; 
      color: #2C3E50;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #fff;      
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      z-index: 999;
      transition: height 0.3s ease, box-shadow 0.3s ease;
    }
    header.shrink {
      height: 60px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .navbar {
      max-width: 1200px;
      margin: 0 auto;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem;
      transition: height 0.3s ease;
    }
    header.shrink .navbar {
      height: 60px;
    }
    .navbar .logo img {
      height: 50px;
      width: auto;
      display: block;
      transition: height 0.3s ease;
    }
    header.shrink .navbar .logo img {
      height: 40px;
    }
    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
      transition: all 0.3s ease;
      decoration:none;
    }
    .nav-links li a {
      font-weight: 500;
      padding: 0.5rem 0.8rem;
      border-radius: 4px;
      transition: background-color 0.3s, color 0.3s;
      text-decoration: none;
      color:black;
      list-style: none;
    }
    .nav-links li a:hover {
      color: #FF5466;
      background-color: #f0f0f0;
    }
    .dropbtn {
      background-color: transparent;
      border: none;
      padding: 10px;
      cursor: pointer;
      font-weight: bold;
    }
    .dropdown {
      position: relative;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: white;
      min-width: 160px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      z-index: 1;
    }
    .dropdown-content a {
      color: black;
      padding: 10px 15px;
      text-decoration: none;
      display: block;
      border-radius: 3px;
    }
    .dropdown-content a:hover {
      background-color: #4A90E2;
      color: white;
    }
    .show {
      display: block;
    }
    .menu-icon {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }
    @media (max-width: 900px) {
      .nav-links {
        position: fixed;
        top: 0;
        right: 0;
        width: 0;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.95);
        overflow: hidden;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: width 0.3s ease;
        z-index: 998;
      }
      .nav-links.open {
        width: 70%;
        max-width: 300px;
      }
      .nav-links li {
        margin: 1rem 0;
      }
      .menu-icon {
        display: block;
      }
    }

    main {
      margin-top: 70px; 
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .cadastro-left {
      background: #ffffff;
      width: 450px;
      padding: 40px 30px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    .logo-container {
      margin-bottom: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .logo-container img {
      height: 80px;
    }
    .cadastro-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 20px;
    }
    .cadastro-form label {
      font-weight: 600;
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
    .error-message {
      color: red;
      font-size: 0.9rem;
      margin-bottom: 5px;
    }
    .success-message {
      color: green;
      font-size: 0.9rem;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>

  <header id="header">
    <div class="navbar">
      <div class="logo">
        <a href="../index.php">
          <img src="../sistema/img/logo.png" alt="Logo OneWay">
        </a>
      </div>
      <i class="fas fa-bars menu-icon" id="menuIcon"></i>
      <ul class="nav-links" id="navLinks">
        <li><a href="#">Home</a></li>
        <li><a href="#">Cursos</a></li>
        <li><a href="#">FAQ</a></li>
        <div class="dropdown">
          <button class="dropbtn" onclick="toggleDropdown()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <g fill="#FFF" stroke="#000" stroke-width="1">
                <path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/>
                <circle cx="12" cy="7" r="3"/>
              </g>
            </svg>
          </button>
          <div class="dropdown-content" id="dropdownMenu">
            <a href="perfil.php">Perfil</a>
            <a href="#">Notas</a>
            <a href="#">Calendário</a>
            <a href="perfil.php">Relatórios</a>
            <a href="#">Preferências</a>
            <a href="#">Idioma</a>
            <a href="logout.php">Sair</a>
          </div>
        </div>
      </ul>
    </div>
  </header>

  <main>
    <div class="cadastro-left">
      <div class="logo-container">
        <img src="src/Principal.png" alt="Logo Oneway Línguas">
      </div>
      <form class="cadastro-form" action="#" method="post">
        <label for="email">Novo E-mail</label>
        <input type="email" name="email" id="email" placeholder="exemplo@dominio.com" required>

        <label for="senha">Nova Senha</label>
        <input type="password" name="senha" id="senha" placeholder="Se não quiser alterar, deixe em branco">

        <button type="submit">Salvar Alterações</button>
      </form>
      <div class="extras">
        <a href="perfil.php">Voltar ao Perfil</a>
      </div>
    </div>
  </main>







  <script>
    
    function toggleDropdown() {
      document.getElementById("dropdownMenu").classList.toggle("show");
    }
    
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn') && !event.target.closest('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }

    
    const menuIcon = document.getElementById('menuIcon');
    const navLinks = document.getElementById('navLinks');
    if(menuIcon) {
      menuIcon.addEventListener('click', () => {
        navLinks.classList.toggle('open');
      });
    }
  </script>
</body>
</html>
