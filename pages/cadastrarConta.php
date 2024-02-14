<?php require_once('../includes/conexao/Conexao.php');
require '../vendor/autoload.php';

$conn = new Conexao();

$nome_arquivo = $_FILES["foto"]["name"];

$query_insert = "INSERT INTO tb_usuarios(nome,sobrenome,email,senha,foto_perfil) VALUES (?, ?, ?, ?, ?)";

$data = array(
    $_POST['nome'],
    $_POST['sobrenome'],
    $_POST['email'],
    md5($_POST['senha']),
    $nome_arquivo
);

$result = $conn->executar($query_insert, $data);

move_uploaded_file($_FILES["foto"]["tmp_name"], "./imgs_perfil/$nome_arquivo");


if($result){
    ?>
    <script>
        alert("Sua conta foi criada com sucesso!");
    </script>
    <?php
    header('Location: ../index.html');
}else{
    ?>
    <script>
        alert("Não foi possível criar sua conta!");
    </script>
    <?php
}
exit();