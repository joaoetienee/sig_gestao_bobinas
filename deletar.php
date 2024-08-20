<?php
include 'config.php';

if (isset($_GET['id_bobina'])) {
    $id_bobina = $_GET['id_bobina'];

    $sql = "DELETE FROM bobinas WHERE id_bobina = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_bobina);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Erro ao deletar a bobina: " . $stmt->error;
        }

        $stmt->close();

    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
    
} else {
    echo "ID da bobina não fornecido.";
}

$conn->close();
?>