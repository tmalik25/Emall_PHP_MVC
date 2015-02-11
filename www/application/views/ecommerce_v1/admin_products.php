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
        	$("#producttable").tablesorter();
        	$('#producttable thead tr th').click(function(){
        		$('#producttable thead tr th').css('background-color','white');
        		$(this).css('background-color','#FFFFCC');	
        	});
    } 
	); 


	$(document).ready(function(){

		$(document).on('change', '.product_item_nos', function(){

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


		$(document).on('click', 'a.product_page_nos', function(){
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

	.searchbox_products, .div_item_nos {

		display: inline-block;
		vertical-align: top;
		
	}

	.product_table_page{

		height: 30px;
		min-width: 50px;
		margin: 10px 0px; 
	}


	.product_page_nos{

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
				<li ><a href="/">Orders</a></li>
				<li class="active"><a href="/ecommerce_v1/main/get_all_products">Products</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/ecommerce_v1/main/logout">Logout</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">

		<div style="margin-top: 50px;">

			<div class="searchbox_products">
				<form action='search_products' name='search_products' placeholder= 'search' >
					<input type='text' name = 'search_products_text' placeholder='Search' style='width: 250px; height: 30px;  '/>
				</form>
			</div>

			<div class="div_item_nos" style = "float: right;">
				<form action='/ecommerce_v1/main/products_item_nos' name='product_item_nos' class="product_item_nos">
					<label style="display: inline; vertical-align: center;"> Show :  </label>
					<select style='width: 50px; height: 30px; margin-right: 40px;' name='product_select_item_nos'>
						<option <?php if($products['product_item_nos'] == '1'){ echo "selected";} ?> name="1">1</option>
						<option <?php if($products['product_item_nos'] == '2'){ echo "selected";} ?> name="2">2</option>
						<option <?php if($products['product_item_nos'] == '5'){ echo "selected";} ?> name="5">5</option>
						<option <?php if($products['product_item_nos'] == '10'){ echo "selected";} ?> name="10">10</option>
					</select>
				</form>
			</div>

		</div>


		<table id='producttable' style="width: 90%; border: 1px solid silver; margin: 30px 0px; "class="table table-striped product_table">
			<thead>
				<tr style = "color: #f45b4f;">
					<th>Pic</th>
					<th style='background-color: #FFFFCC;'>Product Id</th>
					<th>Name</th>
					<th>Price</th>
					<th>Inventory</th>
					<th>Total Sold</th>
					<th>Action</th>
					
				</tr>
			</thead>
			<tbody>
				<?php

				$count = count($products)-3;

				for($i = 0; $i < $count; $i++){	

					if(!$products[$i]['SUM(orders_has_products.number_products)']){
						$products[$i]['SUM(orders_has_products.number_products)'] = 0;
					}

					echo "<tr>";
					echo "<td><img src='http://localhost:81/".$products[$i]['main_image']."' style='max-height: 100px; widht: auto; max-width: 100px;'</td>";
					echo "<td>".$products[$i]['id']."</td>";
					echo "<td>".$products[$i]['name']."</td>";
					echo "<td>".$products[$i]['price']."</td>" ;
					echo "<td>".$products[$i]['inventory']."</td>";
					echo "<td>".$products[$i]['SUM(orders_has_products.number_products)']."</td>";
					echo "<td><a href = '/ecommerce_v1/main/edit_product/{$products[$i]['products_id']}' style='padding: 0px 10px'> edit</a><a href = '/ecommerce_v1/main/product_delete/{$products[$i]['products_id']}'>  delete</a></td>";

				}

				?>
			</tbody>
		</table>

		<div class='product_table_page'> 

 				<?php  

				$total_pages = ($products['total_nos'] / $products['product_item_nos']); 

				if($total_pages < 1){$total_pages = 1;}

				for($j = 1; $j < ($total_pages+1); $j++){
					echo "<a class='product_page_nos' href='/ecommerce_v1/main/products_page_nos/{$j}'>".$j."</a>";

				}

				?> 



			</div>


		</body>
		</html>