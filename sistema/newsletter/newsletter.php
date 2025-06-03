<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }

    
    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'oneway';

    try {
        
        $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM email WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            die("Este email já está cadastrado.");
        }

        
        $stmt = $pdo->prepare("INSERT INTO email (email) VALUES (:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'onewaylinguas1@outlook.com'; 
            $mail->Password   = 'ybvxnysljhbqmdwr'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

          
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

           
            $mail->setFrom('onewaylinguas1@outlook.com', 'Oneway');
            $mail->addAddress($email);
            $mail->Subject = 'Oneway - Bem-vindo!';
            $mail->Body    = 'Seja bem-vindo! Obrigado por se inscrever em nossa newsletter.';

           
            $mail->SMTPDebug   = 3;
            $mail->Debugoutput = 'html';

           
            $mail->send();
            echo "Inscrição realizada com sucesso! Um e-mail de boas-vindas foi enviado para $email.";
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    } catch (PDOException $e) {
        echo "Erro na conexão ou inserção: " . $e->getMessage();
    }
} else {
    header("Location: ../../index.php");
    exit;
}
?>
