<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require_once 'conexao.php';


if (!isset($_SESSION['nivel'])) {
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


if (strtolower($nivel) === 'professor') {
    $cursos = [];
    for ($i = 1; $i <= 8; $i++) {
        $cursos[] = [
            'titulo'    => 'New Season ' . $i,
            'subtitulo' => 'New Season',
            'progresso' => 0,
            'numero'    => (string)$i
        ];
    }
} else {
   
    $cursos = [
        [
            'titulo'    => 'New Season ' . $nivel,
            'subtitulo' => 'New Season',
            'progresso' => 0,
            'numero'    => $nivel
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Meus Cursos - Oneway Línguas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <link rel="icon" href="../sistema/img/icone.ico" type="image/x-icon">

 
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth; 
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    ul {
      list-style: none;
    }
  

    :root {
      --primary:  #6596D0; 
      --secondary: #FFBD30; 
      --accent:   #FF5466; 
      --dark: #222;
      --light: #f9f9f9;
      --gray: #888;

      --gradient-hero: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
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
      color: white;}

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
      margin-top: 100px;
      margin-left: 200px ; 
      margin-right: 60px ;
      margin-bottom: 100px;
      padding: 0 20px;
    }
    .page-header {
      margin-bottom: 20px;
    }
    .page-header h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .page-header p {
      color: #666;
    }
    
    .filters {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 30px;
    }
    .filters button,
    .filters select {
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
    }
    .filters input[type='text'] {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 8px 12px;
      flex: 1;
      min-width: 200px;
    }
    .courses-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .course-card {
      background-color: #fff;
      border: 1px solid #eee;
      border-radius: 8px;
      width: 300px;
      position: relative;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
    }
    .course-card-header {
      height: 120px;
      border-radius: 8px 8px 0 0;
      background: url('../sistema/img/fundoCard.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    .course-card-header .course-number {
      font-size: 48px;
      font-weight: bold;
      color: #fff;
      z-index: 2;
    }
    
    .course-card-body {
      padding: 15px;
    }
    .course-card-body h3 {
      font-size: 18px;
      margin-bottom: 5px;
    }
    .course-card-body p {
      font-size: 14px;
      color: #777;
      margin-bottom: 10px;
    }
    .course-card-footer {
      padding: 0 15px 15px 15px;
    }
    .progress-text {
      font-size: 12px;
      color: #555;
      margin-bottom: 5px;
    }
    .progress-bar-bg {
      background-color: #eee;
      border-radius: 4px;
      width: 100%;
      height: 8px;
      overflow: hidden;
      position: relative;
    }
    .progress-bar-fill {
      background-color: #28a745;
      height: 100%;
      width: 0%;
      transition: width 0.4s ease;
    }
    
    @media (max-width: 768px) {
      .navbar-center {
        display: none;
      }
      .course-card {
        width: 100%;
      }
    }
     
    footer {
      background-color: #4a83bd;
      color: white;
      padding: 60px 0;
      font-family: 'Arial', sans-serif;
    }

    .footer-container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 40px;
    }

    .footer-column h3 {
      font-size: 18px;
      margin-bottom: 20px;
      text-transform: uppercase;
      border-left: 4px solid #f1c40f;
      padding-left: 10px;
    }

    .footer-column ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-column ul li {
      margin-bottom: 12px;
    }

    .footer-column ul li a {
      color: white;
      text-decoration: none;
      font-size: 15px;
      transition: 0.3s;
    }

    .footer-column ul li a:hover {
      color: #f1c40f;
    }

    .newsletter p {
      margin-bottom: 15px;
      font-size: 15px;
    }

    .newsletter form {
      display: flex;
      flex-wrap: nowrap;
      border-radius: 5px;
      overflow: hidden;
      border: 1px solid #bdc3c7;
    }

    .newsletter input {
      flex: 1;
      padding: 12px;
      border: none;
      outline: none;
      font-size: 14px;
    }

    .newsletter button {
      background: #f1c40f;
      color: #2c3e50;
      border: none;
      padding: 12px 15px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }

    .newsletter button:hover {
      background: #e67e22;
      color: #fff;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 10px;
    }

    .social-icons a {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #34495e;
      border-radius: 50%;
      transition: 0.3s;
    }

    .social-icons a img {
      width: 20px;
      height: 20px;
    }

    .social-icons a:hover {
      background: #f1c40f;
    }

    .footer-bottom {
      text-align: center;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      margin-top: 40px;
      padding-top: 20px;
      font-size: 14px;
    }

    .footer-bottom a {
      color: #f1c40f;
      text-decoration: none;
      font-weight: bold;
    }

    .footer-bottom a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .footer-container {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .newsletter form {
        flex-direction: column;
      }

      .newsletter input {
        border-radius: 5px 5px 0 0;
      }

      .newsletter button {
        border-radius: 0 0 5px 5px;
      }

      .social-icons {
        justify-content: center;
      }
    }
  </style>
</head>
<body>


<header id="header">
  <div class="navbar">
    <div class="logo">
      <a href="#hero">
       <a href="../index.php"> <img src="../sistema/img/logo.png" alt="Logo OneWay"></a>
      </a>
    </div>
    <i class="fas fa-bars menu-icon" id="menuIcon"></i>
    <ul class="nav-links" id="navLinks">
      <li><a href="../index.php">Home</a></li>
      <li><a href="../index.php">Cursos</a></li>
      <li><a href="../index.php">FAQ</a></li>
      <div class="dropdown">
        <button class="dropbtn" onclick="toggleDropdown()"><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="#FFF" stroke="#000" stroke-width="1"><path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/><circle cx="12" cy="7" r="3"/></g></svg></button>
        <div class="dropdown-content" id="dropdownMenu">
            <a href="perfil.php">Perfil</a>
            <a href="paginaIndividual.php#avaliacoes">Notas</a>
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
    <div class="page-header">
      <h1>MEUS CURSOS</h1>
      <p>Resumo dos cursos</p>
    </div>

    
    <div class="filters">
      <button>Todos</button>
      <input type="text" placeholder="Buscar" />
      <button>Ordenar por nome do curso</button>
      <button>Cartão</button>
    </div>

    
    <div class="courses-wrapper">
      <?php foreach($cursos as $curso): ?>
        <div class="course-card">
          <div class="course-card-header">
            <div class="course-number">
              <?php echo htmlspecialchars($curso['numero'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
          </div>
          <div class="course-card-body">
           <a href="paginaIndividual.php"> <h3><?php echo htmlspecialchars($curso['titulo'], ENT_QUOTES, 'UTF-8'); ?></h3></a>
            <p><?php echo htmlspecialchars($curso['subtitulo'], ENT_QUOTES, 'UTF-8'); ?></p>
          </div>
          <div class="course-card-footer">
            <div class="progress-text">
              <?php echo $curso['progresso']; ?>% completo
            </div>
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width: <?php echo (int)$curso['progresso']; ?>%;"></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    </div>

    <footer class="footer">
<div class="footer-container">
    <div class="footer-column">
      <h3>Institucional</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Sobre Nós</a></li>
        <li><a href="#">Cursos</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Contato</a></li>
        <li><a href="#">Política de Privacidade</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Estude Conosco</h3>
      <ul>
        <li><a href="#">Nossas Unidades</a></li>
        <li><a href="#">Certificações</a></li>
        <li><a href="#">Metodologia e Material</a></li>
      </ul>
    </div>

    <div class="footer-column newsletter">
      <h3>Newsletter</h3>
      <p>Receba novidades e promoções exclusivas!</p>
      <form action="#" method="post">
        <input type="email" name="email" placeholder="Insira seu e-mail" required>
        <button type="submit">Enviar</button>
      </form>
    </div>

    <div class="footer-column">
      <h3>Contato</h3>
      <ul>
        <li></li>
        <li></li>
        <li></li>
      </ul>
      <ul>
        <li><ion-icon name="call-outline"></ion-icon> (11) 4747-5133</li>
        <li><ion-icon name="logo-whatsapp"></ion-icon> (11) 4678-2375</li>
        <li><ion-icon name="mail-outline"></ion-icon> contato@empresa.com</li>
      </ul>
    </div>
  </div>
  
 
  
</footer>
<div class="footer-bottom">
      <p>2025 &copy; Copyright Oneway Línguas. Todos os direitos reservados.</p>
    </div>
  </div>

  <script>
        function toggleDropdown() {
            document.getElementById("dropdownMenu").classList.toggle("show");
        }

        
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
  
</body>
</html>
