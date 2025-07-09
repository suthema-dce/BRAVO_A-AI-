<?php
//Área de código PHP
session_start();

//Verificando se há uma sessão com o
//nome do carrinho já criada
if( !isset( $_SESSION["carrinho"] ) ) {
    $_SESSION["carrinho"] = array();
}

$listaProdutos = [
    "Açaí Pequeno (200ml)"      => 10.00,
    "Açaí Médio (500ml)"        => 15.00,
    "Açaí Grande (700ml)"       => 20.00,
    "Morangos"                  => 2.00, // Preço simbólico para acompanhamentos
    "Kiwi"                      => 2.00,
    "Banana"                    => 2.00,
    "Manga"                     => 2.00,
    "Granola"                   => 2.00,
    "Leite Condensado"          => 2.00,
    "Paçoca"                    => 2.00,
    "Leite em pó"               => 2.00,
    "Nutella (+R$2)"            => 2.00, // Adicional de 2 reais já incluso no valor base
    "Creme de Oreo (+R$2)"      => 2.00,
    "Chocolate branco (+R$2)"   => 2.00
];
?>

<!DOCTYPE html>
 <html lang="pt-BR">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bravo Açaí - Cardápio Digital</title>
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
        }
        .container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 600px;
            margin: 30px auto;
            box-sizing: border-box;
            border: 2px solid #DDA0DD;
        }
        h1 {
            font-family: 'Fredoka One', cursive;
            color: #FF69B4; /* Rosa Choque */
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.8em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        img.logo {
            display: block;
            margin: -20px auto 20px auto;
            max-width: 200px;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(0,0,0,0.5));
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            font-weight: bold;
            font-size: 1.1em;
            color: #DDA0DD;
        }
        select, input[type="number"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #DDA0DD;
            background-color: #333;
            color: #fff;
            font-size: 1em;
            box-sizing: border-box;
        }
        select option {
            background-color: #333;
            color: #fff;
        }
        input[type="submit"], .view-cart-btn {
            background-color: #FF69B4; /* Rosa Choque */
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            text-align: center;
            margin-top: 10px;
        }
        input[type="submit"]:hover, .view-cart-btn:hover {
            background-color: #FF1493; /* Rosa mais escuro */
            transform: translateY(-2px);
        }
        input[type="submit"]:active, .view-cart-btn:active {
            transform: translateY(0);
        }
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        @media (min-width: 768px) {
            form {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: flex-end;
            }
            label, select, input[type="number"] {
                width: 48%;
            }
            input[type="submit"] {
                width: 100%;
            }
            .form-actions {
                flex-direction: row;
                justify-content: space-between;
            }
            input[type="submit"], .view-cart-btn {
                width: calc(50% - 10px);
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 2em;
            }
            input[type="submit"], .view-cart-btn {
                font-size: 1em;
                padding: 12px 20px;
            }
        }
    </style>
 </head>
 <body>
    <div class="container">
        <img src="Logo.png" alt="Bravo Açaí Logo" class="logo">
        <h1>Cardápio Bravo Açaí</h1>

        <form action="receba.php" method="get">
            <div style="width: 100%;">
                <label for="produto">Produtos:</label>
                <select name="produto" id="produto" required>
                    <option value="">Selecione um produto</option>
                    <?php foreach( $listaProdutos as $p => $v ) : ?>
                        <option value="<?= $p."*".$v ?>">
                            <?= $p." | R$ ".number_format($v, 2, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="width: 100%;">
                <label for="qtd">Quantidade:</label>
                <input type="number" name="qtd" id="qtd" step="0.001" min="0.001" max="999" placeholder="Quant." required>
            </div>

            <div class="form-actions">
                <input type="submit" value="Adicionar ao carrinho">
                <?php if( count( $_SESSION["carrinho"] ) > 0 ) : ?>
                    <a href="receba.php" class="view-cart-btn">Ver itens do carrinho</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
 </body>
 </html>