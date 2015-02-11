<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);

		$this->load->model('/ecommerce_v1/ecommerce');
	}


	public function login()
	{

		$this->load->view('/ecommerce_v1/login');

	}

	public function logout()
	{

		$this->session->sess_destroy();
		$this->load->view('/ecommerce_v1/login');

	}


	public function index()
	{

		$order = array();

		$order['select_orders'] = 'All';
		$order['item_nos'] = 5;
		$order['page_nos'] = 1;

		$this->session->set_userdata($order); 

		$this->get_show_orders();

	}


	public function update_order($order_id){

		$order_status = $this->input->post('option');
		$order['id'] = $order_id;
		$order['status'] = $order_status;

		$this->ecommerce->update_order($order);
	}


	public function select_orders(){

		$order['select_orders'] = $this->input->post('order_status_select');
		$this->session->set_userdata('select_orders',$order['select_orders']);  

		$order['item_nos'] = $this->session->userdata('item_nos');
		$order['page_nos'] = $this->session->userdata('page_nos');

		$this->get_show_orders();
	}



	public function item_nos(){

		$order['item_nos'] = $this->input->post('select_item_nos');

		$this->session->set_userdata('item_nos',$order['item_nos']);  

		$order['select_orders'] = $this->session->userdata('select_orders');
		$order['page_nos'] = 1;

		$this->get_show_orders();
	}

	public function page_nos($page_name){

		$order['page_nos'] = $page_name;

		$this->session->set_userdata('page_nos',$order['page_nos']);  

		$order['select_orders'] = $this->session->userdata('select_orders');
		$order['item_nos'] = $this->session->userdata('item_nos');

		$this->get_show_orders();

	}


	public function get_show_orders(){

		$order['select_orders'] = $this->session->userdata('select_orders');
		$order['item_nos'] = $this->session->userdata('item_nos');
		$order['page_nos'] = $this->session->userdata('page_nos');
		//$order['total_nos'] = $this->session->userdata('total_nos');

		$total_orders =	array_values($this->ecommerce->total_orders_w_filter($order));
		$order['total_nos'] = $total_orders[0];

		$this->session->set_userdata($order); 

		$orders = $this->ecommerce->select_orders($order);

		$orders['select_orders'] = $this->session->userdata('select_orders');
		$orders['item_nos'] = $this->session->userdata('item_nos');
		$orders['page_nos'] = $this->session->userdata('page_nos');
		$orders['total_nos'] = $this->session->userdata('total_nos');

		$this->load->view('/ecommerce_v1/admin_index', array('orders' => $orders) );

	}

	public function order_details($order_id){

		$order['id'] = $order_id;

		$order_details = $this->ecommerce->order_details($order);

		$product_details = $this->ecommerce->products_in_order($order);

		$order_det['order'] = $order_details;
		$order_det['product'] = $product_details;

		$this->load->view('/ecommerce_v1/order_details', array('order_det' => $order_det) );

	}


// PRODUCT CONTROLLERS......................................................................

	public function get_all_products(){

		$products['product_item_nos'] = 5;
		$products['product_page_nos'] = 1;
		$this->session->set_userdata($products);

		$products = $this->ecommerce->get_all_products($products);

		//var_dump($products);

		$this->load->view('/ecommerce_v1/admin_products', array('products' => $products) );
	}

	public function products_item_nos(){

		$products['product_item_nos'] = $this->input->post('product_select_item_nos');
		$this->session->set_userdata('product_item_nos',$products['product_item_nos']);  

		$products['product_page_nos'] = 1;

		$products = $this->ecommerce->get_all_products($products);

		$this->load->view('/ecommerce_v1/admin_products', array('products' => $products) );

	}

	public function products_page_nos($page_nos){

		$products['product_page_nos'] =$page_nos;
		$this->session->set_userdata('product_page_nos',$products['product_page_nos']);  

		$products['product_item_nos'] = $this->session->userdata('product_item_nos');

		$products = $this->ecommerce->get_all_products($products);

	//	var_dump($products);

		$this->load->view('/ecommerce_v1/admin_products', array('products' => $products) );

	}





}


//end of main controller