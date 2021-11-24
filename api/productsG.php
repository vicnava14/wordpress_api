<?php 	

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

	use Automattic\WooCommerce\HttpClient\HttpClientException;


	$consumer_key = 'ck_6792683174acc4589d49d0ad5e0636c36b2cdfa4';
	$consumer_secret = 'cs_13a60a4ae7bdf9bdfade4b5f143664c130d72c18';
	$options = array('ssl_verify' => false, 'debug' => true, 'version' => 'wc/v2');
	$store = 'https://dev.lamarcawell.com/';
		$woocommerce= new Client($store,$consumer_key,$consumer_secret, $options);


		try{

$results = $woocommerce->get('products?per_page=100');
// echo '<pre><code>' . print_r( $results, true) . '</code></pre>';
// foreach ( $results as $item_key => $item ) {

//     // echo '<pre><code>' . print_r($woocommerce->get('products/'.$item->id.'/variations')) . '</code></pre>';
//         if($item->id){
//             if($item->brands){
//                 foreach ( $item->brands as $brand_key => $brand_item ) {
//                  echo '<pre>Codigo_marca: <code>' . print_r($brand_item->id, true) . '</code></pre>';
//                 echo '<pre>Nombre_marca: <code>' . print_r($brandi_tem->name, true) . '</code></pre>';
                    
//                 }  
//             }else{
//                  echo '<pre>Codigo_marca: <code>'. '</code></pre>';
//                 echo '<pre>Nombre_marca: <code>' . '</code></pre>';
//             }
//                 echo '<pre>Barras: <code>' . print_r($item->sku, true) . '</code></pre>';
//                 echo '<pre>IVA: <code>' . print_r($item->id, true) . '</code></pre>';
//                 echo '<pre>Tipo_IVA: <code>' . print_r($item->id, true) . '</code></pre>';
//         }
//         if($item->attributes){
//             foreach ( $item->attributes as $attribute_key => $attribute_item ) {
//                 if($attribute_item->name=='Talla'){
//                     echo '<pre><code>Talla_id: ' . print_r($attribute_item->id, true) . '</code></pre>';
//                     echo '<pre><code>Talla: ' . print_r($attribute_item->name, true) . '</code></pre>';
//                     echo '<pre><code>Nombre_talla: ' . print_r($attribute_item->options, true) . '</code></pre>';
//                     // echo '<pre><code>' . print_r($woocommerce->get('products/attributes/' . $attribute_item->id)) . '</code></pre>';
            
//                 }
//                 if($attribute_item->name=='Color'){
//                     echo '<pre><code>Color_id: ' . print_r($attribute_item->id, true) . '</code></pre>';
//                     echo '<pre><code>Color: ' . print_r($attribute_item->name, true) . '</code></pre>';
//                     echo '<pre><code>Nombre_color: ' . print_r($attribute_item->options, true) . '</code></pre>';
//                     // echo '<pre><code>' . print_r($woocommerce->get('products/attributes/' . $attribute_item->id)) . '</code></pre>';
            
//                 }
//             }
//         }
//                 echo '<pre>Stock: <code>' . print_r($item->stock_quantity, true) . '</code></pre>';
//                 echo '<pre>Codigo: <code>' . print_r($item->id, true) . '</code></pre>';
//                 echo '<pre>Nombre: <code>' . print_r($item->name, true) . '</code></pre>';
//                 echo '<pre>Composición: <code>' . print_r($item->sku, true) . '</code></pre>';
//             foreach ( $item->attributes as $attribute_key => $attribute_item ) {
//                 if($attribute_item->name=='Genero'){
//                     echo '<pre><code>Genero_id: ' . print_r($attribute_item->id, true) . '</code></pre>';
//                     echo '<pre><code>Genero: ' . print_r($attribute_item->name, true) . '</code></pre>';
//                     echo '<pre><code>Nombre_genero: ' . print_r($attribute_item->options, true) . '</code></pre>';
//                     // echo '<pre><code>' . print_r($woocommerce->get('products/attributes/' . $attribute_item->id)) . '</code></pre>';
            
//                 }
//             }
//                 echo '<pre>Género: <code>' . print_r($item->id, true) . '</code></pre>';
//                 echo '<pre>PVP: <code>' . print_r($item->price, true) . '</code></pre>';
//                 echo '<pre>Nombre2: <code>' . print_r($item->slug, true) . '</code></pre>';
//                 echo '<pre>Abrev: <code>' . print_r($item->id, true) . '</code></pre>';
//                 echo '<pre>Metatítulos: <code>' . print_r($item->id, true) . '</code></pre>';
//                 echo '<pre>Dto1: <code>' . print_r($item->id, true) . '</code></pre>';
//                 echo '<pre>NO_PUBLICAR_WEB: <code>' . print_r($item->id, true) . '</code></pre>';
//         if($item->categories){
//             foreach ( $item->categories as $category_key => $category_item ) {
//                     echo '<pre>CATEGORIA_id <code>' . print_r($category_item->id, true) . '</code></pre>';
//                     echo '<pre>CATEGORIA_name <code>' . print_r($category_item->name, true) . '</code></pre>';
//                     echo '<pre>CATEGORIA_glug <code>' . print_r($category_item->slug, true) . '</code></pre>';
//                     // echo '<pre><code>' . print_r($woocommerce->get('products/categories/' . $category_item->id)) . '</code></pre>';
//             }
//         }
//                 echo '<pre>SOSTENIBILIDAD: <code>' . print_r($item->id) . '</code></pre>';
            
            


            
            
     
//         // if($item->variations){
//         //     foreach ( $item->variations as $variation_key => $variation_item ) {
//         //             echo '<pre>' .$variation_key . '</pre>';
//         //             echo '<pre>' . print_r($variation_item->id) . '</pre>';
//         //             echo '<pre><code>' . print_r($woocommerce->get('products/' . $item->id . '/variations/' . $variation_item->id)) . '</code></pre>';
//         //     }
//         // }
//         // if($item->categories){
//         //     foreach ( $item->categories as $category_key => $category_item ) {
//         //             echo '<pre><code>' .$category_key . '</code></pre>';
//         //             echo '<pre><code>' . print_r($category_item->id) . '</code></pre>';
//         //             echo '<pre><code>' . print_r($woocommerce->get('products/categories/' . $category_item->id)) . '</code></pre>';
//         //     }
//         // }
//         // if($item->attributes){
//         //     foreach ( $item->attributes as $attribute_key => $attribute_item ) {
//         //             echo '<pre><code>' .$attribute_key . '</code></pre>';
//         //             echo '<pre><code>' . print_r($attribute_item->id) . '</code></pre>';
//         //             echo '<pre><code>' . print_r($woocommerce->get('products/attributes/' . $attribute_item->id)) . '</code></pre>';
//         //     }
//         // }
//         // if($item->shipping_class){
//         //     foreach ( $item->shipping_class as $shipping_classe_key => $shipping_classe_item ) {
//         //             echo '<pre><code>' .$shipping_classe_key . '</code></pre>';
//         //             echo '<pre><code>' . print_r($shipping_classe_item->id) . '</code></pre>';
//         //             echo '<pre><code>' . print_r($woocommerce->get('products/shipping_classes/' . $shipping_classe_item->id)) . '</code></pre>';
//         //     }
//         // }
//         // if($item->tags){
//         //     foreach ( $item->tags as $tag_key => $tag_item ) {
//         //             echo '<pre><code>' .$tag_key . '</code></pre>';
//         //             echo '<pre><code>' . print_r($tag_item->id) . '</code></pre>';
//         //             echo '<pre><code>' . print_r($woocommerce->get('products/tags/' . $tag_item->id)) . '</code></pre>';
//         //     }
//         // }
        
//                     // echo '<pre><code>' . print_r($woocommerce->get('products/reviews')) . '</code></pre>';


 $products= array(
     array(
 		'Codigo_marca' 		=> '1',
 		'Nombre_marca' 		=> '0001',
 		'Barras'			=>'3',
 		'IVA'				=>'21.00',
 		'Tipo_IVA'		=>'01',
 		'Talla'				=>'',
 		'Nombre_talla' 	=>'',
 		'Color'				=>'',
 		'Nombre_color'	=>'',
 		'Stock'				=>'100',
 		'Codigo'			=>'18AS0001',
 		'Nombre'			=>"Women's Cloudflow Rock / Rose",
 		'Composicion'		=>'2mm limestone based neoprene',
 		'Genero'			=>'Men',
 		'Temporada'			=>'Fall - Winter 18',
 		'PVP'				=>'',
 		'Nombre2'			=>'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
 		'Abrev'				=>'AT270010-600',
 		'Metatitulos'		=>'1',
 		'Dto1'				=>'',
 		'Dto2'				=>'',
 		'Dto3'				=>'',
 		'no_publicar_web'	=>'publish',
 		'CATEGORIA_1'		=>'CONSCIOUS',
 		'CATEGORIA_2'		=>'Active Garments',
 		'CATEGORIA_3'		=>'Activewear M',
 		'CATEGORIA_4'		=>'Activewear W',
 		'sostenibilidad'	=>'CONSCIOUS'

    ),
 );

 
 
 foreach($products as $product){
$data=array();
$data['name']=array();
$data['type']=array();
$data['regular_price']=array();
$data['description']=array();
$data['brands']=array();
$data['categories']=array();
$data['attributes']=array();
$data['meta_data']=array();

$brands=$woocommerce->get('brands');
// echo '<pre>' . print_r($brands) . '</pre>';
 foreach ( $brands as $brand ) {
     if($brand->name==$product['Nombre_marca']){
        array_push($data['brands'], $brand->term_id);
        break;
    }
}
array_push($data['meta_data'], array('key'=>'Barras', 'value'=>$product['Barras']));

$taxes=$woocommerce->get('taxes');

if($taxes){
    foreach($taxes as $tax){
        if(floatval($tax->rate)==number_format(floatval($product['IVA']),4)){
            $data['tax_class']=$tax->class;
        }
    }
}
array_push($data['meta_data'], array('key'=>'Tipo_IVA', 'value'=>$product['Tipo_IVA']));

$attributes=$woocommerce->get('products/attributes');
// echo '<pre>' . print_r($attributes) . '</pre>';
if($product['Color']){
     foreach ( $attributes as $attribute ) {
     if($attribute->name=='Color'){
         $terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
         
     foreach ( $terms as $term ) {
         if($term->name==$product['Nombre_color']){
            array_push($data['attributes'],array('id'=> $attribute->id,'options'=>$product['Color']));
         }
     }
        break;
    }
}
}

if($product['talla']){
   foreach ( $attributes as $attribute ) {
     if($attribute->name=='Talla'){
         $terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
         
     foreach ( $terms as $term ) {
         if($term->name==$product['Nombre_talla']){
            array_push($data['attributes'],array('id'=> $attribute->id,'options'=>$product['Talla']));
         }
     }
        break;
    }
} 
}

$data['stock_quantity']=$product['Stock'];
$data['sku']=$product['Codigo'];

$data['name']=$product['Nombre'];
$data['regular_price']=$product['PVP'];
$data['description']=$product['Nombre2'];

array_push($data['meta_data'], array('key'=>'Composicion', 'value'=>$product['Composicion']));
array_push($data['meta_data'], array('key'=>'Genero', 'value'=>$product['Genero']));
array_push($data['meta_data'], array('key'=>'Temporada', 'value'=>$product['Temporada']));
// array_push($data['meta_data'], array('key'=>'PVP', 'value'=>$product['PVP']));


// array_push($data['meta_data'], array('key'=>'Nombre2', 'value'=>$product['Nombre2']));



$data['abrev']=$product['Abrev'];
$data['Metatitulos']=$product['Metatitulos'];
$data['status']=$product['no_publicar_web'];

$categories=$woocommerce->get('products/categories');
     foreach ( $categories as $category ) {
         if($category->name==$product['CATEGORIA_1']){
array_push($data['categories'], array('key'=>'category_1', 'value'=>$category->id));
         }
         if($category->name==$product['CATEGORIA_2']){
array_push($data['categories'], array('key'=>'category_2', 'value'=>$category->id));
         }
         if($category->name==$product['CATEGORIA_3']){
array_push($data['categories'], array('key'=>'category_3', 'value'=>$category->id));
         }
         if($category->name==$product['CATEGORIA_4']){
array_push($data['categories'], array('key'=>'category_4', 'value'=>$category->id));
         }
}

$categories=$woocommerce->get('products/categories');
if($product['sostenibilidad']){
     foreach ( $categories as $category ) {
        //  print_r($category);
         if($category->name=='CONCIOUS'){
             $data['sostenibilidad']=$category->id;
         }elseif($categories['name']=='SUPER CONCIOUS'){
             $data['sostenibilidad']=$category->id;
         }else{
             $data['sostenibilidad']='';
         }
     }
}
print_r($data);
   die();


     
 }
 
		} catch (HttpClientException $e) {

			echo '<pre><code>' . print_r( $e->getMessage(), true ) . '</code></pre>';//error message.
		}		


 ?>
