<?php
session_start();

// Pega os dados do pedido da sessão (se existirem)
$dadosPedido = isset($_SESSION['dados_pedido']) ? $_SESSION['dados_pedido'] : null;

// Limpa os dados do pedido da sessão após exibi-los (opcional, para não exibir novamente)
unset($_SESSION['dados_pedido']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Finalizada - Bravo Açaí</title>
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
            justify-content: center; /* Centraliza verticalmente */
        }
        .container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 50px 40px; /* Mais padding para centralizar bem */
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            box-sizing: border-box;
            border: 2px solid #DDA0DD;
            text-align: center;
        }
        h3 {
            font-family: 'Fredoka One', cursive;
            color: #32CD32; /* Verde Lima */
            margin-bottom: 25px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        p {
            font-size: 1.3em;
            color: #DDA0DD;
            margin-bottom: 15px;
        }
        .order-details {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
            text-align: left;
        }
        .order-details p {
            font-size: 1em;
            margin-bottom: 8px;
        }
        .button-group {
            margin-top: 30px;
        }
        .button-group button {
            background-color: #FF69B4; /* Rosa Choque */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        .button-group button:hover {
            background-color: #FF1493; /* Rosa mais escuro */
            transform: translateY(-2px);
        }
        .button-group button:active {
            transform: translateY(0);
        }
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            h3 {
                font-size: 2em;
            }
            p {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>✅ Compra Finalizada!</h3>
        <p>Seu pedido foi realizado com sucesso!</p>

        <?php if ($dadosPedido) : ?>
            <div class="order-details">
                <p><strong>Nome:</strong> <?= htmlspecialchars($dadosPedido['nome_cliente']) ?></p>
                <p><strong>Endereço:</strong> <?= htmlspecialchars($dadosPedido['endereco_entrega']) ?></p>
                <p><strong>Pagamento:</strong> <?= htmlspecialchars($dadosPedido['metodo_pagamento']) ?></p>
                <p><strong>Total:</strong> R$ <?= number_format($dadosPedido['total'], 2, ',', '.') ?></p>
                <p><strong>Data:</strong> <?= htmlspecialchars($dadosPedido['data_pedido']) ?></p>
            </div>
        <?php else : ?>
            <p>Obrigado por sua compra!</p>
        <?php endif; ?>

        <div class="button-group">
            <button onclick="window.location.href='index.php'">Fazer Novo Pedido</button>
        </div>
    </div>
</body>
</html>