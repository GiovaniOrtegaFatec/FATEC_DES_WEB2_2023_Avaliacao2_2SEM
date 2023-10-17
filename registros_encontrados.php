<?php
require_once('header.php');
require_once('dados_banco.php');

$conn = null;

if (!isset($_SESSION["online"]) || $_SESSION["online"] !== true) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['placa_id'])) {
    $placa_id = $_GET['placa_id'];

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM registro WHERE veiculos_id = :placa_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':placa_id', $placa_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Portaria Fatec</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h2><?php echo $_SESSION["username"]; ?><br></h2>
    </div>
    <p>
        <div class="form-group">
            <label>Data e Hora em que existe registro de entrada/saída</label><br>
            <?php
               while ($row = $stmt->fetch()) {
                   echo $row['data_hora']."<br>";
               }
            ?>
        </div>

        <a href="principal.php" class="btn btn-primary">Voltar</a><br><br>
    </p>
</body>
</html>


