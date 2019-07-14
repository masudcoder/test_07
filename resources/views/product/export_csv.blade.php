@extends('layouts.app')

@section('select2css')
 <link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
 <link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />	
 <link href="{{asset('/')}}/public/css/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />  
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<span aria-hidden="true" class="icon-list"></span>
					<span class="caption-subject bold uppercase">Export Products to CSV</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<form action="{{ URL::to('csv-export') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="part-1">
								<select class="form-control" name="template_row_id"> 
									<option value="0">Export Products</option>
									@foreach($data['export_templates'] as $template)
										<option value="{{ $template->template_row_id}}">{{ $template->template_name}}</option> 
									@endforeach
								</select> 
							</div>
							
							<div class="part-2">
								 <button class="btn sbold green">Export</button>
							</div>
							
							
							
						</div>							
						
						<div class="col-md-6">
							<!--div class="btn-group pull-right">
								<button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
									<i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right">
									 <li>
										<a href="javascript:;">
											 Import </a>
									</li>
									<li>
										<a href="javascript:;">
											<i class="fa fa-file-excel-o"></i> Export to Excel </a>
									</li>
								</ul>
							</div-->
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
						<div style="margin:10px 0  0 0">
							@if(Session::has('success-message'))
							<div class="alert alert-success">
							<strong>Success!</strong> {{ Session::get('success-message') }}
							</div>
							@endif

							@if(Session::has('error-message'))
							<div class="alert alert-danger">
							<strong>Error! </strong>{{ Session::get('error-message') }}
							</div>								
							@endif
						</div>  
						</div>
					</div>
				</div>		
				
				<table class="table table-striped table-bordered table-hover table-checkable order-column" id="product_list">
					<thead>
						<tr>
							<th style="width:5%;"><input type="checkbox" class="select_all_checkbox" id="select_all"  /> </th> 
							<th style="width:30%;text-align:left;padding-left:10px">Product Name</th>              
							<th style="width:10%">Price</th>   
							<th> SKU</th>     
							<th style="width:20%">Product Image</th>       
							<th style="width:10%"> Production Art</th>
								
						</tr>
					</thead>
					<tbody>
						
		@foreach($data['products_list'] as $row) 
		<tr class="odd gradeX">			
		<td><input type="checkbox" class="product_checkbox" value="{{ $row->product_row_id }}" name="product_row_ids[]" /></td>		
		<td style="text-align:left;padding-left:10px">{{ $row->product_name }}</td> 							 
		<td>${{ $row->product_price }}</td>
		<td>{{ $row->product_sku }}</td>	 
		<td>
			@if($row->product_image)
				@if($row->image_external_link)
					<img src="{{$row->product_image}}" alt="product Image" style="width:100px;height:80px" /> 								
				@else
					 <?php $arr = explode('|', $row->product_image) ?>
					
					<?php if( $arr[0] ) { ?>
						<a style="margin:0px;" href="#commonmodal" class="art_preview" caption="Product Image"  image_name="<?php echo $arr[0]; ?>" action="inactivate" data-toggle="modal">							
							<img src="{{ asset('/')}}public/uploads/product_images/{{ $data['user_id'] }}/<?php echo $arr[0]; ?>" alt="product Image" style="width:100px;height:80px" />
						</a>			
					<?php } ?>
				@endif
			@endif
		</td>
		<td style="text-align:center">
		@if($row->uploaded_design_image)
			<a style="margin:0px;" href="#commonmodal" class="art_preview" caption="Production Art" external="{{ $row->image_external_link }}"  image_name="{{ $row->uploaded_design_image }}" action="inactivate" data-toggle="modal">
				View
			</a>			
		@endif	
		</td>			 
		
	</tr>						
	@endforeach
	</tbody>
	</table>
			
	</form>
	</div>
	</div>
		<!-- END EXAMPLE TABLE PORTLET-->
		
		<div class="modal fade" id="commonmodal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<a class="btn dark btn-outline" data-dismiss="modal">Close</a>
					
					</div>
				</div>
			</div>
		</div>  
		
		<div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Import Products </h4>
					</div>
					<div class="modal-body">
						<form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
							<input type="file" name="import_file" />
							<div class="csv_format_note">Download a <a href=" {{ url('/')}}/public/csv/product_template.csv"> sample CSV </a> file to see an example of the format.</div>
							{!! csrf_field() !!}														
						
					</div>
					<div class="modal-footer">
						<button class="btn default" data-dismiss="modal" aria-hidden="true">Cancel</button>
						 <button class="btn sbold green">Upload File</button>
				   
					</div>
					 </form>   
				</div>
			</div>
		</div>

	</div>
</div>

@endsection	

@section('select2js')
<script src="{{asset('/')}}/public/css/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
@endsection	

@section('after-app-js')
<!-- BEGIN PAGE LEVEL SCRIPTSproduct -->		 
 <script src="{{asset('/')}}/public/css/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
 <script src="{{asset('/')}}/public/css/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->		
@endsection	

@section('page_js')
 <script type="text/javascript"> 
 
  $( document ).ready(function() {       
		$('#product_list').DataTable({
			"paging": true,
			"lengthChange": true,
			"lengthMenu":[[50, 75, 100, 200,-1],[50, 75, 100, 200, "All"]],
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"scrollX": true
            });
    });
	
 $('.deleteLink').click( function() {
  if( confirm('Are you sure to Delete ? ') )
  {
	var deleteID = $(this).attr('deleteID');   
    window.location.href = "{{ url('/')}}/delete-product/" + deleteID;    
  }        
 });
 
 $('#select_all').change(function() {
 
    var checkboxes = $(this).closest('form').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});

$('.art_preview').click(function(e){
			$('#commonmodal .modal-title').empty();
			$('#commonmodal .modal-body').empty();
			var image_name = $(this).attr('image_name');
			var external_image = $(this).attr('external');
			var caption = $(this).attr('caption');
			
			if(!external_image)
			var image = "{{ url('/') }}/public/uploads/product_images/{{ $data['user_id'] }}/" + image_name + "";
			else
			var image = "" + image_name + "";
			
			$('#commonmodal .modal-title').append(caption);
			$('#commonmodal .modal-body').append("<img src = " + image+ "  alt='Art image' style='max-width:570px;' />");
			$('#commonmodal .modal-footer .confirmrequest').attr("href", "{{ url('/') }}/schoolAdmin/manageStudent/deletestudent/"+studentid+"/"+activestatus);
		});
 </script> 
 
 <style type="text/css">
 .select_all_checkbox, .product_checkbox{width:18px;height:18px}
 </style>
@endsection