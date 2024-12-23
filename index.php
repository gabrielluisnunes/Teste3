<?php
try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO("mysql:host=localhost;dbname=dbteste", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query para buscar os clientes, veículos e marcas
    $stmt = $pdo->prepare("
        SELECT clientes.nome, clientes.data_compra, veiculos.nome AS veiculo, marcas.nome AS marca
        FROM clientes
        LEFT JOIN veiculos ON clientes.veiculo = veiculos.id
        LEFT JOIN marcas ON veiculos.marca = marcas.id
        ORDER BY clientes.nome
    ");
    $stmt->execute();

    // Obter resultados
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Clientes</title>
    <style>
        body, html {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .content {
            width: 80%;
            max-height: 500px;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
            overflow-y: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background-color: #ddd;
        }
        thead td {
            padding: 10px;
            font-weight: bold;
        }
        tbody tr td {
            padding: 8px;
            border-bottom: 1px solid #bbb;
        }
    </style>
</head>
<body>

<div class="content">
    <h1>Lista de Clientes e Veículos</h1>
    <table>
        <thead>
        <tr>
            <td>Cliente</td>
            <td>Data da Compra</td>
            <td>Veículo</td>
            <td>Marca</td>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($row)) { ?>
            <?php foreach ($row as $item) { ?>
                <tr>
                    <td><?= $item['nome'] ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($item['data_compra'])) ?></td>
                    <td><?= $item['veiculo'] ?? 'Nao possui veículo' ?></td>
                    <td><?= $item['marca'] ?? 'Nao possui veiculo / marca' ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">Nenhum cliente encontrado.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
