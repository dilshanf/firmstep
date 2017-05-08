<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Firmstep</title>
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
		<style>
			#container
			{
			padding:20px;
			}
			
			#radioBtn .notActive{
			color: white;
			background-color: #489be3;
			}
			
			form .error {
			color: #ff0000;
			}
		</style>
	</head>
	<body>
		
		<div id="container">
			<h1 class="text-center">Queue App</h1>
			<br />
			<div class="row">
				<div class="col-xs-4">
					<div class="panel panel-default">
						
						
						<div class="panel-heading"><strong>New Customer</strong></div>
						<div class="panel-body">
							
							<form id="customer_form">
								<label>
									Services
								</label>
								<div>
									<input type="radio" name="service_type" id="radio1" value="Housing" checked="">
									<label for="radio1">
										Housing
									</label>
								</div>
								<div>
									<input type="radio" name="service_type" id="radio2" value="Benefits">
									<label for="radio2">
										Benefits
									</label>
								</div>
								<div>
									<input type="radio" name="service_type" id="radio3" value="Council Tax">
									<label for="radio2">
										Council Tax
									</label>
								</div>
								<div>
									<input type="radio" name="service_type" id="radio4" value="Fly-tipping">
									<label for="radio2">
										Fly-tipping
									</label>
								</div>
								<div>
									<input type="radio" name="service_type" id="radio5" value="Missed Bin">
									<label for="radio2">
										Missed Bin
									</label>
								</div>
								<br />
								<div class="form-group">
									
									<div class="col-sm-12 col-md-12">
										<div class="input-group">
											<div id="radioBtn" class="btn-group">
												<a id="cit_button" name="cit_button" class="btn btn-primary btn-sm active" data-toggle="button" data-title="Citizen">Citizen</a>
												<a id="org_button" class="btn btn-primary btn-sm notActive" data-toggle="button" data-title="Organisation">Organisation</a>
												<a id="ano_button" class="btn btn-primary btn-sm notActive" data-toggle="button" data-title="Anonymous">Anonymous</a>
											</div>
											
											<input type="hidden" name="customer_type" id="customer_type" value="Citizen" />
											
										</div>
									</div>
								</div>
								
								<br />
								<br />
								<div id="ind_div">
									<div class="form-group">
										<label>
											Title
										</label>
										<select name="title" class="form-control">
											<option value="Mr">Mr</option>
										</select>
									</div>
									
									<div class="form-group">
										<label>
											First Name
										</label>
										<input id="fname" name="fname" type="text" class="form-control" />
									</div>
									
									<div class="form-group">
										<label>
											Last Name
										</label>
										<input id="lname" name="lname" type="text" class="form-control" />
									</div>
								</div>
								
								<div id="org_div" style="display:none;">
									<div class="form-group">
										<label>
											Organisation Name
										</label>
										<input id="org_name" name="org_name" type="text" class="form-control" />
									</div>
								</div>
								
								<button id="submit_button" class="btn btn-primary" type="button">Submit</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-xs-8">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Queue</strong></div>
						<div class="panel-body">
							
							<table id="queuetable" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Type</th>
										<th>Name</th>
										<th>Service</th>
										<th>Queued At</th>
									</tr>
								</thead>
								
								<tbody id="customer_rows">
									
									
									
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		<script
		src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url('assets/dist/jquery.validate.js') ?>"></script>
		
		<script>
			
			$(function() {
				$("#customer_form").validate({
					// Specify validation rules
					rules: {
						'fname': {
							required: function(element) {
								return $( "#cit_button" ).hasClass( "active" );
							}
						},
						'lname': {
							required: function(element) {
								return $( "#cit_button" ).hasClass( "active" );
							}
						},
						'title': {
							required: function(element) {
								return $( "#cit_button" ).hasClass( "active" );
							}
						},
						'org_name': {
							required: function(element) {
								return $( "#org_button" ).hasClass( "active" );
							}
						}
					},
					// Specify validation error messages
					messages: {
						title: "Required",
						fname: "Required",
						lname: "Required"
					}
				});
			});

			
			$(document).ready(function() {
				
				$('#radioBtn a').on('click', function(){
					var sel = $(this).data('title');
					var tog = $(this).data('toggle');
					$('#'+tog).prop('value', sel);
					
					$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
					$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
				})
				
				var table = $('#queuetable').DataTable();
				var counter = 1;
				
				$("#cit_button").click(function () {
					$('#org_div').hide();
					$('#ind_div').show();
					$('#customer_type').val('Citizen');
				});
				
				$("#org_button").click(function () {
					$('#org_div').show();
					$('#ind_div').hide();
					$('#customer_type').val('Organisation');
				});
				
				$("#ano_button").click(function () {
					$('#org_div').hide();
					$('#ind_div').hide();
					$('#customer_type').val('Anonymous');
				});
				
				function reload_table()
				{
					
					$.ajax({
						type: "GET",
						url: "<?php echo site_url('home/get_ajax/') ?>",
						dataType: "JSON",
						success: function (res) {
							
							if (res)
							{
								table
								.clear()
								.draw();
								
								var counter = 1;
								
								for(x = 0; x < res.length; x++){
									
									var service_type = res[x].service_type;
									var customer_type = res[x].customer_type;
									var time = res[x].time;
									if (customer_type == 'Citizen')
									{
										var name = res[x].fname + res[x].lname;
									}
									else
									{
										var name = res[x].org_name;
									}
									
									
									table.row.add( [
									counter,
									customer_type,
									name,
									service_type,
									time
									] ).draw( false );
									counter++;
								}
							}
						}
					});
					
					
				}
				
				$("#submit_button").click(function () {
					status = $("#customer_form").valid();
					if (status == "true")
					{
						$.ajax({
							type: "POST",
							url: "<?php echo site_url('home/submit_ajax/') ?>",
							data: $("#customer_form").serialize(),
						dataType: "JSON",
						success: function (res) {
							reload_table();
						}
						});
					}
				});
				
				reload_table();
				
			} );
			
			
			
		</script>
		
	</body>
</html>					