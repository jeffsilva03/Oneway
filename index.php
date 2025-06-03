<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>One Way Línguas</title>


  <script type="module" src="https://unpkg.com/@ionic/core/dist/ionic/ionic.esm.js"></script>
  <script nomodule src="https://unpkg.com/@ionic/core/dist/ionic/ionic.js"></script>
  


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link 
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" 
    rel="stylesheet"
  >
  <link rel="icon" href="icone.ico" type="image/x-icon">
<link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

</head>
<body>


<button id="scrollToTop"><i class="fas fa-chevron-up"><img src="img/seta.png" alt=""></i></button>


<header id="header">
  <div class="navbar">
   
    <div class="logo">
      <a href="#hero">
        <img src="img/logo.png" alt="Logo OneWay">
      </a>
    </div>
    <i class="fas fa-bars menu-icon" id="menuIcon" aria-label="Abrir menu de navegação" tabindex="0"></i>
    <nav>
      <ul class="nav-links" id="navLinks">
        <li><a href="#hero">Home</a></li>
        <li><a href="#cursos">Cursos</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a class="btn-login" href="../phpLogin/registro.php">Acesso Login</a></li>
      </ul>
    </nav>
  </div>
</header>



<section class="hero fade-in" id="hero">
  <div class="hero-content">
    <div class="hero-text">
      <h1>Aprenda Inglês <br> 
        <span class="typed-text"></span> 
      </h1>
      <p>
        Domine a língua inglesa de forma natural, com aulas ao vivo e material atualizado.  
        Venha evoluir com a gente e abra portas para o mundo!
      </p>
      <a href="#about" class="btn-hero">Saiba Mais</a>
    </div>
    <div class="hero-image">
      <img src="img/kids2.png" alt="Aluno com Tablet">
    </div>
  </div>
  <svg class="wave-bottom" viewBox="0 0 1440 320" preserveAspectRatio="none">
    <path fill="#fff" fill-opacity="1" d="M0,224L60,234.7C120,245,240,267,360,256C480,245,600,203,720,186.7C840,171,960,181,1080,186.7C1200,192,1320,192,1380,192L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
  </svg>
</section>



<section class="section-about fade-in" id="about">
  <h2>Conheça a One Way Línguas</h2>
  <div class="about-grid">
    <div class="about-text">
      <p>
        Com mais de 20 anos de experiência, capacitamos alunos para desenvolverem-se com naturalidade em todas as vertentes da língua: falar, ouvir, ler e escrever.
      </p>
      <p>
        Aulas dinâmicas, foco na conversação e material atualizado são os pilares do nosso método, garantindo fluência e segurança para falar inglês em qualquer situação.
      </p>
      <a href="#" class="btn-about">Saiba Mais</a>
    </div>
    <div class="about-image">
      <img src="img/logo.png" alt="Imagem One Way">
    </div>
  </div>
</section>


<section class="section-courses fade-in" id="cursos">
  <div class="container">
    <h2>Curso de Inglês para Todas as Idades</h2>
    <div class="courses-grid">
      <div class="course-card">
        <img src="img/kinder.png" alt="Kinder">
        <h3>Kinder</h3>
        <p>Para crianças entre 3 e 6 anos, com foco na familiarização e diversão.</p>
      </div>
      <div class="course-card">
        <img src="img/kids.png" alt="Kids">
        <h3>Kids</h3>
        <p>Para crianças entre 7 e 10 anos, com aulas temáticas que estimulam o aprendizado.</p>
      </div>
      <div class="course-card">
        <img src="img/teen.png" alt="Teensway">
        <h3>Teensway</h3>
        <p>Para alunos entre 11 e 14 anos, reforçando vocabulário, leitura e conversação.</p>
      </div>
      <div class="course-card">
        <img src="img/new.png" alt="New Season">
        <h3>New Season</h3>
        <p>Para alunos a partir de 14 anos, com foco na comunicação fluente e uso profissional.</p>
      </div>
    </div>
  </div>
</section>



<section class="section-stats fade-in" id="stats">
  <h2>Nossos Números</h2>
  <div class="stats-container">
    <div class="stat-box">
      <h3>+20</h3>
      <p>Anos de Experiência</p>
    </div>
    <div class="stat-box">
      <h3>+5000</h3>
      <p>Alunos Formados</p>
    </div>
    <div class="stat-box">
      <h3>99%</h3>
      <p>Satisfação dos Estudantes</p>
    </div>
    <div class="stat-box">
      <h3>+50</h3>
      <p>Professores Certificados</p>
    </div>
  </div>
</section>


