<?php
session_start();


if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}


if (!isset($_SESSION['nivel'])) {
  require_once 'conexao.php';
  $stmt = $pdo->prepare("SELECT nivel FROM dados_pessoais WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    $_SESSION['nivel'] = $user['nivel'];
  } else {
    header("Location: login.php");
    exit;
  }
}


$nivel = trim($_SESSION['nivel']);


$student_id = $_SESSION['user_id'];
$cursoAluno = $nivel;


require_once 'conexao.php';
$stmt = $pdo->prepare("
    SELECT nome_atividade, nota, data_atribuicao
    FROM avaliacoes
    WHERE id_aluno = ? AND curso = ?
    ORDER BY data_atribuicao DESC
");
$stmt->execute([$student_id, $cursoAluno]);
$avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Zoom Meeting - NS<?php echo htmlspecialchars($nivel, ENT_QUOTES, 'UTF-8'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../sistema/img/icone.ico" type="image/x-icon">
  
  
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

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


    .sidebar {
      width: 260px;
      background-color: var(--content-bg);
      color: #495057;
      height: calc(100vh - 70px);
      position: fixed;
      top: 0;
      left: 0;
      overflow-y: auto;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.15);
      margin-top: 70px;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar li {
      padding: 12px 15px;
      border-radius: 4px;
      margin-bottom: 10px;
      transition: background-color 0.3s ease;
      cursor: pointer;
      font-size: 16px;
    }
    .sidebar li:hover {
      background-color: var(--sidebar-hover);
    }
    .has-submenu {
      display: flex;
      flex-direction: column;
      align-items: start;
      justify-content: space-between;
    }
    .menu-title {
      text-align: start;
      margin-bottom: 8px;
      height:100%;
    }
    .arrow {
      transition: transform 0.3s ease;
      margin-right: 15px;
      font-size: 14px;
    }
    .arrow.open {
      transform: rotate(180deg);
    }
    .submenu {
      list-style: none;
      padding: 0 0 0 15px;
      margin: 0;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    .submenu li {
      margin-bottom: 8px;
      font-size: 14px;
      cursor: pointer;
    }
    .submenu.open {
      max-height: 500px;
    }

   
    .content {
      margin-left: 280px;
      padding: 40px;
      max-width: 1000px;
      margin-top: 80px;
    }
    .initial {
      height: 260px;
      border-radius: 8px;
      border: 1px solid var(--box-border);
      margin-bottom: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      background-image: url('../sistema/img/fundoCard.png');
      background-size: cover;
      background-repeat: no-repeat;
      display: flex;
      align-items: start;
      justify-content: start;
      padding: 50px;
    }
    .main {
      color: #FFF;
      font-weight: 500;
      font-size: 50px;
    }
    .meeting-info,
    .details,
    .security {
      background-color: var(--box-bg);
      padding: 25px;
      border-radius: 8px;
      border: 1px solid var(--box-border);
      margin-bottom: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .meeting-info h2 {
      margin-top: 0;
      color: var(--text-primary);
      font-size: 24px;
    }
    .meeting-info p,
    .details p,
    .security p {
      margin: 10px 0;
      line-height: 1.5;
      color: var(--text-secondary);
      font-size: 16px;
    }
    .download-btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: var(--button-bg);
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 16px;
      text-decoration: none;
    }
    .download-btn:hover {
      background-color: var(--button-hover);
    }
    .status {
      font-weight: bold;
      padding: 10px;
      border-radius: 4px;
      background-color: var(--status-warning-bg);
      color: var(--status-warning-text);
      font-size: 16px;
    }
    .alinha {
      display: flex;
      flex-direction: row;
      justify-content: start;
      padding: 0;
      margin: 0;
    }


    .avaliacoes {
      background-color: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      margin-top: 30px;
    }
    .avaliacoes h2 {
      margin-bottom: 15px;
      color: #2c3e50;
    }
    .avaliacoes ul {
      list-style: none;
      padding-left: 0;
    }
    .avaliacoes li {
      background: #fdfdfd;
      padding: 12px;
      margin-bottom: 10px;
      border: 1px solid #eee;
      border-radius: 4px;
      font-size: 15px;
    }
    .avaliacoes li strong {
      color: #2980b9;
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
      <li><a href="#hero">Home</a></li>
      <li><a href="#cursos">Cursos</a></li>
      <li><a href="#faq">FAQ</a></li>
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
          <a href="#avaliacoes">Notas</a>
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


<div class="sidebar">
  <ul>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Anouncements</span>
      </div>
      <ul class="submenu">
        <li>Avisos e Comunicados</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Discussion Forum</span>
      </div>
      <ul class="submenu">
        <li>New Season 8 Doubts and Questions</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Zoom meetings</span>
      </div>
      <ul class="submenu">
        <li>NS8 - 08:00 AM</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Classroom Material</span>
      </div>
      <ul class="submenu">
        <li>Teacher Givanna</li>
        <li>Teacher Dirce</li>
        <li>Teacher Juliana</li>
        <li>Teacher Camila</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Unit 1 - Business</span>
      </div>
      <ul class="submenu">
        <li>Lesson 1A - Getting things done</li>
        <li>Lesson 1B - My town</li>
        <li>Unit 1 Review Quiz</li>
        <li>Unit 1 Written Check Out</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Unit 2 - Well-being</span>
      </div>
      <ul class="submenu">
        <li>Lesson 2A - Useful Advice</li>
        <li>Lesson 2B - It worked really well</li>
        <li>Unit 2 Review Quiz</li>
        <li>Unit 2 Written Check Out</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Unit 3 - City Living</span>
      </div>
      <ul class="submenu">
        <li>Lesson 3A - My kind of town</li>
        <li>Lesson 3B - Life in the city</li>
        <li>Unit 3 Review Quiz</li>
        <li>Unit 3 Written Check Out</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Unit 4 - Ecology</span>
      </div>
      <ul class="submenu">
        <li>Lesson 4A - The world around us</li>
        <li>Lesson 4B - What can be done?</li>
        <li>Unit 4 Review Quiz</li>
        <li>Unit 4 Written Check Out</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Unit 5 - Language and Culture</span>
      </div>
      <ul class="submenu">
        <li>Lesson 5A - You live and learn</li>
        <li>Lesson 5B - Language learning</li>
        <li>Unit 5 Review Quiz</li>
        <li>Unit 5 Written Check Out</li>
      </ul>
    </li>
    <li class="has-submenu">
      <div class="alinha">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
          <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
        </svg>
        <span class="menu-title">Unit 6 - Fame</span>
      </div>
      <ul class="submenu">
        <li>Lesson 6A - Celebrities</li>
        <li>Lesson 6B - What could have happened?</li>
        <li>Unit 6 Review Quiz</li>
        <li>Unit 6 Written Check Out</li>
      </ul>
    </li>

    
    <?php if (strtolower($nivel) === 'professor'): ?>
      <li class="has-submenu">
        <div class="alinha">
          <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 1024 1024">
            <path fill="currentColor" d="M831.872 340.864L512 652.672L192.128 340.864a30.59 30.59 0 0 0-42.752 0a29.12 29.12 0 0 0 0 41.6L489.664 714.24a32 32 0 0 0 44.672 0l340.288-331.712a29.12 29.12 0 0 0 0-41.728a30.59 30.59 0 0 0-42.752 0z"/>
          </svg>
          <span class="menu-title">Atribuir Nota</span>
        </div>
        <ul class="submenu">
          <li><a href="atribuirNota.php?curso=1">Nível 1</a></li>
          <li><a href="atribuirNota.php?curso=2">Nível 2</a></li>
          <li><a href="atribuirNota.php?curso=3">Nível 3</a></li>
          <li><a href="atribuirNota.php?curso=4">Nível 4</a></li>
          <li><a href="atribuirNota.php?curso=5">Nível 5</a></li>
          <li><a href="atribuirNota.php?curso=6">Nível 6</a></li>
          <li><a href="atribuirNota.php?curso=7">Nível 7</a></li>
          <li><a href="atribuirNota.php?curso=8">Nível 8</a></li>
        </ul>
      </li>

      
    <?php endif; ?>

  </ul>
</div>


<div class="content">
  <div class="initial">
    <div class="main">New Season <?php echo htmlspecialchars($nivel, ENT_QUOTES, 'UTF-8'); ?></div>
  </div>

  <div class="meeting-info">
    <h2>Teacher Duda NS8 SAT 08:00</h2>
    <p><strong>Início:</strong> Sábado, 22 de Março 2025, 08:10 AM</p>
    <p class="status">Você não pode entrar no momento. A reunião ainda não começou.</p>
  </div>

  <div class="details">
    <h3>Reunião Recorrente</h3>
    <p><strong>Próxima:</strong> Sábado, 22 de Março 2025, 08:10 AM</p>
    <p><strong>Duração:</strong> 2 horas</p>
    <button class="download-btn">Baixar iCal</button>
  </div>

  <div class="security">
    <h3>Segurança</h3>
    <p>Sala de Espera: Sim</p>
    <p>Criptografia: Avançada</p>
  </div>

  <div class="avaliacoes">
    <h2>Suas Notas e Atividades</h2>
    <?php if ($avaliacoes): ?>
      <ul>
        <?php foreach ($avaliacoes as $item): ?>
          <li>
            <strong>Atividade:</strong> <?php echo htmlspecialchars($item['nome_atividade'], ENT_QUOTES, 'UTF-8'); ?><br>
            <strong>Nota:</strong> <?php echo htmlspecialchars($item['nota'], ENT_QUOTES, 'UTF-8'); ?><br>
            <small>Data: <?php echo htmlspecialchars($item['data_atribuicao'], ENT_QUOTES, 'UTF-8'); ?></small>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>Nenhuma nota ou atividade registrada ainda.</p>
    <?php endif; ?>
  </div>
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
  document.addEventListener('DOMContentLoaded', function() {
    const statusElement = document.querySelector('.status');
    const currentTime = new Date();
    const meetingTime = new Date('March 22, 2025 08:10:00');
    if (currentTime >= meetingTime) {
      statusElement.textContent = 'Você pode entrar na reunião agora!';
      statusElement.style.backgroundColor = 'var(--status-success-bg)';
      statusElement.style.color = 'var(--status-success-text)';
    }
    const submenuToggles = document.querySelectorAll('.has-submenu');
    submenuToggles.forEach((toggle) => {
      toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        const submenu = this.querySelector('.submenu');
        const arrow = this.querySelector('.arrow');
        if (submenu.classList.contains('open')) {
          submenu.classList.remove('open');
          arrow.classList.remove('open');
        } else {
          submenuToggles.forEach((otherToggle) => {
            const otherSubmenu = otherToggle.querySelector('.submenu');
            const otherArrow = otherToggle.querySelector('.arrow');
            if (otherSubmenu && otherSubmenu !== submenu) {
              otherSubmenu.classList.remove('open');
            }
            if (otherArrow && otherArrow !== arrow) {
              otherArrow.classList.remove('open');
            }
          });
          submenu.classList.add('open');
          arrow.classList.add('open');
        }
      });
    });
  });
</script>

</body>
</html>
