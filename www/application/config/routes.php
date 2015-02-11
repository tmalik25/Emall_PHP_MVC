<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "ecommerce_v1/main";

$route['main'] = "ecommerce_v1/main";


$route['main/orders_index'] = "ecommerce_v1/main/orders_index";
$route['main/products_index'] = "ecommerce_v1/main/products_index";
$route['order_details'] = "main/order_details";



$route['admin_index'] = "ecommerce_v1/admin_index";
$route['products_index'] = "ecommerce_v1/products_index";
$route['ecommerce'] = "ecommerce_v1/ecommerce";


$route['404_override'] = '';

//end of routes.php