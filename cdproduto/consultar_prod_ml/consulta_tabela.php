<?php

use JsonSchema\Uri\Retrievers\Curl;
include("../../_incluir/funcoes.php");
if(isset($_GET['titulo'])){
    $psTitulo = $_GET['titulo'];
   $pesquisa = str_replace(" ","%20",$psTitulo); //retirando os espaçoes em branco
 
   if(isset($_GET['pg'])){
    $page = $_GET['pagina'];
   }else{
    $page = 0;
   }
 
}


    $url = "https://api.mercadolibre.com/sites/MLB/search?q=".$pesquisa."&offset=".$page."";
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $resultado = json_decode(curl_exec($ch));

   //var_dump($resultado);
?>
<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>
        <tr id="cabecalho_pesquisa_consulta">
            <td>
                <p>Item</p>
            </td>
            <td>
                <p>Img</p>
            </td>

            <td>
                <p>Titulo</p>
            </td>
            <td>
                <p>Frete</p>
            </td>
            <td>
                <p>Quantidade</p>
            </td>

            <td>
                <p>Valor</p>
            </td>

            <td>

            </td>


        </tr>

        <?php
        $linha = 0;
    foreach($resultado -> results as $ator){
       //var_dump($ator);
        $img = $ator ->thumbnail;
        $titulo = $ator ->title;
        $valor = $ator ->price;
        $link = $ator ->permalink;
        $frete = $ator ->shipping->free_shipping;
        $full = $ator ->shipping->tags;
        if(isset($full[0])){
        $full = $full[0];
        if($full=="fulfillment"){
            $full = "<i class='fa-solid fa-bolt-lightning'></i>  Full";
        }else{
            $full = "";
        }
        }else{
            $full="";
        }
        $qtd = $ator ->available_quantity;
        $linha = $linha + 1 ;
      
?>

        <tr id="linha_pesquisa">
            <td>
                <p> <?php echo $linha; ?></p>
            </td>
            <td>
                <img style="width:80px ;" src="<?php echo $img; ?>">
            </td>
            <td style="width:500px ;">
                <p><?php echo $titulo ?></p>
            </td>
            <td>

                <?php
                if($frete ==1){ echo
                   '<p style="color:green">'."Gratis ".$full.'</p>';
                }elseif($frete ==""){
                    '<p>'."Pago".'</p>';
                }
               ?>
            </td>
            <td>
                <p><?php echo $qtd; ?></p>
            </td>

            <td>
                <p><?php echo real_format($valor); ?></p>
            </td>
            <td id="botaoEditar">

                <a href="<?php echo $link; ?>" Target="_blank">

                    <button type="button" name="editar">Visualizar</button>
                </a>

            </td>


        </tr>

        <?php
    }
    ?>
    </tbody>
</table>