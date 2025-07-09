<?php
session_start();

// Redireciona se o carrinho estiver vazio
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0) {
    header("location: index.php");
    exit();
}

$totalCarrinho = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $totalCarrinho += $item['subtotal'];
}

$erro = ''; // Variável para mensagens de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processa os dados do formulário
    $nome = htmlspecialchars(trim($_POST['nome']));
    $endereco = htmlspecialchars(trim($_POST['endereco']));
    $metodoPagamento = htmlspecialchars($_POST['metodo_pagamento']);

    // Validação simples (você pode adicionar mais validações aqui)
    if (empty($nome) || empty($endereco) || empty($metodoPagamento)) {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        // Armazena os dados do pedido na sessão (simulação de finalização)
        $_SESSION['dados_pedido'] = [
            'itens'             => $_SESSION['carrinho'],
            'total'             => $totalCarrinho,
            'nome_cliente'      => $nome,
            'endereco_entrega'  => $endereco,
            'metodo_pagamento'  => $metodoPagamento,
            'data_pedido'       => date('Y-m-d H:i:s')
        ];

        // Limpa o carrinho após "finalizar" o pedido
        unset($_SESSION['carrinho']);

        // Redireciona para a página de compra finalizada
        header("location: compra_finalizada.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Bravo Açaí</title>
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
            max-width: 600px;
            box-sizing: border-box;
            border: 2px solid #DDA0DD;
            text-align: center;
        }
        h3 {
            font-family: 'Fredoka One', cursive;
            color: #FF69B4; /* Rosa Choque */
            margin-bottom: 20px;
            font-size: 2.2em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        p {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: #DDA0DD;
        }
        .total-display {
            font-size: 1.8em;
            font-weight: bold;
            color: #32CD32; /* Verde Lima */
            margin-bottom: 25px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
            text-align: left;
        }
        label {
            font-weight: bold;
            font-size: 1.1em;
            color: #DDA0DD;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: calc(100% - 20px);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #DDA0DD;
            background-color: #333;
            color: #fff;
            font-size: 1em;
            box-sizing: border-box;
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
            display: block;
            width: 100%;
            box-sizing: border-box;
            margin-top: 10px;
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
            text-align: center;
        }
        .form-field {
            margin-bottom: 15px;
        }
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            h3 {
                font-size: 1.8em;
            }
            .total-display {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Finalizar Compra</h3>
        <p class="total-display">Total a Pagar: R$ <?= number_format($totalCarrinho, 2, ',', '.') ?></p>

        <?php if (!empty($erro)) : ?>
            <p class="error"><?= $erro ?></p>
        <?php endif; ?>

        <form action="finalizar.php" method="POST">
            <div class="form-field">
                <label for="nome">Seu Nome:</label>
                <input type="text" name="nome" id="nome" required placeholder="Ex: João da Silva">
            </div>

            <div class="form-field">
                <label for="endereco">Endereço de Entrega:</label>
                <input type="text" name="endereco" id="endereco" required placeholder="Ex: Rua A, 123 - Bairro B, Cidade">
            </div>

            <div class="form-field">
                <label for="metodo_pagamento">Forma de Pagamento:</label>
                <select name="metodo_pagamento" id="metodo_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="cartao">Cartão de Crédito/Débito</option>
                    <option value="pix">PIX</option>
                    <option value="dinheiro">Dinheiro</option>
                </select>
            </div>

            <input type="submit" value="Confirmar Pedido">
        </form>
        <button class="back-btn" onclick="window.location.href='receba.php'">Voltar ao Carrinho</button>
    </div>
</body>
</html>