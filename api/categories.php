<?php 
	require __DIR__ . '/vendor/autoload.php';
	require_once("../wp-load.php");

	use Automattic\WooCommerce\Client;
	use Automattic\WooCommerce\HttpClient\HttpClientException;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	ini_set('max_execution_time', '600');
	$consumer_key = 'ck_0094c218b04bc46ae7372351465fe55be566d33e';
	$consumer_secret = 'cs_88b1865aa900fab93b48b73151a230b15cc0f089';
	$options = array('ssl_verify' => false, 'debug' => true);
	$store = 'http://localhost/wordpress/';

	$api = new Client($store, $consumer_key, $consumer_secret, $options);

	$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load("CATEGORIAS.xlsx");

	$worksheet = $spreadsheet->getActiveSheet();

	function createSlug($str, $delimiter = '-'){

	    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
	    return $slug;

	} 

	foreach ($worksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		$i = 1;
		foreach ($cellIterator as $cell) {
	     
            if ($cell->getValue()) {
              	
              	$categories = explode(' / ', $cell->getValue());
              	
              	foreach ($categories as $key => $value) {
              		$parent_index = ($key == 0) ? -1 : $key-1;
              		$data = [];
              		$categoria =  [ 'total_parent' => $categories[0] ,'parent' => $categories[$parent_index],  'id' => $id, 'nombre' => $value ];
              		// echo 'Indice:'. $key . ' Valor: ' .$value . '<br/>';
              		// print_r($categoria);	
         
              		if($key != 0){
              		
              			$c = count($categories);

              			for ($i=0; $i < $key; $i++) { 
              				$cat_slug .= $categories[$i]. ' ';
              			}
              			$parent_slug = createSlug($cat_slug);

              			$slug = createSlug($cat_slug.' '.$value);
              		}else{
              			$slug = createSlug($value);
              		}
              		$cat_slug = '';
              		$exist_cat = $api->get('products/categories', ['slug' => $slug]);
              		echo 'Exist Cat:' . print_r($exist_cat) . '<br>';
              		if(!$exist_cat){
              			 if($key != 0){
              			 	$parent = $api->get('products/categories', ['slug' => $parent_slug]);
              			 	echo 'Parent:' . print_r($exist_cat) . '<br>';

              			 	if($parent[0]){
              			 		$data['parent'] = $parent[0]->id;
              			 		echo 'Data:' . print_r($data) . '<br>';
              			 	}else{
              			 		$parent_data['name'] =$categories[$parent_index];
              			 		$parent_data['slug'] = $parent_slug;
              			 		$created_parent = $api->post('products/categories', $parent_data);
              			 		$data['parent'] = $created_parent->id;
              			 		echo 'Parent_Data:' . print_r($created_parent) . '<br>';
              			 		echo 'Data2:' . print_r($data) . '<br>';
              			 	}
              				
              			}
              			$data['name'] = $value;
              			$data['slug'] = $slug;
              			$created_cat = $api->post('products/categories', $data);
              			echo 'Created_cat:' . print_r($created_cat) . '<br>';
              			if(!$created_cat){
              				die('error al crear categoría');
              			}
              		}
              		$id++;
              	}
            } 
	    }
	}
?>