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
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href='/ecommerce_v1/main/login'>Login</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">

		<form style="margin: 100px auto;">
			<input type='text' placeholder='username' name='uname' style='width: 300px; height: 40px; margin: auto;' /><br><br>
			<input type='password' placeholder='password' name='password' style='width: 300px; height: 40px; margin: auto;'/><br><br>
			<input type='submit' name='submit' value='Login' style='width: 100px; height: 40px; margin:auto;'/><br><br>
		</form>


	</div>

	</body>
	</html>