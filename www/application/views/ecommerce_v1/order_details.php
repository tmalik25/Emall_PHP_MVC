<html>
<head>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	
	<script type="text/javascript">
	$(document).ready(function(){

		$order_status = $('div.order_status').text();

		$array_status = $order_status.split(" ");

//		console.log($array_status);

		if($array_status[2] == 'Processed'){
			$('div.order_status').css('background-color', '#FFFFCC');
			$('div.order_status').css('border', '2px solid #f45b4f' );
			$('div.order_status').css('color', 'black' );
		} else if($array_status[2] == 'Shipped'){
			$('div.order_status').css('background-color', '#33CC00');
			$('div.order_status').css('border', '2px solid #99FF66' );
			$('div.order_status').css('color', 'black' );
		} else if($array_status[2] == 'Order'){
			$('div.order_status').css('background-color', '#FF9999');
			$('div.order_status').css('border', '2px solid red' );
			$('div.order_status').css('color', 'black' );
		} else if($array_status[2] == 'Cancelled'){
			$('div.order_status').css('background-color', '#990033');
			$('div.order_status').css('border', '2px solid red' );
			$('div.order_status').css('color', 'white' );
		}

	});
	</script>


	<title> Welcome Admin</title>

	<style type="text/css">
	.container{
		max-width: 100%;
		max-height: 100%;
		margin: 0px auto;
	}

	.csstable{
		margin: 0px auto;
		border: 1px solid silver;
		width: 60%;
	}

	.table{

		margin: 100px auto;
	}


	.order_content, .prod_content{
		display: inline-block;
		vertical-align: top;
		height: 1000 px;

		margin: 20px auto;
	}


	</style>

</head>


<body>
	<nav role="navigation" class="navbar navbar-inverse">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<!-- Collection of nav links, forms, and other content for toggling -->
		<div id="navbarCollapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="/" style="color:white; font-size: 18px; margin-right: 57px; ">Bootcamp</a></li>
				<li class="active"><a href="/">Orders</a></li>
				<li><a href="/ecommerce_v1/main/get_all_products">Products</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/ecommerce_v1/main/logout">Logout</a></li>
			</ul>
		</div>
	</nav>


	<div class="container">

		<div class='order_status' style = "width: 93%; height: 40px; font-weight: bold; font-size: 15px; border: 1px solid silver; margin-top: 40px; padding: 5px; "> Status: <?php echo $order_det['order'][0]['order_status']; ?> </div>

		<div class = 'content'>

			<div class='order_content' style="width: 35%; padding: 20px; font-family: 'Helvetica'; border: 1px solid silver;">

				<p><b>Order ID: </b><?php echo "  ".$order_det['order'][0]['id']; ?> </p>
				<p><b>Customer Name: </b><?php echo "  ".$order_det['order'][0]['first_name']." ".$order_det['order'][0]['last_name']; ?> </p>
				<br><br>
				<p><b>Shipping Info: </b></p>
				<p> <?php echo $order_det['order'][0]['address1']." ".$order_det['order'][0]['address2']; ?></p>
				<p> <?php echo $order_det['order'][0]['city_name']." ".$order_det['order'][0]['state_name']; ?></p>



			</div>

			<div class="prod_content" style="width: 60%">

				<table style="width: 90%; border: 1px solid silver; margin-top: 0px; margin-bottom: 30px; " class="table table-striped">
					<thead>
						<tr style = "color: #f45b4f;">
							<th>Product Id</th>
							<th>Item</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$count = count($order_det['product']);

						for($i = 0; $i < $count; $i++){	

							echo "<tr>";
							echo "<td>".$order_det['product'][$i]['id']."</td>";
							echo "<td>".$order_det['product'][$i]['name']."</td>";
							echo "<td>".$order_det['product'][$i]['price']."</td>" ;
							echo "<td>".$order_det['product'][$i]['number_products']."</td>";
							echo "<td>".($order_det['product'][$i]['number_products'])*($order_det['product'][$i]['price'])."</td>";
							echo "</tr>";
						}

						?>
					</tbody>
				</table>

				<div style = "width: 90%; height: 40px; font-weight: bold; font-size: 15px; border: 1px solid silver; margin: 15px auto; padding: 5px; background-color: #f3f3f3;"> Total order: 
					<?php $count = count($order_det['product']);

					$total = 0;

					for($i = 0; $i < $count; $i++){	 

						$total = $total + ($order_det['product'][$i]['number_products'])*($order_det['product'][$i]['price']);
					}

					echo $total." USD";

					?> </div>

				</div>


			</div>




		</body>
		</html>