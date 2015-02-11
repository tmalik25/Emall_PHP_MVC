<?php

class ecommerce extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

	public function update_order($order) {

		$query = "UPDATE orders SET orders.order_status = ? WHERE orders.id = ?";

		$values = array($order['status'],$order['id']);

		$this->db->query($query,$values);
	}


	public function total_orders_w_filter($order){

		$values_a = array($order['select_orders']);
	
		if($values_a[0] == 'All'){
			$query_a = "SELECT COUNT(orders.id) FROM orders";
		} else {
			$query_a = "SELECT COUNT(orders.id) FROM orders WHERE orders.order_status = ?";
		}

		$total_orders_a =  $this->db->query($query_a,$values_a)->result_array();
		$total_orders = array_values($total_orders_a[0]);
		return $total_orders;
	}



	public function select_orders($order){

		$total_orders = $order['total_nos'];

		$min_id_range =  (($order['page_nos']-1))*$order['item_nos']; 
		$max_id_range = $order['item_nos'] + $min_id_range;

		$remaining_orders = $total_orders - $order['item_nos']*($order['page_nos']-1); 

		if(($max_id_range-$min_id_range) >  $remaining_orders){
			$max_id_range = $remaining_orders + $min_id_range;
		}

		$values = array($order['select_orders']);

		if($values[0] == 'All'){

			$query = "SELECT orders.id, orders.created_at, orders.order_status, customers.first_name,customers.last_name, ship_address.address1, ship_address.address2, locations.city_name,locations.state_name  FROM orders JOIN customers ON customers.id = orders.customers_id JOIN ship_address ON ship_address.id = customers.ship_address_id JOIN locations ON locations.id = ship_address.locations_id ORDER BY orders.id" ;

			return array_slice($this->db->query($query)->result_array(),($min_id_range),$max_id_range);

		} else {

			$query = "SELECT orders.id, orders.created_at, orders.order_status, customers.first_name,customers.last_name, ship_address.address1, ship_address.address2, locations.city_name,locations.state_name  FROM orders JOIN customers ON customers.id = orders.customers_id JOIN ship_address ON ship_address.id = customers.ship_address_id JOIN locations ON locations.id = ship_address.locations_id  WHERE orders.order_status = ? ORDER BY orders.id" ;

			return array_slice($this->db->query($query,$values)->result_array(),($min_id_range),$max_id_range);

		}

	}


	public function order_details($order){

		$query = "SELECT orders.id, orders.created_at, orders.order_status, customers.first_name,customers.last_name, ship_address.address1, ship_address.address2, locations.city_name,locations.state_name FROM orders JOIN customers ON customers.id = orders.customers_id JOIN ship_address ON ship_address.id = customers.ship_address_id JOIN locations ON locations.id = ship_address.locations_id  WHERE orders.id = ? ORDER BY orders.id" ;

		$values = array($order['id']);

		return	$this->db->query($query,$values)->result_array();
	}

	public function products_in_order($order){

		$query = "SELECT products.id,products.name,products.price, orders_has_products.number_products FROM orders_has_products JOIN orders ON orders_has_products.orders_id = orders.id JOIN products ON orders_has_products.products_id = products.id WHERE orders_has_products.orders_id = ?" ;

		$values = array($order['id']);

		return $this->db->query($query,$values)->result_array();

	}


	public function get_all_products($products){

		$query = "SELECT SUM(orders_has_products.number_products), products.inventory, products.main_image, products.id, orders_has_products.products_id, products.name,products.price FROM products LEFT JOIN orders_has_products ON orders_has_products.products_id = products.id GROUP BY products.id" ;

		
		$item_nos = $products['product_item_nos'];
		$page_nos = $products['product_page_nos'];

		$products = array();

		$total_products = count($this->db->query($query)->result_array());

		$min_id_range =  (($page_nos-1))*$item_nos;
		$max_id_range = $min_id_range + $item_nos;

		$remaining_products = $total_products - $item_nos*($page_nos - 1); 

		if(($max_id_range-$min_id_range) >  $remaining_products){
			$max_id_range = $remaining_products + $min_id_range;
		}

		$big_product_array = $this->db->query($query)->result_array();

		$count = 0;
		for($j=$min_id_range; $j < $max_id_range; $j++){

			$products[$count] = $big_product_array[$j];
			$count = $count + 1;
		}

		$products['total_nos'] = $total_products;

		$products['product_item_nos'] = $item_nos;
		$products['product_page_nos'] = $page_nos;

//		var_dump($products);

		return $products;
	}






}

	// public function show_orders() {


	// 	$query = "SELECT orders.id, orders.created_at, orders.order_status, customers.first_name,customers.last_name, ship_address.address1, ship_address.address2, locations.city_name,locations.state_name  FROM orders JOIN customers ON customers.id = orders.customers_id JOIN ship_address ON ship_address.id = customers.ship_address_id JOIN locations ON locations.id = ship_address.locations_id ORDER BY orders.id";

	// 	return $this->db->query($query)->result_array();

	// }


?>





