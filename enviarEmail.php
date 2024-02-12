<?php 
require_once('./conexao/Conexao.php');
require './vendor/autoload.php';
$conn = new Conexao();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

$email =  $_POST['email'];

$query = "SELECT * FROM tb_usuarios WHERE email = '$email'";
$mysqli = $conn->getConexao();
$result = $mysqli->query($query);

$dados = $result->fetch_assoc();


if($result->num_rows == 0){
    ?>
    <script>
        alert("E-mail não cadastrado, favor criar uma conta utilizando esse E-mail.");
    </script>
    <?php
    header("location criarConta.html");
    exit();
}
try {
    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sistemalogin3@gmail.com';
    $mail->Password = 'sagd irtt owoi jyhp';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    
    $mail->setFrom('sistemalogin3@gmail.com', 'Sistema Login');
    $mail->addAddress($email, 'Usuário');
    $mail->Subject = 'Alteração de Senha';
    $mail->Body = 'Clique Aqui para alterar sua senha!';

    
    $mail->send();
    echo 'E-mail enviado com sucesso';
} catch (Exception $e) {
    echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
}
