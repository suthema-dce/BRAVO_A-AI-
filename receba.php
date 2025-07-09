<?php

session_start();

//Recebendo dados do formulário
if( isset( $_GET["produto"] ) && isset( $_GET["qtd"] ) ) {
    $produto = $_GET["produto"];
    $qtd = floatval( $_GET["qtd"] );
    
    //Separando a string $produto que vem
    //com o nome e o valor juntos.
    $arrayProd = explode("*", $produto);

    //Passando as partes do array para outras variáveis
    $nomeProd = $arrayProd[0];
    $valorProd = floatval( $arrayProd[1] );

    //Calculando o subtotal de um produto
    $subTotal = ( $valorProd * $qtd );

    //Criando um array associativo com os dados
    //do produto devidamente formatados
    $item = [
        "produto"   => $nomeProd,
        "valor"     => $valorProd,
        "quant"     => $qtd,
        "subtotal"  => $subTotal
    ];

    //Inserind o produto no carrinho
    array_push( $_SESSION["carrinho"], $item );
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de compras - Bravo Açaí</title>
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
            max-width: 900px;
            margin: 30px auto;
            box-sizing: border-box;
            border: 2px solid #DDA0DD;
        }
        h3 {
            font-family: 'Fredoka One', cursive;
            color: #FF69B4; /* Rosa Choque */
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden; /* Ensures rounded corners apply to content */
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #DDA0DD;
            color: #fff;
        }
        th {
            background-color: #C71585; /* Rosa Escuro */
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.1);
        }
        .btn-action {
            background-color: #DDA0DD; /* Ameixa */
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s ease-in-out;
            outline: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 35px;
        }

        .btn-action:hover {
            background-color: #FF69B4; /* Rosa Choque */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }

        .btn-action:active {
            background-color: #C71585; /* Rosa Escuro */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transform: translateY(0);
        }
        .button-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap; /* Permite quebrar linha em telas pequenas */
            gap: 20px;
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
        }
        .button-group button:hover {
            background-color: #FF1493; /* Rosa mais escuro */
            transform: translateY(-2px);
        }
        .button-group button:active {
            transform: translateY(0);
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid #DDA0DD;
                margin-bottom: 10px;
                border-radius: 10px;
            }
            td {
                border: none;
                border-bottom: 1px solid #DDA0DD;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }
            td:before {
                position: absolute;
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                color: #DDA0DD;
            }
            td:nth-of-type(1):before { content: "NUM."; }
            td:nth-of-type(2):before { content: "PRODUTO"; }
            td:nth-of-type(3):before { content: "VALOR UN./kg"; }
            td:nth-of-type(4):before { content: "QUANT."; }
            td:nth-of-type(5):before { content: "SUBTOTAL"; }
            td:nth-of-type(6):before { content: "EDITAR"; }
            td:nth-of-type(7):before { content: "EXCLUIR"; }

            .btn-action {
                margin: 5px 0;
            }
            .button-group {
                flex-direction: column;
                align-items: center;
            }
            .button-group button {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Carrinho de compras</h3>

        <?php if( count( $_SESSION["carrinho"] ) == 0 ) : ?>
            <p style="text-align: center; font-size: 1.2em; color: #DDA0DD;">Seu carrinho está vazio. Adicione alguns itens!</p>
        <?php else : ?>
            <table>
                <thead>
                    <th>NUM.</th>
                    <th>PRODUTO</th>
                    <th>VALOR UN./kg</th>
                    <th>QUANT.</th>
                    <th>SUBTOTAL</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
                        $num = 1;
                        foreach( $_SESSION["carrinho"] as $item ) :
                    ?>
                       <tr>
                            <td> <?= $num ?> </td>
                            <td> <?= htmlspecialchars($item["produto"]) ?> </td>
                            <td> R$ <?= number_format($item["valor"], 2, ',', '.') ?> </td>
                            <td> <?= number_format($item["quant"], 3, ',', '.') ?> </td>
                            <td> R$ <?= number_format($item["subtotal"], 2, ',', '.') ?> </td>
                            <td class="btn-action" onclick="window.location.href='editar.php?id=<?= $num-1 ?>'">
                                ✏️
                            </td>
                            <td class="btn-action" onclick="excluir(<?= $num-1 ?>, '<?= htmlspecialchars($item['produto']) ?>')">
                                ❌
                            </td>
                       </tr>
                    <?php
                        $num++;
                        endforeach;
                    ?>
                </tbody>
            </table>

            <?php
                $totalCarrinho = 0;
                foreach( $_SESSION["carrinho"] as $item ) {
                    $totalCarrinho += $item["subtotal"];
                }
            ?>
            <div style="text-align: right; margin-top: 20px; font-size: 1.5em; font-weight: bold; color: #FF69B4;">
                Total do Carrinho: R$ <?= number_format($totalCarrinho, 2, ',', '.') ?>
            </div>
            <br> <?php endif; ?>

        <div class="button-group">
            <button onclick="window.location.href='index.php'">Continuar comprando</button>
            <button onclick="window.location.href='cancela.php'">Cancelar compra</button>
            <?php if( count( $_SESSION["carrinho"] ) > 0 ) : ?>
                <button onclick="window.location.href='finalizar.php'" style="background-color: #32CD32;">Finalizar Compra e Pagar</button>
            <?php endif; ?>
        </div>
        
    <script>
        function excluir(id, prod) {
            if( confirm("Deseja remover o item '"+prod+"' do carrinho?") ) {
                window.location.href = "exclui.php?id="+id
            }
        }
    </script>
    </div>
</body>
</html>