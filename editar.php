<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_bobina = $_POST['id_bobina'];
    $id_fornecedor = $_POST['id_fornecedor'];
    $tipo_papel = $_POST['tipo_papel'];
    $largura = $_POST['largura'];
    $peso = $_POST['peso'];
    $comprimento = $_POST['comprimento'];
    $espessura = $_POST['espessura'];
    $espessura = str_replace(',', '.', $_POST['espessura']);
    $data_recebimento = $_POST['data_recebimento'];
    $condicoes_recebimento = $_POST['condicoes_recebimento'];
    $status_recebimento = $_POST['status_recebimento'];
    $qtd_recebida = $_POST['qtd_recebida'];
    $localizacao_estoque = $_POST['localizacao_estoque'];
    $historico_movimentacao = $_POST['historico_movimentacao'];
    $responsavel_movimentacao = $_POST['responsavel_movimentacao'];

    $sql = "SELECT id_fornecedor FROM fornecedor WHERE id_fornecedor = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_fornecedor);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<div class='alert alert-danger' role='alert'>Erro: O fornecedor selecionado não existe.</div>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro ao preparar a consulta de verificação do fornecedor: " . $conn->error . "</div>";
        exit;
    }

    $sql = "UPDATE bobinas SET id_fornecedor=?, tipo_papel=?, largura=?, peso=?, comprimento=?, espessura=?, data_recebimento=?, condicoes_recebimento=?, status_recebimento=?, qtd_recebida=?, localizacao_estoque=?, historico_movimentacao=?, responsavel_movimentacao=? WHERE id_bobina=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isddddsssssssi", $id_fornecedor, $tipo_papel, $largura, $peso, $comprimento, $espessura, $data_recebimento, $condicoes_recebimento, $status_recebimento, $qtd_recebida, $localizacao_estoque, $historico_movimentacao, $responsavel_movimentacao, $id_bobina);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao atualizar a bobina: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro ao preparar a consulta: " . $conn->error . "</div>";
    }

    $conn->close();
}

if (isset($_GET['id_bobina'])) {
    $id_bobina = $_GET['id_bobina'];

    $sql = "SELECT * FROM bobinas WHERE id_bobina = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_bobina);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Bobina não encontrada.</div>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro ao preparar a consulta: " . $conn->error . "</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID da bobina não fornecido.</div>";
    exit;
}

