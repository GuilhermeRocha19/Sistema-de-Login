<?php 
require_once('../includes/conexao/Conexao.php');
require '../vendor/autoload.php';
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
    $nova_Senha = gerar_senha();
    $mail->Body = "Sua nova senha é: $nova_Senha";

    $mail->send();
    $senhaTratada = md5($nova_Senha);
    $query_Update = "UPDATE tb_usuarios SET senha = '$senhaTratada' WHERE email = '$email'";
    $mysqli->query($query_Update);

    ?>
    
    <script>
        alert('E-mail enviado com sucesso')
    </script>
    <?php
    exit();
    
} catch (Exception $e) {
    ?>
    
    <script>
        alert('Erro ao enviar e-mail!')
    </script>
    <?php
    exit();
}



function gerar_senha($tamanho = 8, $maiusculas =true , $minusculas =true, $numeros =true, $simbolos =true){
    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; 
    $mi = "abcdefghijklmnopqrstuvyxwz"; 
    $nu = "0123456789"; 
    $si = "!@#$%¨&*()_+="; 
    $senha = "";
  
    if ($maiusculas){

          $senha .= str_shuffle($ma);
    }
  
      if ($minusculas){

          $senha .= str_shuffle($mi);
      }
  
      if ($numeros){

          $senha .= str_shuffle($nu);
      }
  
      if ($simbolos){

          $senha .= str_shuffle($si);
      }
  
      return substr(str_shuffle($senha),0,$tamanho);
  }