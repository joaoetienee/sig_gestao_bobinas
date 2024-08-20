<?php
include 'config.php';

$sql = "SELECT bobinas.*, fornecedor.nome_fornecedor 
        FROM bobinas 
        JOIN fornecedor ON bobinas.id_fornecedor = fornecedor.id_fornecedor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Bobinas de Papel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-responsive {
            overflow-x: auto; 
        }
        .table th, .table td {
            white-space: nowrap; 
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4" style="padding-left: 5%; padding-right: 5%;">
        <h1 class="text-center mb-4">Gestão de Bobinas de Papel</h1>
        <a href="adicionar.php" class="btn btn-primary mb-3">Adicionar Nova Bobina</a>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Bobina</th>
                        <th>Fornecedor</th>
                        <th>Tipo de Papel</th>
                        <th>Largura (cm)</th>
                        <th>Comprimento (cm)</th>
                        <th>Peso (kg)</th>
                        <th>Espessura (cm)</th>
                        <th>Data de Recebimento</th>
                        <th>Quantidade</th>
                        <th>Condição</th>
                        <th>Localização</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_bobina']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome_fornecedor']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_papel']); ?></td>
                        <td><?php echo htmlspecialchars($row['largura']); ?></td>
                        <td><?php echo htmlspecialchars($row['comprimento']); ?></td>
                        <td><?php echo htmlspecialchars($row['peso']); ?></td>
                        <td><?php echo htmlspecialchars($row['espessura']); ?></td>
                        <td><?php $data_recebimento = date('d/m/Y', strtotime($row['data_recebimento'])); echo htmlspecialchars($data_recebimento); ?></td>
                        <td><?php echo htmlspecialchars($row['qtd_recebida']); ?></td>
                        <td><?php echo htmlspecialchars($row['condicoes_recebimento']); ?></td>
                        <td><?php echo htmlspecialchars($row['localizacao_estoque']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_recebimento']); ?></td>
                        <td>
                            <a href="editar.php?id_bobina=<?php echo htmlspecialchars($row['id_bobina']); ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletar.php?id_bobina=<?php echo htmlspecialchars($row['id_bobina']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar esta bobina?');">Deletar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
