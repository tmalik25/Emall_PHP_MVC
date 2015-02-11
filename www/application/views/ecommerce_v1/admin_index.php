<html>
<head>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="http://localhost:81/js/tablesorter/jquery-latest.js"></script>
	<script type="text/javascript" src="http://localhost:81/js/tablesorter/jquery.tablesorter.js"></script> 

	<script type="text/javascript">

	$(document).ready(function() 
	{ 
		$("#ordertable").tablesorter();
		$('#ordertable thead tr th').click(function(){
			$('#ordertable thead tr th').css('background-color','white');
			$(this).css('background-color','#FFFFCC');	
		});
	} 
	);


	$(document).ready(function(){

		$('.order_status').change (function() {
			var self = this;
			$.ajax({
				type: 'POST',
				url: $(self).attr('action'),
				data: $(self).serialize()
			})
			.done( function(response) {
				console.log("success");
			});
		});


		$(document).on('change', '.status_select', function(){

			var self = this;
			$.ajax({
				type: 'POST',
				url: $(self).attr('action'),
				data: $(self).serialize()
			})
			.done( function(response) {
				$('body').html(response);
			});
			return false;
		});

		$(document).on('change', '.item_nos', function(){

			var self = this;
			$.ajax({
				type: 'POST',
				url: $(self).attr('action'),
				data: $(self).serialize()
			})
			.done( function(response) {
				$('body').html(response);
			});
			return false;
		});	


		$(document).on('click', 'a.page_nos', function(){
			$.ajax({
				url: $(this).attr('href')
			}).done( function(response) {
				$('body').html(response);
			});
			return false;
		});

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

	.searchbox_orders, .div_select_orders, .div_item_nos {

		display: inline-block;
		vertical-align: top;
		width: 30%;
	}

	.order_table_page{

		height: 30px;
		min-width: 50px;
		margin: 10px 0px; 
	}


	.page_nos{

		padding: 0px 15px;
		border: 1px solid silver;
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

		<div style="margin-top: 50px;">
			<div class="searchbox_orders">
				<form action='search_orders' name='search_orders' placeholder= 'search' >
					<input type='text' name = 'search_orders_text' placeholder='Search' style='width: 250px; height: 30px;  '/>
				</form>
			</div>

			<div class="div_item_nos">
				<form action='/ecommerce_v1/main/item_nos' name='item_nos' class="item_nos">
					<label style="display: inline; vertical-align: center;"> Show :  </label>
					<select style='max-width: 100px; height: 30px; margin-right: 20px;' name='select_item_nos'>
						<option <?php if($orders['item_nos'] == '1'){ echo "selected";} ?> name="1">1</option>
						<option <?php if($orders['item_nos'] == '5'){ echo "selected";} ?> name="5">5</option>
						<option <?php if($orders['item_nos'] == '10'){ echo "selected";} ?> name="10">10</option>
						<option <?php if($orders['item_nos'] == '25'){ echo "selected";} ?> name="25">25</option>
					</select>
				</form>
			</div>

			<div class="div_select_orders">
				<form action = 'ecommerce_v1/main/select_orders' class='status_select'>					
					<select name= 'order_status_select' style='max-width: 300px; height: 30px; margin-right: 5px;  float: right;'>
						<option <?php if($orders['select_orders'] == 'All'){ echo "selected";} ?>  name='All'>All</option>;
						<option <?php if($orders['select_orders'] == 'Order In'){ echo "selected";} ?> name='Order In'>Order In</option>; 
						<option <?php if($orders['select_orders'] == 'Processed'){ echo "selected";} ?> name='Processed'>Processed</option>;
						<option <?php if($orders['select_orders'] == 'Shipped'){ echo "selected";} ?>  name='Shipped'>Shipped</option>; 
					</select>
				</form>
			</div>
		</div>


		<table id='ordertable' style="width: 90%; border: 1px solid silver; margin: 30px 0px; " class="table table-striped order_table">
			<thead>
				<tr style = "color: #f45b4f;">
					<th style='background-color: #FFFFCC;'>Order Id</th>
					<th>Name</th>
					<th>Date</th>
					<th>Billling Address</th>
					<th>Total</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$count = min( (count($orders)-4), $orders['item_nos']);

				for($i = 0; $i < $count; $i++){	

					$name = $orders[$i]['first_name']." ".$orders[$i]['last_name'] ;

					echo "<tr>";
					echo "<td><a href = '/ecommerce_v1/main/order_details/{$orders[$i]['id']}'/>".$orders[$i]['id']."</td>";
					echo "<td>".$name."</td>";
					echo "<td>12-07-2014</td>" ;
					echo "<td>".$orders[$i]['address1']."</td>";
					echo "<td>360.0</td>";

					echo "<td><form class='order_status' action='./ecommerce_v1/main/update_order/{$orders[$i]['id']}' method='post'><select name='option' style='max-width: 300px; height: 30px; margin-right: 17px; text-align: left;'>
					<option" ?> <?php if($orders[$i]['order_status'] == 'Order In'){ echo "selected";} ?> <?php echo " name='Order In'>Order In</option>
					<option" ?> <?php if($orders[$i]['order_status'] == 'Processed'){ echo "selected";} ?> <?php echo " name='Processed'>Processed</option>
					<option" ?> <?php if($orders[$i]['order_status'] == 'Shipped'){ echo "selected";} ?> <?php echo " name='Shipped'>Shipped</option>
					<option" ?> <?php if($orders[$i]['order_status'] == 'Cancelled'){ echo "selected";} ?> <?php echo "  name='Cancelled'>Cancelled</option>
					</select></form></td>" ;

					echo "</tr>";
				}

				?>
			</tbody>
		</table>

		<div class='order_table_page'> 

			<?php  

			$total_pages = ($orders['total_nos'] / $orders['item_nos']); 

			if($total_pages < 1){$total_pages = 1;}

			for($j = 1; $j < ($total_pages+1); $j++){
				// 	echo "<form class = 'page_nos' action = 'ecommerce_v1/main/page_nos/{$j}' method='post' style= 'display:inline-block; vertical-align: top;'><label style='padding: 0px 15px; font-size: 13px; border: 1px solid silver;'><a href='javascript:form_submit()'>".$j."</a></label></form>";
				echo "<a class='page_nos' href='/ecommerce_v1/main/page_nos/{$j}'>".$j."</a>";

			}

			?>

			

		</div>


	</body>
	</html>