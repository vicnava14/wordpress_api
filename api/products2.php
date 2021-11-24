<?php 	

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

	use Automattic\WooCommerce\HttpClient\HttpClientException;

	$consumer_key = 'ck_6792683174acc4589d49d0ad5e0636c36b2cdfa4';
	$consumer_secret = 'cs_13a60a4ae7bdf9bdfade4b5f143664c130d72c18';
	$options = array('ssl_verify' => false, 'debug' => true);
	$store = 'https://dev.lamarcawell.com/';
		$woocommerce= new Client($store,$consumer_key,$consumer_secret);


$results = $woocommerce->get('products?filter[sku]=001510225');

echo '<pre><code>' . print_r( $results, true) . '</code></pre>';

// 		try{

// $results = $woocommerce->get('products');
// // echo '<pre><code>' . print_r( $results, true) . '</code></pre>';
// foreach ( $results as $item_key => $item ) {

//     echo '<pre><code>' .$item_key . '</code></pre>';
//     echo '<pre><code>' . print_r($item->id) . '</code></pre>';
//     echo '<pre><code>' . print_r($woocommerce->get('products/'.$item->id.'/variations')) . '</code></pre>';

//         if($item->variations){
//             foreach ( $item->variations as $variation_key => $variation_item ) {
//                     echo '<pre><code>' .$variation_key . '</code></pre>';
//                     echo '<pre><code>' . print_r($variation_item->id) . '</code></pre>';
//                     echo '<pre><code>' . print_r($woocommerce->get('products/' . $item->id . 'variations/' . $variation_item->id)) . '</code></pre>';
//             }
//         }
//         if($item->categories){
//             foreach ( $item->categories as $category_key => $category_item ) {
//                     echo '<pre><code>' .$category_key . '</code></pre>';
//                     echo '<pre><code>' . print_r($category_item->id) . '</code></pre>';
//                     echo '<pre><code>' . print_r($woocommerce->get('products/categories/' . $category_item->id)) . '</code></pre>';
//             }
//         }
//         if($item->attributes){
//             foreach ( $item->attributes as $attribute_key => $attribute_item ) {
//                     echo '<pre><code>' .$attribute_key . '</code></pre>';
//                     echo '<pre><code>' . print_r($attribute_item->id) . '</code></pre>';
//                     echo '<pre><code>' . print_r($woocommerce->get('products/attributes/' . $attribute_item->id)) . '</code></pre>';
//             }
//         }
//         if($item->shipping_class){
//             foreach ( $item->shipping_class as $shipping_classe_key => $shipping_classe_item ) {
//                     echo '<pre><code>' .$shipping_classe_key . '</code></pre>';
//                     echo '<pre><code>' . print_r($shipping_classe_item->id) . '</code></pre>';
//                     echo '<pre><code>' . print_r($woocommerce->get('products/shipping_classes/' . $shipping_classe_item->id)) . '</code></pre>';
//             }
//         }
//         if($item->tags){
//             foreach ( $item->tags as $tag_key => $tag_item ) {
//                     echo '<pre><code>' .$tag_key . '</code></pre>';
//                     echo '<pre><code>' . print_r($tag_item->id) . '</code></pre>';
//                     echo '<pre><code>' . print_r($woocommerce->get('products/tags/' . $tag_item->id)) . '</code></pre>';
//             }
//         }
        
//                     echo '<pre><code>' . print_r($woocommerce->get('products/reviews')) . '</code></pre>';

// }


// 		} catch (HttpClientException $e) {

// 			echo '<pre><code>' . print_r( $e->getMessage(), true ) . '</code></pre>';//error message.
// 		}		


 ?>

 
<?php
//  //editar
// $data = [
//     'regular_price' => '24.00'
// ];

// // echo '<pre><code>' .print_r($woocommerce->put('products/13', $data)) . '</code></pre>';
?>


<?php
// crearte
$data = [
    'name' => 'Premium Quality21',
    'type' => 'simple',
    'regular_price' => '521.99',
    'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
    'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
    'categories' => [
        [
            'id' => 9
        ],
        [
            'id' => 14
        ]
    ],
    'images' => [
        [
            'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
        ],
        [
            'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
        ]
    ]
];

$products_new=$woocommerce->post('products', $data);
print_r($products_new);
?>