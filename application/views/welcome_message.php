<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>CRUD CI WITH AJAX</title>
  </head>
  <body>
    <div class="container">
		<div class="row">
			<div class="col-md-12 mt-5">
				<h1 class="text-center">CodeIgniter Ajax CRUD</h1>
				<hr style="background-color : black; color:black; height: 1px;">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 mt-2">
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
					Add Record
					</button>

					<!-- Insert Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="post" id="form">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" id="name" class="form-control">
								</div>
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" id="email" class="form-control">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="add">Add</button>
						</div>
						</div>
					</div>
					</div>
			</div>

			<!-- Edit Modal -->
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="post" id="edit_form">
							<input type="hidden" id="edit_modal_id" value="">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" id="edit_name" class="form-control">
								</div>
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" id="edit_email" class="form-control">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="update">Update</button>
						</div>
						</div>
					</div>
					</div>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12 mt-3">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		$(document).on("click","#add",function(e) {
			e.preventDefault();
			
			var name = $("#name").val();
			var email = $("#email").val();

			if (name== "" || email=="") {
				alert('all field required');
			}else{

				$.ajax({
				url: "<?= base_url();?>insert",
				type: "post",
				dataType: "json",
				data : {
					name : name,
					email : email
				},
				success: function(data){
					fetch();
					$("#form")[0].reset();
					$('#exampleModal').modal('hide')
					

					if (data.responce == "success") {
						toastr["success"](data.message)

						toastr.options = {
						"closeButton": true,
						"debug": false,
						"newestOnTop": false,
						"progressBar": true,
						"positionClass": "toast-top-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": "300",
						"hideDuration": "1000",
						"timeOut": "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
						}
					}else{
						toastr["error"](data.message)

						toastr.options = {
						"closeButton": true,
						"debug": false,
						"newestOnTop": false,
						"progressBar": true,
						"positionClass": "toast-top-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": "300",
						"hideDuration": "1000",
						"timeOut": "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
				}
			}

					
			});

			}

			
		});

		


		function fetch() {
			$.ajax({
				url : "<?=base_url();?>fetch",
				type : "post",
				dataType : "json",
				success: function(data){
					
					var tbody = "";
					var i = "1";

					for(var key in data){
						tbody +="<tr>"
						tbody +="<td>"+i+++"</td>";
						tbody +="<td>"+data[key]['name']+"</td>";
						tbody +="<td>"+data[key]['email']+"</td>";
						tbody +=`<td>
									<a href="#" id="del" class="btn btn-sm btn-outline-danger" value="${data[key]['id']}"><i class="fas fa-trash-alt"></i></a>
									<a href="#" id="edit" class="btn btn-sm btn-outline-success" value="${data[key]['id']}"><i class="fas fa-edit"></i></a>
								</td>`;
						tbody +="</tr>"
					}
					$("#tbody").html(tbody);
				}
			});
		}
		fetch();


		$(document).on("click","#del", function(e){
			e.preventDefault();
			
			var del_id = $(this).attr("value");

			if (del_id =="") {
				alert("Delete id required");
			}else{

				swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-success',
					cancelButton: 'btn btn-danger mr-2'
				},
				buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
				}).then((result) => {
				if (result.isConfirmed) {

					$.ajax({
					url:"<?=base_url();?>delete",
					type:"post",
					dataType:"json",
					data: {
						del_id : del_id
					},

					success: function(data){
						fetch()
						
						if (data.responce == "success") {
							
							swalWithBootstrapButtons.fire(
							'Deleted!',
							'Your file has been deleted.',
							'success'
							)
						}
					}
				})

				} else if (
					/* Read more about handling dismissals below */
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire(
					'Cancelled',
					'Your imaginary file is safe :)',
					'error'
					)
				}
				})
			}
		});

		$(document).on("click","#edit", function(e){
			e.preventDefault();

			var edit_id = $(this).attr("value");

			if (edit_id == "") {
				alert("Edit id required")
			}else{

				$.ajax({
					url:"<?=base_url();?>edit",
					type:"post",
					dataType: "json",
					data :{
						edit_id : edit_id
					},
					success : function(data){
						if (data.responce == "success") {
							$('#editModal').modal('show')
							$('#edit_modal_id').val(data.post.id)
							$('#edit_name').val(data.post.name)
							$('#edit_email').val(data.post.email)
						}else {

						}
					}
				})
			}
			
		})

		$(document).on("click", "#update", function(e){
			e.preventDefault();
			$('#editModal').modal('hide')

			var edit_id = $('#edit_modal_id').val();
			var edit_name = $('#edit_name').val();
			var edit_email = $('#edit_email').val();

			if (edit_id == "" || edit_name== "" || edit_email=="") {
				alert('all field required');
			}else {
				$.ajax({
					url : "<?=base_url()?>update",
					type : "post",
					dataType : "json",
					data : {
						edit_id : edit_id,
						edit_name : edit_name,
						edit_email : edit_email
					},
					success : function(data){
						fetch();
						if (data.responce=="success") {
							
							toastr["success"](data.message)
							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
	
							}	
						}else{
							toastr["error"](data.message)
							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
	
							}	
						}

				}
				})
			}
		})
	</script>
  </body>
</html>