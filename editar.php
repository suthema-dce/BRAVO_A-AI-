<?php
session_start();

// Verifica se o ID do item foi passado na URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verifica se o ID é válido e se o item existe no carrinho
    if (isset($_SESSION['carrinho'][$id])) {
        $itemParaEditar = $_SESSION['carrinho'][$id];
    } else {
        // Se o item não for encontrado, redireciona de volta para o carrinho
        header("location: receba.php");
        exit();
    }
} else {
    // Se nenhum ID for passado, redireciona de volta para o carrinho
    header("location: receba.php");
    exit();
}

// Processa o formulário de edição quando ele é enviado (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_quantidade'])) {
    $novaQuantidade = floatval($_POST['nova_quantidade']);

    // Validação básica da quantidade
    if ($novaQuantidade > 0 && $novaQuantidade <= 999) {
        // Atualiza a quantidade do item no carrinho
        $_SESSION['carrinho'][$id]['quant'] = $novaQuantidade;
        // Recalcula o subtotal
        $_SESSION['carrinho'][$id]['subtotal'] = $_SESSION['carrinho'][$id]['valor'] * $novaQuantidade;

        // Redireciona de volta para o carrinho após a edição
        header("location: receba.php");
        exit();
    } else {
        $erro = "A quantidade deve ser um número positivo e menor que 999.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item - Bravo Açaí</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #8A2BE2, #EE82EE); /* Roxo para Rosa */
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            justify-content: center;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            box-sizing: border-box;
            border: 2px solid #DDA0DD;
            text-align: center;
        }
        h3 {
            font-family: 'Fredoka One', cursive;
            color: #FF69B4; /* Rosa Choque */
            margin-bottom: 20px;
            font-size: 2em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        p {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: #DDA0DD;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            font-size: 1.1em;
            color: #DDA0DD;
        }
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #DDA0DD;
            background-color: #333;
            color: #fff;
            font-size: 1em;
            box-sizing: border-box;
            text-align: center;
        }
        input[type="submit"], .back-btn {
            background-color: #FF69B4; /* Rosa Choque */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            text-align: center;
            display: block; /* Para os botões ficarem em novas linhas */
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"]:hover, .back-btn:hover {
            background-color: #FF1493; /* Rosa mais escuro */
            transform: translateY(-2px);
        }
        input[type="submit"]:active, .back-btn:active {
            transform: translateY(0);
        }
        .error {
            color: #FFD700; /* Dourado para avisos */
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Editar Item do Carrinho</h3>

        <?php if (isset($itemParaEditar)) : ?>
            <p>Produto: <strong><?= htmlspecialchars($itemParaEditar['produto']) ?></strong></p>
            <p>Valor Unitário: <strong>R$ <?= number_format($itemParaEditar['valor'], 2, ',', '.') ?></strong></p>

            <form action="editar_item.php?id=<?= $id ?>" method="POST">
                <label for="nova_quantidade">Nova Quantidade:</label>
                <input type="number" name="nova_quantidade" id="nova_quantidade"
                       step="0.001" min="0.001" max="999"
                       value="<?= htmlspecialchars($itemParaEditar['quant']) ?>" required>

                <?php if (isset($erro)) : ?>
                    <p class="error"><?= $erro ?></p>
                <?php endif; ?>

                <input type="submit" value="Salvar Edição">
            </form>
            <button class="back-btn" onclick="window.location.href='receba.php'" style="margin-top: 15px;">Voltar ao Carrinho</button>
        <?php else : ?>
            <p class="error">Item não encontrado no carrinho.</p>
            <button class="back-btn" onclick="window.location.href='receba.php'" style="margin-top: 15px;">Voltar ao Carrinho</button>
        <?php endif; ?>
    </div>
</body>
</html>