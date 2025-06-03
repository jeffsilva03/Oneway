<?php
session_start();
require_once 'conexao.php';


if (!isset($_SESSION['user_id']) || strtolower(trim($_SESSION['nivel'])) !== 'professor') {
    header("Location: login.php");
    exit;
}

$id_professor = $_SESSION['user_id'];


if (!isset($_GET['curso'])) {
    echo "Nenhum curso especificado.";
    exit;
}
$curso = trim($_GET['curso']);


$mensagem = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_aluno'])) {
    $id_aluno      = (int) $_POST['id_aluno'];
    $nomeAtividade = trim($_POST['nome_atividade'] ?? '');
    $nota          = trim($_POST['nota'] ?? '');


    if ($nomeAtividade === '') {
        $mensagem = "O campo 'Nome da Atividade' não pode ficar vazio.";
    } elseif ($nota === '' || !is_numeric($nota) || $nota < 0 || $nota > 100) {
        $mensagem = "A nota deve ser um número entre 0 e 100.";
    } else {
     
        $stmt = $pdo->prepare("
            INSERT INTO avaliacoes (id_aluno, id_professor, curso, nome_atividade, nota, data_atribuicao)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        if ($stmt->execute([$id_aluno, $id_professor, $curso, $nomeAtividade, $nota])) {
            $mensagem = "Nota atribuída com sucesso!";
        } else {
            $mensagem = "Erro ao atribuir a nota.";
        }
    }
}


$stmt = $pdo->prepare("
    SELECT id, nome, email 
    FROM dados_pessoais 
    WHERE nivel = ? 
      AND LOWER(nivel) != 'professor'
");
$stmt->execute([$curso]);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atribuir Nota - New Season <?php echo htmlspecialchars($curso, ENT_QUOTES, 'UTF-8'); ?></title>
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
        max-width: 1000px;
        margin: 100px auto 40px auto; 
        padding: 20px;
        background-color: var(--box-bg);
        border: 1px solid var(--box-border);
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }

      .page-title {
        margin-bottom: 10px;
        font-size: 26px;
        font-weight: 600;
        color: var(--text-primary);
        text-align: center;
      }
      .curso-info {
        font-size: 18px;
        font-weight: 500;
        color: var(--text-secondary);
        text-align: center;
        margin-bottom: 25px;
      }

      
      .mensagem {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
      }
      .erro {
        color: #c0392b;
      }
      .sucesso {
        color: #27ae60;
      }

    
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
      }
      th, td {
        border: 1px solid #ccc;
        padding: 12px 10px;
        text-align: left;
        vertical-align: middle;
      }
      th {
        background: #f2f2f2;
        color: var(--text-primary);
      }

     
      form {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 0;
      }
      input[type="text"],
      input[type="number"] {
        padding: 6px 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
      }
      input[type="number"] {
        width: 80px;
      }
      button {
        background: var(--button-bg);
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
      }
      button:hover {
        background: var(--button-hover);
      }

      
      .no-alunos {
        text-align: center;
        color: #666;
      }

      
      .voltar {
        display: inline-block;
        margin-top: 20px;
        text-align: center;
        color: var(--button-bg);
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
      }
      .voltar:hover {
        text-decoration: underline;
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
    <h1 class="page-title">Atribuir Nota</h1>
    <p class="curso-info">Curso: New Season <?php echo htmlspecialchars($curso, ENT_QUOTES, 'UTF-8'); ?></p>

    <?php if ($mensagem): ?>
      <?php 
        $classe = (strpos($mensagem, 'sucesso') !== false) ? 'sucesso' : 'erro';
      ?>
      <p class="mensagem <?php echo $classe; ?>">
        <?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>
      </p>
    <?php endif; ?>

    <?php if ($alunos): ?>
      <table>
        <thead>
          <tr>
            <th>Nome do Aluno</th>
            <th>Email</th>
            <th>Nome da Atividade</th>
            <th>Nota (0 a 100)</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($alunos as $aluno): ?>
          <tr>
            <td><?php echo htmlspecialchars($aluno['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($aluno['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <form method="POST">
                <input type="hidden" name="id_aluno" value="<?php echo $aluno['id']; ?>">
                <input type="text" name="nome_atividade" placeholder="Ex: Prova 1" required>
            </td>
            <td>
                <input type="number" name="nota" min="0" max="100" step="1" placeholder="0-100" required>
            </td>
            <td>
                <button type="submit">Enviar</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-alunos">Nenhum aluno encontrado para este curso.</p>
    <?php endif; ?>

    <a class="voltar" href="meusCursos.php">Voltar para Meus Cursos</a>
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
