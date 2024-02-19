<?php require_once('../includes/conexao/Conexao.php');
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new Conexao();


$email = $_POST['email'];

$query_valida = "SELECT * FROM tb_usuarios WHERE email = '$email'";
$mysqli = $conn->getConexao();
$result = $mysqli->query($query_valida);
if($result->num_rows > 0){

    ?> 
    <script>
        const email = "<?php echo $email; ?>"
        alert(`O email ${email} já está cadastrado no sistema.`)
        setTimeout(()=>{
            window.location.href = "./criarConta.html"
        },1000)
    </script>
    <?php
    exit;
}

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