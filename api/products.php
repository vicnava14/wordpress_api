<?php 	
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

	use Automattic\WooCommerce\HttpClient\HttpClientException;

	$consumer_key = 'ck_0094c218b04bc46ae7372351465fe55be566d33e';
	$consumer_secret = 'cs_88b1865aa900fab93b48b73151a230b15cc0f089';
	$options = array('ssl_verify' => false, 'debug' => true);
	$store = 'http://localhost/wordpress/';
		$woocommerce= new Client($store,$consumer_key,$consumer_secret, $options);

		$usuario="SUPERVISOR";
		$clave='sage1987.';
		$empresa="02";
		$almacen1="01";
		$almacen2="02";
		$url = 'http://195.248.231.68:8080/';
		

		function callApi($method, $url, $data = false)
		{
			$curl = curl_init();
	
			switch ($method)
			{
				case "POST":
					curl_setopt($curl, CURLOPT_POST, 1);
					 echo("post");
					if ($data)
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					break;
				case "PUT":
					curl_setopt($curl, CURLOPT_PUT, 1);
					 echo("put");
					break;
				default:
					if ($data)
						$url = sprintf("%s?%s", $url, http_build_query($data));
				   
			}
	
			// Optional Authentication:
			// curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			// curl_setopt($curl, CURLOPT_USERPWD, "username:password");
			
	
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
			$result = curl_exec($curl);
	
			curl_close($curl);
		  
			return $result;
		}
	
		function login($usuario, $clave, $empresa, $url)
		{
			
			$method = "GET";
			$data = ['User' => $usuario, 'Pass' => $clave, 'Empresa' => $empresa];
			// print_r($data);
			// die();
			$resp = callApi($method, $url . 'Login', $data);
			
			$resp = json_decode($resp);
			if($resp->Result == "OK"){
				return $resp->Data;
			}else{
				die('no se pudo iniciar sesion');
			}
			
		
		}

		function createSlug($str, $delimiter = '-'){

			$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
			return $slug;
	
		}

		try{

		$hash =	login($usuario, $clave, $empresa, $url);

		$data= array(
			'hash' => $hash,
			'Codigo' => '19WA4995',
			'Almacen' => $almacen1,
			'Empresa' => $empresa
		);

		$productos_response =  callApi('GET', $url . 'ListadoArticulos' , $data);
		$productos_response= json_decode($productos_response);
			if($productos_response->Result == "OK"){
				print_r($productos_response->Data);
			}else{
				die('fallo al leer los productos');
			}

// $results = $woocommerce->get('products?per_page=100');

//  $products= array(
//      array(
//  		'Codigo_marca' 		=> '1',
//  		'Nombre_marca' 		=> '0001',
//  		'Barras'			=>'3',
//  		'IVA'				=>'21.00',
//  		'Tipo_IVA'		=>'01',
//  		'Talla'				=>'',
//  		'Nombre_talla' 	=>'',
//  		'Color'				=>'',
//  		'Nombre_color'	=>'',
//  		'Stock'				=>'100',
//  		'Codigo'			=>'18AS0001',
//  		'Nombre'			=>"Women's Cloudflow Rock / Rose",
//  		'Composicion'		=>'2mm limestone based neoprene',
//  		'Genero'			=>'Men',
//  		'Temporada'			=>'Fall - Winter 18',
//  		'PVP'				=>'160.00',
//  		'Nombre2'			=>'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
//  		'Abrev'				=>'AT270010-600',
//  		'Metatitulos'		=>'1',
//  		'Dto1'				=>'',
//  		'Dto2'				=>'',
//  		'Dto3'				=>'',
//  		'no_publicar_web'	=>'publish',
//  		'CATEGORIA_1'		=>'CONSCIOUS',
//  		'CATEGORIA_2'		=>'Active Garments',
//  		'CATEGORIA_3'		=>'Activewear M',
//  		'CATEGORIA_4'		=>'Activewear W',
//  		'sostenibilidad'	=>'CONSCIOUS'

//     ),
//  );


 
 foreach($productos_response->Data as $product){
$data=array();
$data['name']=array();
// $data['type']=array();
$data['price']=array();
$data['description']=array();
$data['brands']=array();
$data['categories']=array();
$data['attributes']=array();
$data['meta_data']=array();

// $brands=$woocommerce->get('brands');
// // echo '<pre>' . print_r($brands) . '</pre>';
//  foreach ( $brands as $brand ) {
//      if($brand->name==$product->Nombre_marca){
//         array_push($data['brands'], $brand->term_id);
//         break;
//     }
// }
array_push($data['meta_data'], array('key'=>'Barras', 'value'=>$product->Barras));

$taxes=$woocommerce->get('taxes');

if($taxes){
    foreach($taxes as $tax){
        if(floatval($tax->rate)==number_format(floatval($product->IVA),4)){
            $data['tax_class']=$tax->class;
        }
    }
}
array_push($data['meta_data'], array('key'=>'Tipo_IVA', 'value'=>$product->Tipo_IVA));

$attributes=$woocommerce->get('products/attributes');
// echo '<pre>' . print_r($attributes) . '</pre>';
if($product->Color){
     foreach ( $attributes as $attribute ) {
     if($attribute->name=='Color'){
         $terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
         
     foreach ( $terms as $term ) {
         if($term->name==$product->Nombre_color){
            array_push($data['attributes'],array('id'=> $attribute->id,'options'=>$product->Color));
         }
     }
        break;
    }
}
}

if($product->Talla){
   foreach ( $attributes as $attribute ) {
     if($attribute->name=='Talla'){
         $terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
         
     foreach ( $terms as $term ) {
         if($term->name==$product->Nombre_talla){
            array_push($data['attributes'],array('id'=> $attribute->id,'options'=>$product->Talla));
         }
     }
        break;
    }
} 
}

$data['stock_quantity']=$product->Stock;
$data['sku']=$product->Codigo;

$data['name']=$product->Nombre;
$data['price']=$product->PVP;
$data['description']=$product->Nombre2;

array_push($data['meta_data'], array('key'=>'Composicion', 'value'=> isset($product->Composicion) ? $product->Composition : ''));
array_push($data['meta_data'], array('key'=>'Genero', 'value'=> isset($product->Genero) ? $product->Genero : ''));
array_push($data['meta_data'], array('key'=>'Temporada', 'value'=> isset($product->Temporada) ? $product->Temporada : ''));
array_push($data['meta_data'], array('key'=>'Metatitulos', 'value'=> isset($product->Metatitulos) ? $product->Metatitulos: ''));
array_push($data['meta_data'], array('key'=>'Abrev', 'value'=> isset($product->Abrev) ? $product->Abrev : ''));


array_push($data['meta_data'], array('key'=>'Abrev', 'value'=> isset($product->Abrev) ? $product->Abrev : ''));
if(isset($product->no_publicar_web)){
$data['status']= $product->no_publicar_web == true ? 'pending' :'publish';
}



$categories=$woocommerce->get('products/categories');

     foreach ( $categories as $category ) {
		if(isset($product->CATEGORIA_1)){
        	 if($category->slug==createSlug($product->CATEGORIA_1)){
array_push($data['categories'], array('key'=>'category_1', 'value'=>$category->id));
        	 }
		}
		if(isset($product->CATEGORIA_2)){
         	if($category->slug==createSlug($product->CATEGORIA_2)){
array_push($data['categories'], array('key'=>'category_2', 'value'=>$category->id));
			 }
         }
		 if(isset($product->CATEGORIA_3)){
         	if($category->slug==createSlug($product->CATEGORIA_3)){
array_push($data['categories'], array('key'=>'category_3', 'value'=>$category->id));
			 }
         }
		 if(isset($product->CATEGORIA_4)){
         	if($category->slug==createSlug($product->CATEGORIA_4)){
array_push($data['categories'], array('key'=>'category_4', 'value'=>$category->id));
			 }
         }
}

$categories=$woocommerce->get('products/categories');
if($product->Sostenibilidad){
     foreach ( $categories as $category ) {
        //  print_r($category);
         if($category->name=='CONCIOUS'){
            array_push($data['meta_data'], array('key'=>'Sostenibilidad', 'value'=>$category->id));
         }elseif($category->name=='SUPER CONCIOUS'){
             
            array_push($data['meta_data'], array('key'=>'Sostenibilidad', 'value'=>$category->id));
         }else{
            array_push($data['meta_data'], array('key'=>'Sostenibilidad', 'value'=>''));
         }
     }
}
// print_r($data);

echo '<pre><code>' . print_r($woocommerce->post('products', $data)) . '</code></pre>';

  die();
     
 }
 
		} catch (HttpClientException $e) {

			echo '<pre><code>' . print_r( $e->getMessage(), true ) . '</code></pre>';//error message.
		}		


 ?>
