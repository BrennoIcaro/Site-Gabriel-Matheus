<?php
session_start();

// Verificar se o usuário está logado como administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../404.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];
    $cor = $_POST['cor'];

    // Conectar ao banco de dados (substitua as credenciais conforme necessário)
    require_once 'db_connection.php';
    // Nome do banco de dados

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inserir os dados no banco
        $sql = "INSERT INTO carros (modelo, marca, ano, placa, cor) VALUES (:modelo, :marca, :ano, :placa, :cor)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':cor', $cor);

        $stmt->execute();
        
        echo "<div class='alert alert-success mt-4'>Carro cadastrado com sucesso!</div>";
        header("Location: adm.php");
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger mt-4'>Erro: " . $e->getMessage() . "</div>";
        header("Location: /405.php");
    }

    // Fechar a conexão
    $conn = null;
}
?>