<section class="section-team fade-in" id="team">
  <div class="team-container">
    <h2>Nossa Equipe</h2>
    <div class="team-grid">
      <div class="team-member">
        <img src="img/prof1.png" alt="Professor 1">
        <h3>João Pedro</h3>
        <span>Coordenador Pedagógico</span>
        <p>Com 10 anos de experiência no ensino de inglês, é responsável pela qualidade das aulas.</p>
      </div>
      <div class="team-member">
        <img src="img/prof2.png" alt="Professor 2">
        <h3>Ana Lucia</h3>
        <span>Professora</span>
        <p>Especialista em aulas para crianças, utilizando métodos lúdicos e interativos.</p>
      </div>
      <div class="team-member">
        <img src="img/prof3.png" alt="Professor 3">
        <h3>Carlos Eduardo</h3>
        <span>Professor</span>
        <p>Foco em conversação para adolescentes e adultos, com vivência internacional.</p>
      </div>
      <div class="team-member">
        <img src="img/prof4.jpg" alt="Professor 4">
        <h3>Maria Fernanda</h3>
        <span>Professora</span>
        <p>Especialista em Business English, prepara alunos para o mercado global.</p>
      </div>
    </div>
  </div>
</section>


<section class="section-testimonials fade-in" id="testimonials">
  <div class="container">
    <h2>O que nossos alunos dizem</h2>
    <div class="testimonials-grid">
      <div class="testimonial-card">
        <p>"A One Way transformou meu inglês. Hoje falo com confiança!"</p>
        <div class="testimonial-author">
          <img src="img/aluno1.jpg" alt="Aluno 1">
          <div>
            <h4>Maria Silva</h4>
            <span>Ex-aluna</span>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <p>"O método é incrível e os professores são muito atenciosos."</p>
        <div class="testimonial-author">
          <img src="img/aluno2.png" alt="Aluno 2">
          <div>
            <h4>João Souza</h4>
            <span>Ex-aluno</span>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <p>"Recomendo a todos que querem aprender inglês de verdade!"</p>
        <div class="testimonial-author">
          <img src="img/aluno3.jpg"" alt="Aluno 3">
          <div>
            <h4>Ana Paula</h4>
            <span>Ex-aluna</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="section-faq fade-in" id="faq">
  <div class="container">
    <h2>Perguntas Frequentes</h2>
    <div class="faq-item">
      <button class="faq-question">Como funcionam as aulas online? <span class="faq-icon">+</span></button>
      <div class="faq-answer">
        <p>As aulas são realizadas via plataforma de videoconferência, com turmas reduzidas e material interativo.</p>
      </div>
    </div>
    <div class="faq-item">
      <button class="faq-question">Qual a duração de cada curso? <span class="faq-icon">+</span></button>
      <div class="faq-answer">
        <p>Depende do nível e do objetivo do aluno, mas cada módulo costuma durar cerca de 6 meses.</p>
      </div>
    </div>
    <div class="faq-item">
      <button class="faq-question">Posso ter aulas individuais? <span class="faq-icon">+</span></button>
      <div class="faq-answer">
        <p>Sim, oferecemos aulas particulares sob demanda, com foco em objetivos específicos do aluno.</p>
      </div>
    </div>
  </div>
</section>



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
  <form action="newsletter/newsletter.php" method="post">
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




  const menuIcon = document.getElementById('menuIcon');
  const navLinks = document.getElementById('navLinks');

  menuIcon.addEventListener('click', () => {
    navLinks.classList.toggle('open');
  });

  
  
  const scrollToTopBtn = document.getElementById('scrollToTop');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      scrollToTopBtn.classList.add('show');
    } else {
      scrollToTopBtn.classList.remove('show');
    }
  });

  scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });


  

  const header = document.getElementById('header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      header.classList.add('shrink');
    } else {
      header.classList.remove('shrink');
    }
  });


  
  const faders = document.querySelectorAll('.fade-in');
  const appearOptions = { threshold: 0.1 };
  const appearOnScroll = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('show');
      observer.unobserve(entry.target);
    });
  }, appearOptions);

  faders.forEach(fader => {
    appearOnScroll.observe(fader);
  });


  

  const typedTextSpan = document.querySelector('.typed-text');
  const textArray = ["Online", "De Forma Natural", "Com Professores ao Vivo"];
  let textArrayIndex = 0;
  let charIndex = 0;
  const typingDelay = 100;
  const erasingDelay = 50;
  const newTextDelay = 1200;

  function type() {
    if (charIndex < textArray[textArrayIndex].length) {
      typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
      charIndex++;
      setTimeout(type, typingDelay);
    } else {
      setTimeout(erase, newTextDelay);
    }
  }

  function erase() {
    if (charIndex > 0) {
      typedTextSpan.textContent = textArray[textArrayIndex].substring(0, charIndex - 1);
      charIndex--;
      setTimeout(erase, erasingDelay);
    } else {
      textArrayIndex++;
      if (textArrayIndex >= textArray.length) textArrayIndex = 0;
      setTimeout(type, typingDelay);
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    if (textArray.length) setTimeout(type, newTextDelay);
  });


  
  
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question');
    questionBtn.addEventListener('click', () => {
      item.classList.toggle('open');
    });
  });
</script>
</body>
</html>
