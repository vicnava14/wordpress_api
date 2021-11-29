<?php 	
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

	use Automattic\WooCommerce\HttpClient\HttpClientException;

	$consumer_key = 'ck_0094c218b04bc46ae7372351465fe55be566d33e';
	$consumer_secret = 'cs_88b1865aa900fab93b48b73151a230b15cc0f089';
	$options = array('ssl_verify' => false, 'debug' => true);
	ini_set('max_execution_time', '600');
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
				'Codigo' => '19WA2015',
				'Almacen' => $almacen1,
				'Empresa' => $empresa
			);

			$productos_response =  callApi('GET', $url . 'ListadoArticulos' , $data);
			$productos_response= json_decode($productos_response);
				if($productos_response->Result == "OK"){
					// print_r($productos_response->Data);
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
// 			print_r($productos_response->Data);
// 			$attributes=$woocommerce->get('products/attributes');
// 			foreach ( $attributes as $attribute ) {
				
// 					$terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
				
// 					foreach ( $terms as $term ) {
// 							print_r($term);
// 					}
			
// 			}

//  die();
			$productTrue=False;
			foreach($productos_response->Data as $product){
				$products_list = $woocommerce->get('products', array('sku' => $product->Codigo));
				if($products_list){
					foreach ($products_list as $pro){
						
						$metadata =$pro->meta_data;
						foreach ($metadata as $meta){

							if($meta->key == 'Barras' && $meta->value == $product->Barras){
								echo "son iguales"; 

								$hash =	login($usuario, $clave, $empresa, $url);
								$api_query = array(
									'hash' => $hash,
									'Articulo' => $product->Codigo,
									'Almacen' => $almacen2,
									'Talla' => $product->Talla,
									'Color' => $product->Color,
									'Empresa' => $empresa
								);
					
								$api_response =  callApi('GET', $url . 'ConsultaStock' , $api_query);
								$api_response= json_decode($api_response);

								print_r($api_response->Data->_Total_Existencias);
								// die();

								break;

							}elseif($meta->key == 'Barras' && $meta->value != $product->Barras){
								$data = [
									'regular_price' => (string)$product->Cost_ult1,
									'manage_stock' => true,
									'stock_quantity' => $product->Stock,
									// 'sku' => $product->Codigo,
									'attributes' => array(), 
									// 'meta_data' => array(), 
								];
								// array_push($data['meta_data'], array('key'=>'Barras', 'value'=>$product->Barras));


								if($product->Color){
								$attributes=$woocommerce->get('products/attributes');
									foreach ( $attributes as $attribute ) {
										if($attribute->name=='Color'){
											$terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
											if(sizeof($terms) == 0){
												$data_terms = [
													'name' => $product->Color
												];
												$woocommerce->post('products/attributes/'.$attribute->id.'/terms', $data_terms);

												array_push($data['attributes'],array(
													'id'=> $attribute->id,
													'name'=>$attribute->name,
													'visible'=>'true',
													'variation'=>'true',
													'options'=>$product->Color,
													'option'=>$product->Color));
											}else{
												foreach ( $terms as $term ) {
													if($term->name==$product->Color){
														array_push($data['attributes'],array(
															'id'=> $attribute->id,
															'name'=>$attribute->name,
															'visible'=>'true',
															'variation'=>'true',
															'options'=>$product->Color,
															'option'=>$product->Color));
														
													}else{
	
														$ter = $woocommerce->get('products/attributes/'.$attribute->id.'/terms', ['slug' => createSlug($product->Color)]);
	
														if(!$ter){
															$data_terms = [
																'name' => $product->Color
															];
															$woocommerce->post('products/attributes/'.$attribute->id.'/terms', $data_terms);
															array_push($data['attributes'],array(
																'id'=> $attribute->id,
																'name'=>$attribute->name,
																'visible'=>'true',
																'variation'=>'true',
																'options'=>$product->Color,
																'option'=>$product->Color));
															
															
														}
														// else{
														// 	array_push($data['attributes'],array('id'=> $attribute->id,'options'=>$product->Color));
														// }
					
													}
												}
											}
											
										}
									}
								}
						
								if($product->Talla){
									$attributes=$woocommerce->get('products/attributes');
								foreach ( $attributes as $attribute ) {
									
									
										if($attribute->name=='Talla'){
											$terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
											if(sizeof($terms) == 0){
												$data_terms = [
													'name' => $product->Talla
												];
												
												$woocommerce->post('products/attributes/'.$attribute->id.'/terms', $data_terms);
												array_push($data['attributes'],array(
													'id'=> $attribute->id,
													'name'=>$attribute->name,
													'visible'=>'true',
													'variation'=>'true',
													'options'=>$product->Talla,
													'option'=>$product->Talla));
											}else{
												foreach ( $terms as $term ) {
													if($term->name==$product->Talla){
	
														array_push($data['attributes'],array(
															'id'=> $attribute->id,
															'name'=>$attribute->name,
															'visible'=>'true',
															'variation'=>'true',
															'options'=>$product->Talla,
															'option'=>$product->Talla));
													
													}else{
	
														$ter = $woocommerce->get('products/attributes/'.$attribute->id.'/terms', ['slug' => createSlug($product->Talla)]);
	
														if(!$ter){
															$data_terms = [
																'name' => $product->Talla
															];
															
															array_push($data['attributes'],array(
																'id'=> $attribute->id,
																'name'=>$attribute->name,
																'visible'=>'true',
																'variation'=>'true',
																'options'=>$product->Talla,
																'option'=>$product->Talla));
															$woocommerce->post('products/attributes/'.$attribute->id.'/terms', $data_terms);
														}
														// else{
														// array_push($data['attributes'],array('id'=> $attribute->id,'options'=>$product->Talla));
														// }
														
														
													}
												}
											}
										}
									}
								}
								
								print_r($data);
							print_r($woocommerce->post('products/'.$products_list[0]->id.'/variations', $data));
							// print_r($woocommerce->get('products/attributes/'.$products_list[0]->id));
							// print_r($woocommerce->get('products/'.$products_list[0]->id.'/variations'));
								// break;

							}
							
						}		
								
								
					}
				}else{ 
					
					$dataVariation = [
						'regular_price' => (string)$product->Cost_ult1,
						'attributes' => array(), 
					];

					$data=array();
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

					
					// echo '<pre>' . print_r($attributes) . '</pre>';
					if($product->Color){
						$attributesC=$woocommerce->get('products/attributes');
						foreach ( $attributesC as $attribute ) {
							if($attribute->name=='Color'){
								$terms=$woocommerce->get('products/attributes/'.$attribute->id.'/terms');
								if(sizeof($terms) == 0){
									$data_terms = [
										'name' => $product->Color
									];
									$prod_attrib = $woocommerce->post('products/attributes/'.$attribute->id.'/terms', $data_terms);
									print_r($prod_attrib);
									
									array_push($data['attributes'],array(
										'id'=> $attribute->id,
										'name'=>$attribute->name,
										'visible'=>'true',
										'variation'=>'true',
										'options'=>$product->Color,
										'option'=>$product->Color));
									array_push($dataVariation['attributes'],array(
										'id'=> $attribute->id,
										'name'=>$attribute->name,
										'option'=>$product->Color));

									break;
								}else{
									foreach ( $terms as $term ) {
										if($term->name==$product->Color){
											array_push($data['attributes'],array(
												'id'=> $attribute->id,
												'name'=>$attribute->name,
												'visible'=>'true',
												'variation'=>'true',
												'options'=>$product->Color,
												'option'=>$product->Color));
											array_push($dataVariation['attributes'],array(
												'id'=> $attribute->id,
												'name'=>$attribute->name,
												'option'=>$product->Color));
												break;
											
										}else{
											$data_terms = [
												'name' => $product->Color
											];
											$woocommerce->post('products/attributes/'.$attribute->id.'/terms', $data_terms);
											break;
										}
									}
									break;
								}
								
							}
						}
					}
					$product_total = count($productos_response->Data);
					if($product_total > 0){
						$data['type'] = 'variable';
						$option = array();
						foreach($productos_response->Data as $product_option){
							array_push($option,$product_option->Talla);
						}
						// print_r($option);
						
					}else{
						$data['type'] = 'simple';

					}

					if($product->Talla){
						$attributesT=$woocommerce->get('products/attributes');
					foreach ( $attributesT as $attributeT ) {
							if($attributeT->name=='Talla'){
								$terms=$woocommerce->get('products/attributes/'.$attributeT->id.'/terms');
							
								if(sizeof($terms) == 0){
									$data_terms = [
										'name' => $product->Talla
									];
									$prod_attrib = $woocommerce->post('products/attributes/'.$attributeT->id.'/terms', $data_terms);
									array_push($data['attributes'],array(
										'id'=> $attributeT->id,
										'name'=>$attributeT->name,
										'visible'=>'true',
										'variation'=>'true',
										'options'=>$option,
										'option'=>$product->Talla));
									array_push($dataVariation['attributes'],array(
										'id'=> $attributeT->id,
										'name'=>$attributeT->name,
										'option'=>$product->Talla));
									print_r($data['attributes']);
									break;
								}else{
									foreach ( $terms as $term ) {
										
										if($term->name==$product->Talla){
											array_push($data['attributes'],array(
												'id'=> $attributeT->id,
												'name'=>$attributeT->name,
												'visible'=>'true',
												'variation'=>'true',
												'options'=>$option,
												'option'=>$product->Talla));
											array_push($dataVariation['attributes'],array(
												'id'=> $attributeT->id,
												'name'=>$attributeT->name,
												'option'=>$product->Talla));
												print_r($data);
												break;
										}else{
											$data_terms = [
												'name' => $product->Talla
											];
											$woocommerce->post('products/attributes/'.$attributeT->id.'/terms', $data_terms);
											break;
										}

									}
									break;
								}
							}
						} 
					}
					
					$data['manage_stock']=true;
					$data['stock_quantity']=$product->Stock;
					$data['sku']=$product->Codigo;
					$data['name']=htmlentities($product->Nombre);
					$data['regular_price']=(string)$product->Cost_ult1;
					$data['description']=$product->Nombre2;

					array_push($data['meta_data'], array('key'=>'Composicion', 'value'=> isset($product->Composicion) ? $product->Composition : ''));
					array_push($data['meta_data'], array('key'=>'Genero', 'value'=> isset($product->Genero) ? $product->Genero : ''));
					array_push($data['meta_data'], array('key'=>'Temporada', 'value'=> isset($product->Temporada) ? $product->Temporada : ''));
					array_push($data['meta_data'], array('key'=>'Metatitulos', 'value'=> isset($product->Metatitulos) ? $product->Metatitulos: ''));
					array_push($data['meta_data'], array('key'=>'Abrev', 'value'=> isset($product->Abrev) ? $product->Abrev : ''));



					if(isset($product->no_publicar_web)){
						$data['status']= $product->no_publicar_web == true ? 'pending' :'publish';
					}



					$categories=$woocommerce->get('products/categories', array('per_page' => '100'));

					foreach ( $categories as $category ) {
						if(isset($product->CATEGORIA_1)){
							if($category->slug==createSlug($product->CATEGORIA_1)){ 	array_push($data['categories'], array('key'=>'category_1', 'id'=>$category->id));
							}
						}
						if(isset($product->CATEGORIA_2)){
							if($category->slug==createSlug($product->CATEGORIA_2)){
								array_push($data['categories'], array('key'=>'category_2', 'id'=>$category->id));
							}
						}
						if(isset($product->CATEGORIA_3)){
							if($category->slug==createSlug($product->CATEGORIA_3)){
								array_push($data['categories'], array('key'=>'category_3', 'id'=>$category->id));
							}
						}
						if(isset($product->CATEGORIA_4)){
							if($category->slug==createSlug($product->CATEGORIA_4)){
								array_push($data['categories'], array('key'=>'category_4', 'id'=>$category->id));
							}
						}
					}

					
					$categories=$woocommerce->get('products/categories');
					if(isset($product->Sostenibilidad)){
						foreach ( $categories as $category ) {
							//  print_r($category);
							if($category->name=='CONCIOUS'){
								array_push($data['meta_data'], array('key'=>'Sostenibilidad', 'id'=>$category->id));
							}elseif($category->name=='SUPER CONCIOUS'){
								
								array_push($data['meta_data'], array('key'=>'Sostenibilidad', 'id'=>$category->id));
							}else{
								// array_push($data['meta_data'], array('key'=>'Sostenibilidad', 'id'=>''));
							}
						}
					}
					// print_r($data);

					$create_p=$woocommerce->post('products', $data);
					// print_r($data);
					// // print_r($create_p);
					// $productID = json_decode($create_p);
					// print_r($productID);
					

						 foreach ($create_p as $creatP){
							 
					print_r($creatP);
						 print_r($woocommerce->post('products/'.$creatP.'/variations', $dataVariation));
						 break;
						 }
						//  die();
						
				}
							
			}

 
	} catch (HttpClientException $e) {

		echo '<pre><code>' . print_r( $e->getMessage(), true ) . '</code></pre>';//error message.
	}		


 ?>
