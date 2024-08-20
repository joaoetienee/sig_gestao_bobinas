<?php
include 'config.php';

$next_id_bobina = 1;

$sql = "SELECT MAX(id_bobina) AS max_id FROM bobinas";
if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    if ($row['max_id']) {
        $next_id_bobina = $row['max_id'] + 1;
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Erro ao consultar o maior ID: " . $conn->error . "</div>";
}

$sql_fornecedores = "SELECT id_fornecedor, nome_fornecedor FROM fornecedor ORDER BY nome_fornecedor ASC";
$fornecedores_result = $conn->query($sql_fornecedores);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_bobina = $next_id_bobina;
    $id_fornecedor = $_POST['id_fornecedor'];
    $tipo_papel = $_POST['tipo_papel'];
    $largura = $_POST['largura'];
    $comprimento = $_POST['comprimento'];
    $peso = $_POST['peso'];
    $espessura = $_POST['espessura'];
    $data_recebimento = $_POST['data_recebimento'];
    $quantidade = $_POST['qtd_recebida'];
    $condicoes_recebimento = $_POST['condicoes_recebimento'];
    $localizacao = $_POST['localizacao_estoque'];
    $status = $_POST['status_recebimento'];
    $responsavel = $_POST['responsavel_estoque'];

    $sql = "INSERT INTO bobinas (id_bobina, id_fornecedor, tipo_papel, largura, peso, comprimento, espessura, data_recebimento, condicoes_recebimento, status_recebimento, qtd_recebida, localizacao_estoque,  responsavel_movimentacao)
    VALUES ('$id_bobina', '$id_fornecedor', '$tipo_papel', '$largura', '$peso', '$comprimento', '$espessura', '$data_recebimento', '$condicoes_recebimento', '$status', '$quantidade', '$localizacao',  '$responsavel')";

    if ($conn->query($sql) === TRUE) {
        echo "Nova bobina adicionada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Bobina</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmarCancelamento(event) {
            if (!confirm("Tem certeza de que deseja cancelar a inserção e voltar à página inicial?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Adicionar Nova Bobina</h1>
        <form method="post" action="">
            <div class="form-row mb-3">
                <div class="form-group col-md-4">
                    <label for="id_bobina">ID Bobina:</label>
                    <input type="text" name="id_bobina" class="form-control" value="<?php echo htmlspecialchars($next_id_bobina); ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="id_fornecedor">Fornecedor:</label>
                    <select name="id_fornecedor" class="form-control" required>
                        <option value="" selected disabled>Selecione um fornecedor</option>
                        <?php while($fornecedor = $fornecedores_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($fornecedor['id_fornecedor']); ?>">
                                <?php echo htmlspecialchars($fornecedor['nome_fornecedor']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="tipo_papel">Tipo de Papel:</label>
                    <select name="tipo_papel" class="form-control" required>
                            <option value="" selected disabled> Selecione um tipo de papel:</option>
                            <option value="Papel Atoalhado">Papel Atoalhado</option>
                            <option value="Papel Cartão">Papel Cartão</option>
                            <option value="Papel Couché">Papel Couché</option>
                            <option value="Papel Kraft">Papel Kraft</option>
                            <option value="Papel Offset">Papel Offset</option>
                            <option value="Papel Pardo">Papel Pardo</option>
                            <option value="Papel Reciclável">Papel Reciclável</option>
                            <option value="Papel Sulfite">Papel Sulfite</option>
                            <option value="Papel Vegetal">Papel Vegetal</option>
                    </select>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="form-group col-md-3">
                    <label for="largura">Largura (cm):</label>
                    <input type="number" step="0.01" name="largura" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="peso">Peso (kg):</label>
                    <input type="number" step="0.01" name="peso" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="comprimento">Comprimento (cm):</label>
                    <input type="number" step="0.01" name="comprimento" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="espessura">Espessura (cm):</label>
                    <input type="number" step="0.01" name="espessura" class="form-control" required>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="form-group col-md-3">
                    <label for="data_recebimento">Data de Recebimento:</label>
                    <input type="date" name="data_recebimento" value='<?php echo date("Y-m-d");?>' class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="qtd_recebida">Quantidade:</label>
                    <input type="number" name="qtd_recebida" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="condicoes_recebimento">Condição:</label>
                    <select name="condicoes_recebimento" class="form-control" required>
                        <option value="" selected disabled>Condição de recebimento:</option>
                        <option value="Danificada">Danificada</option>
                        <option value="Nova">Nova</option>
                        <option value="Usada">Usada</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="localizacao_estoque">Localização:</label>
                    <input type="text" name="localizacao_estoque" class="form-control" required>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="form-group col-md-6">
                    <label for="status_recebimento">Status:</label>
                    <select name="status_recebimento" class="form-control" required>
                        <option value="" selected disabled>Status:</option>
                        <option value="Disponível para uso">Disponível para uso</option>
                        <option value="Em processo de produção">Em processo de produção</option>
                        <option value="Em manutenção">Em manutenção</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="responsavel_estoque">Responsável:</label>
                    <input type="text" name="responsavel_estoque" class="form-control" required>
                </div>
            </div>
                
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Adicionar Bobina</button>
                <a href="index.php" class="btn btn-secondary float-right mr-2" onclick="confirmarCancelamento(event)">Cancelar</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>