$sql = "SELECT id_fornecedor, nome_fornecedor FROM fornecedor ORDER BY nome_fornecedor ASC";
$fornecedores = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Bobina</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmarCancelamento(event) {
            if (!confirm("Tem certeza de que deseja cancelar a alteração e voltar à página inicial?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Editar Bobina</h1>
        <form action="" method="post">
            <input type="hidden" name="id_bobina" value="<?php echo htmlspecialchars($row['id_bobina']); ?>">

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_fornecedor">Fornecedor:</label>
                        <select name="id_fornecedor" class="form-control" required>
                            <option value="" selected disabled>Selecione o Fornecedor</option>
                            <?php while($fornecedor = $fornecedores->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($fornecedor['id_fornecedor']); ?>" <?php if($fornecedor['id_fornecedor'] == $row['id_fornecedor']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($fornecedor['nome_fornecedor']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_papel">Tipo de Papel:</label>
                        <select name="tipo_papel" class="form-control" required>
                            <option value="" disabled>Selecione um tipo de papel:</option>
                            <option value="Papel Atoalhado" <?php if ($row['tipo_papel'] == 'Papel Atoalhado') echo 'selected'; ?>>Papel Atoalhado</option>
                            <option value="Papel Cartão" <?php if ($row['tipo_papel'] == 'Papel Cartão') echo 'selected'; ?>>Papel Cartão</option>
                            <option value="Papel Couché" <?php if ($row['tipo_papel'] == 'Papel Couché') echo 'selected'; ?>>Papel Couché</option>
                            <option value="Papel Kraft" <?php if ($row['tipo_papel'] == 'Papel Kraft') echo 'selected'; ?>>Papel Kraft</option>
                            <option value="Papel Offset" <?php if ($row['tipo_papel'] == 'Papel Offset') echo 'selected'; ?>>Papel Offset</option>
                            <option value="Papel Pardo" <?php if ($row['tipo_papel'] == 'Papel Pardo') echo 'selected'; ?>>Papel Pardo</option>
                            <option value="Papel Reciclável" <?php if ($row['tipo_papel'] == 'Papel Reciclável') echo 'selected'; ?>>Papel Reciclável</option>
                            <option value="Papel Sulfite" <?php if ($row['tipo_papel'] == 'Papel Sulfite') echo 'selected'; ?>>Papel Sulfite</option>
                            <option value="Papel Vegetal" <?php if ($row['tipo_papel'] == 'Papel Vegetal') echo 'selected'; ?>>Papel Vegetal</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="largura">Largura (cm):</label>
                        <input type="number" step="0.1" name="largura" class="form-control" value="<?php echo htmlspecialchars($row['largura']); ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="peso">Peso (kg):</label>
                        <input type="number" step="0.1" name="peso" class="form-control" value="<?php echo htmlspecialchars($row['peso']); ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="comprimento">Comprimento (cm):</label>
                        <input type="number" step="0.1" name="comprimento" class="form-control" value="<?php echo htmlspecialchars($row['comprimento']); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="espessura">Espessura (cm):</label>
                        <input type="number" step="0.1" name="espessura" class="form-control" value="<?php echo htmlspecialchars($row['espessura']); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="data_recebimento">Data de Recebimento:</label>
                        <input type="date" name="data_recebimento" class="form-control" value="<?php echo htmlspecialchars($row['data_recebimento']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="condicoes_recebimento">Condições de Recebimento:</label>
                        <select name="condicoes_recebimento" class="form-control" required>
                            <option value="" disabled>Condição de recebimento:</option>
                            <option value="Danificada" <?php if ($row['condicoes_recebimento'] == 'Danificada') echo 'selected'; ?>>Danificada</option>
                            <option value="Nova" <?php if ($row['condicoes_recebimento'] == 'Nova') echo 'selected'; ?>>Nova</option>
                            <option value="Usada" <?php if ($row['condicoes_recebimento'] == 'Usada') echo 'selected'; ?>>Usada</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status_recebimento">Status de Recebimento:</label>
                        <select name="status_recebimento" class="form-control" required>
                            <option value="" disabled>Status:</option>
                            <option value="Disponível para uso" <?php if ($row['status_recebimento'] == 'Disponível para uso') echo 'selected'; ?>>Disponível para uso</option>
                            <option value="Em processo de produção" <?php if ($row['status_recebimento'] == 'Em processo de produção') echo 'selected'; ?>>Em processo de produção</option>
                            <option value="Em manutenção" <?php if ($row['status_recebimento'] == 'Em manutenção') echo 'selected'; ?>>Em manutenção</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="qtd_recebida">Quantidade Recebida:</label>
                        <input type="text" name="qtd_recebida" class="form-control" value="<?php echo htmlspecialchars($row['qtd_recebida']); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="localizacao_estoque">Localização no Estoque:</label>
                        <input type="text" name="localizacao_estoque" class="form-control" value="<?php echo htmlspecialchars($row['localizacao_estoque']); ?>">
                    </div>
                </div>
            </div>


            <div class="form-row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="historico_movimentacao">Histórico de Movimentação:</label>
                        <textarea name="historico_movimentacao" rows="1" class="form-control"><?php echo htmlspecialchars($row['historico_movimentacao']); ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="responsavel_movimentacao">Responsável pela Movimentação:</label>
                        <input type="text" name="responsavel_movimentacao" class="form-control" value="<?php echo htmlspecialchars($row['responsavel_movimentacao']); ?>">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">  
                <a href="index.php" class="btn btn-secondary float-right mr-2" onclick="confirmarCancelamento(event)">Cancelar</a>
                <button type="submit" class="btn btn-primary float-right">Salvar Edição</button>
            </div>
        </form>
    </div>
</body>
</html>