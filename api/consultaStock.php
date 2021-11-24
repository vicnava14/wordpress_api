<?php 	

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

	use Automattic\WooCommerce\HttpClient\HttpClientException;

	$consumer_key = 'ck_0094c218b04bc46ae7372351465fe55be566d33e';
	$consumer_secret = 'cs_88b1865aa900fab93b48b73151a230b15cc0f089';
	$options = array('ssl_verify' => false, 'debug' => true);
	$store = 'http://localhost/wordpress/';
		$woocommerce= new Client($store,$consumer_key,$consumer_secret, $options);
    try{ 
        $consultaStock=
        
            array(
                "Result"=> "OK",
                "Data" => array(
                    "_Fecha" => "2019-08-13 18:27:18",
                    "_Almacen" => "01",
                    "_Articulo" => "001510222",
                    "_Total_Existencias" => 2.000000,
                    "_Total_Disponible" => 2.000000,
                    "_HoraConsulta" => "2019-08-13 18:27:18",
                    ) 
            
            );

        $consultaStock2=
        
            array(
                "Result"=> "OK",
                "Data" => array(
                    "_Fecha" => "2019-08-13 18:27:18",
                    "_Almacen" => "04",
                    "_Articulo" => "001510222",
                    "_Total_Existencias" => 1.000000,
                    "_Total_Disponible" => 1.000000,
                    "_HoraConsulta" => "2019-08-13 18:27:18",
                    ) 
            
        );

// echo '<pre>' . print_r($consultaStock, true) . '</pre>';

$data = array( 
    'stock_quantity' => $consultaStock['Data']['_Total_Disponible']+$consultaStock2['Data']['_Total_Disponible']
    );

echo '<pre>' . print_r($data, true) . '</pre>';

print_r($woocommerce->put('products/29', $data));
die();
    }catch(HttpClientException $e){		
        echo '<pre><code>' . print_r( $e->getMessage(), true ) . '</code></pre>';//error message.
    }

?>