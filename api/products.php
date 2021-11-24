<?php 	

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

	use Automattic\WooCommerce\HttpClient\HttpClientException;

	$consumer_key = 'ck_0094c218b04bc46ae7372351465fe55be566d33e';
	$consumer_secret = 'cs_88b1865aa900fab93b48b73151a230b15cc0f089';
	$options = array('ssl_verify' => false, 'debug' => true);
	$store = 'http://localhost/wordpress/';
		$woocommerce= new Client($store,$consumer_key,$consumer_secret, $options);
$num='001510222';

$results = $woocommerce->get('products', array('sku' => $num));

echo '<pre><code>' . print_r( $results, true) . '</code></pre>';
die();

?>