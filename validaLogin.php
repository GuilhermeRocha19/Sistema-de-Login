<?php
require_once('./conexao/Conexao.php');
$conn = new Conexao();

$email = $_POST['email'];
$senha = md5($_POST['senha']);

$query = "SELECT * FROM tb_usuarios WHERE email = '$email' AND senha = '$senha'";
$mysqli = $conn->getConexao();
$result = $mysqli->query($query);


if ($result) {
    session_start();
    $login = true;
    $dados = $result->fetch_assoc();

    $_SESSION['nome'] = $dados['nome'];
    $_SESSION['sobrenome'] = $dados['sobrenome'];
    $_SESSION['id'] = $dados['id'];
    $_SESSION['tipo'] = 'E';
    
} 

if($login){
    ?>
    <script>
        alert("Seja Bem-vindo!");
    </script>
    <?php
    header('Location: view/sistema.php');
}else{
    ?>
    <script>
        alert("Email ou senha incorretos.");
    </script>
    <?php
    exit();
}









?>