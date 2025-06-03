<?php
session_start();
require_once 'conexao.php';


if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}


$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT nome, email, nivel FROM dados_pessoais WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  header("Location: login.php");
  exit;
}


$stmtA = $pdo->prepare("
    SELECT nome_atividade, nota, data_atribuicao
    FROM avaliacoes
    WHERE id_aluno = ?
    ORDER BY data_atribuicao DESC
    LIMIT 5
");
$stmtA->execute([$userId]);
$atividadesRecentes = $stmtA->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Perfil do Usuário - OneWay</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
  <link rel="icon" href="../sistema/img/icone.ico" type="image/x-icon">

 
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />


  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap">

  <style>
    
    :root {
      --primary:  #6596D0;
      --secondary: #FFBD30;
      --accent:   #FF5466;
      --dark: #222;
      --light: #f9f9f9;
      --gray: #888;
      --gradient-hero: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      
      --sidebar-hover: rgb(216, 222, 223);
      --content-bg: #ecf0f1;
      --box-bg: #ffffff;
      --box-border: #bdc3c7;
      --text-primary: #2C3E50;
      --text-secondary: #7f8c8d;
      --button-bg: #2980B9;
      --button-hover: #1A5276;
      --status-warning-bg: #f8d7da;
      --status-warning-text: #721c24;
      --status-success-bg: #d4edda;
      --status-success-text: #155724;
    }

   
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--content-bg);
      color: var(--text-primary);
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    ul {
      list-style: none;
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
    }
    .nav-links li a {
      font-weight: 500;
      padding: 0.5rem 0.8rem;
      border-radius: 4px;
      transition: background-color 0.3s, color 0.3s;
    }
    .nav-links li a:hover {
      color: var(--accent);
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

   
    .container {
      max-width: 1200px;
      margin: 100px auto 40px auto; 
      padding: 20px;
    }

    .page-title {
      font-size: 28px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 20px;
      text-align: center;
    }

    .dashboard {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* CARD GERAL */
    .card {
      background: var(--box-bg);
      border: 1px solid var(--box-border);
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 20px;
      flex: 1 1 300px;
      max-width: 400px;
      min-width: 280px;
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h2 {
      font-size: 20px;
      margin-bottom: 15px;
      color: var(--text-primary);
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      text-align: center;
    }
    .card p {
      font-size: 16px;
      color: var(--text-secondary);
      margin-bottom: 10px;
      text-align: center;
    }
    .btn {
      display: inline-block;
      background: var(--button-bg);
      color: #fff;
      padding: 10px 20px;
      border-radius: 4px;
      margin-top: 15px;
      transition: background 0.3s;
      text-decoration: none;
      text-align: center;
    }
    .btn:hover {
      background: var(--button-hover);
    }

    
    .profile-card {
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .profile-card .avatar {
      width: 100px;
      height: 100px;
      background: var(--primary);
      color: #fff;
      font-size: 40px;
      font-weight: 700;
      line-height: 100px;
      border-radius: 50%;
      margin-bottom: 15px;
    }
    .profile-card h3 {
      font-size: 22px;
      margin-bottom: 8px;
      color: var(--text-primary);
    }
    .profile-card p {
      color: var(--text-secondary);
      margin-bottom: 5px;
    }

   
    .footer {
      background-color: var(--primary);
      color: #fff;
      padding: 30px 0;
      text-align: center;
      margin-top: 50px;
    }
    .footer p {
      margin: 0;
      font-size: 14px;
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


<div class="container">
  <h1 class="page-title">Bem-vindo(a) ao seu Perfil</h1>

  <div class="dashboard">
    
    <div class="card profile-card">
      <div class="avatar">
        <?php
          $nome = trim($user['nome']);
          $inicial = strtoupper(substr($nome, 0, 1));
          echo $inicial;
        ?>
      </div>
      <h3><?php echo htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8'); ?></h3>
      <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></p>
      <p><i class="fas fa-level-up-alt"></i> Nível: <?php echo htmlspecialchars($user['nivel'], ENT_QUOTES, 'UTF-8'); ?></p>
      <a href="editarPerfil.php" class="btn">Editar Perfil</a>
    </div>

    
    
<div class="card">
  <h2>Avaliações:</h2>

  <?php if ($atividadesRecentes): ?>
    <ul style="list-style: none; padding-left: 0;">
      <?php foreach ($atividadesRecentes as $atividade): ?>
        <li style="margin-bottom: 10px;">
          <strong><?php echo htmlspecialchars($atividade['nome_atividade'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
          Nota: <?php echo htmlspecialchars($atividade['nota'], ENT_QUOTES, 'UTF-8'); ?><br>
          <small>
            Data: 
            <?php 
            
              $data = date('d/m/Y H:i', strtotime($atividade['data_atribuicao']));
              echo $data;
            ?>
          </small>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>Nenhuma nota foi registrada até o momento.</p>
  <?php endif; ?>
</div>


    
    <div class="card">
      <h2>Estatísticas</h2>
      <p>Você está progredindo muito bem em seu curso!</p>
      <p>Continue assim para concluir o nível <strong><?php echo htmlspecialchars($user['nivel'], ENT_QUOTES, 'UTF-8'); ?></strong>!</p>
     
    </div>
  </div>
</div>


<div class="footer">
  <p>&copy; <?php echo date('Y'); ?> OneWay Línguas. Todos os direitos reservados.</p>
</div>


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
