@extends('layouts.app')

@section('select2css')
<link href="{{asset('/')}}/public/css/assets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')	
<!-- BEGIN PAGE BASE CONTENT -->
<form role = "form" method="post" action="{{ url('/')}}/reports">
<div class="row">	
	<div class="col-md-12">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="fa fa-line-chart"></i>
					<span class="caption-subject bold uppercase"> Reports</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">
				@if(Session::has('error-message'))
					<div class="alert alert-danger">
						{{ Session::get('error-message') }}
					</div>
				@endif

				   {!! csrf_field() !!}				   
					<div class="form-body">
						<div class="form-group">									
							<label class="col-md-2 control-label">Vendor: </label>
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="vendor_row_id" id="vendor_row_id">													
									<option value="0">Select...</option>
									@foreach($data['vendors_list'] as $row)									  
										<option value="{{ $row->vendor_row_id }}" @if( isset($data['vendor_row_id'])  && $data['vendor_row_id'] ==  $row->vendor_row_id) selected='selected' @endif>{{ $row->vendor_name }}</option>
									@endforeach
								</select>
							</div>			
							<label class="col-md-2 control-label">Category:</label>										
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="category_row_id" id="category_row_id">													
									<option value="0">Select...</option>
									@foreach($data['categories_list'] as $row)
										<option value="{{ $row->category_row_id }}" @if( isset($data['category_row_id'])  && $data['category_row_id'] ==  $row->category_row_id) selected='selected' @endif>{{ $row->category_name }}</option>
									@endforeach
								</select>
							</div>													
						</div>
						
						
						<div class="form-group advanced_search_options" style="padding-top:45px">	
							<label class="col-md-2 control-label">Collection:</label>										
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="collection_row_id" id="collection_row_id">													
									<option value="0">Select...</option>
									@foreach($data['collections'] as $row)
										<option value="{{ $row->collection_row_id }}" @if( isset($data['collection_row_id'])  && $data['collection_row_id'] ==  $row->collection_row_id) selected='selected' @endif>{{ $row->collection_name }}</option>
									@endforeach
								</select>
							</div>
							
							<label class="col-md-2 control-label">Type:</label>
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="product_type_row_id" id="product_type_row_id">
									<option value="0">Select...</option>
									@foreach($data['product_types_list'] as $row)
										<option value="{{ $row->product_type_row_id }}" @if( isset($data['product_type_row_id'])  && $data['product_type_row_id'] ==  $row->product_type_row_id) selected='selected' @endif>{{ $row->product_type_name }}</option>
									@endforeach					
								</select>
							</div>										
						</div>	
						

						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">Folder:</label>										
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="folder_row_id" id="folder_row_id">													
									<option value="0">Select...</option>
									@foreach($data['folders_list'] as $row)
										<option value="{{ $row->folder_row_id }}" @if( isset($data['folder_row_id'])  && $data['folder_row_id'] ==  $row->folder_row_id) selected='selected' @endif>{{ $row->folder_name }}</option>
									@endforeach		
								</select>
							</div>
							
							<label class="col-md-2 control-label">Inventory Serial :</label>
							<div class="col-md-4">
								<input type="text" name="inventory_serial" class="form-control" value="{{ isset($data['inventory_serial']) ? $data['inventory_serial']: '' }}" />
							</div>											
						</div>	
						
						
						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">Product Name:</label>										
							<div class="col-md-4">										  
								<input type="text" name="product_name" class="form-control" value="{{ isset($data['product_name']) ? $data['product_name']: '' }}"  />
							</div>
							
							<label class="col-md-2 control-label">Product Sku:</label>
							<div class="col-md-4">										  
								<input type="text" name="product_sku" class="form-control" value="{{ isset($data['product_sku']) ? $data['product_sku']: '' }}" />
							</div>										
						</div>
						
						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">AKU:</label>										
							<div class="col-md-4">										  
								<input type="text" name="aku_code" class="form-control" value="{{ isset($data['aku_code']) ? $data['aku_code']: '' }}" />
							</div>
							
							<label class="col-md-2 control-label">Barcode:</label>
							<div class="col-md-4">										  
								<input type="text" name="upc" class="form-control" value="{{ isset($data['upc']) ? $data['upc']: '' }}" />
							</div>										
						</div>	
						
					</div>                  
						   
					<div class="form-actions noborder">
						<button type="submit" name="submit" value="search" class="btn blue report-submit">SEARCH</button>	
						<button type="submit" name="submit" value="csv" class="btn default report-csv" onclick="javascript:void(0)"><i class="icon-share-alt"></i> Export To CSV</button>
						<button type="submit" name="submit" value="pdf" class="btn default report-csv" onclick="javascript:void(0)"><i class="icon-docs"></i> Export To PDF</button>
						<button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_filename"><i class="icon-picture"></i> Export Images</button>
					</div>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
<div id="export_filename" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Download Images </h4>
			</div>
			<div class="modal-body">
				<h5>Choose a file name</h5>
				<div class="input-group">
					<input type="text" class="form-control" name="filename" />
					<span class="input-group-addon">.zip</span>
				</div>
				<h5>Optional: Rename each image to its</h5>
				<select class="form-control" name="rename" autocomplete="off">
					<option>Don’t Rename</option>
					<option value="upc">UPC</option>
					<option value="product_sku">SKU</option>
					<option value="vendor_sku">Vendor SKU</option>
					<option value="aku_code">AKU</option>
				</select>
			</div>
			<div class="modal-footer">
				<button class="btn default" data-dismiss="modal" aria-hidden="true" type="button">Cancel</button>
				<button class="btn sbold green mt-ladda-btn ladda-button" id="ladda" type="submit" name="submit" value="imagesOnly" data-style="slide-up" data-spinner-color="#333">
					<span class="ladda-label">Download Zip Images</span>
					<span class="ladda-spinner"></span>
				</button>
			</div>
		</div>
	</div>
</div>

<?php if(! empty( $data['products_list'])) { ?>

<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">                              
				<div class="portlet-body">
					<div class="table-toolbar">							
					</div>
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
						<thead>
							<tr>
								<th style="width:30%;text-align:left;padding-left:10px">Product Name</th>              
								<th style="width:15%">Price</th>   
								<th style="width:15%"> SKU</th>     
								<th style="width:20%">Primary Image</th>     
								<th style="width:10%">Edit</th>								
										
							</tr>
						</thead>
						<tbody>
							<?php if( !$data['products_list'])
							{
							 echo '<tr class="odd gradeX"><td style="text-align:center;" colspan="4"> No Data </td></tr>'; 
							}
							?>
			@foreach($data['products_list'] as $row) 
			<tr class="odd gradeX">							
			<td style="text-align:left;padding-left:10px">{{$row->ProductName}}</td> 			 
			<td>${{$row->Price}}</td>
			<td>{{$row->Sku}}</td>	 
			<td>
				@if($row->Image)
				
					@if($row->image_external_link)
						<img src="{{$row->Image}}" alt="product Image" style="width:100px;height:100px" /> 								
					@else
						 <?php $arr = explode('|', $row->Image) ?>
						<img src="{{ asset('/')}}public/uploads/product_images/{{$data['user_id']}}/<?php echo $arr[0]; ?>" alt="product Image" style="width:100px;height:100px" /> 
					@endif
				@endif
			</td>
			<td><a href="{{ url('/')}}/edit-product/{{$row->product_row_id}}" target="_blank">Edit</a></td>	
			
		</tr>		
			
		@endforeach
		
	
							
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
	<div class="row">
			<div class="col-md-2"> </div>
			<div class="col-md-10">
				<div class="form-actions noborder text-right">
					<button type="submit" name="submit" value="csv" class="btn default report-csv" onclick="javascript:void(0)"><i class="icon-share-alt"></i> Export To CSV</button>
					<button type="submit" name="submit" value="pdf" class="btn default report-csv" onclick="javascript:void(0)"><i class="icon-docs"></i> Export To PDF</button>
					<button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_filename"><i class="icon-picture"></i> Export Images</button>
				</div>
			</div>
	</div>
				
<?php } ?>
</form>
<style  type="text/css">
.advanced_search_options{padding-bottom:20px;padding-top:25px;}
.report-submit
{
	margin-left:10px;
}
.report-csv {
	margin-left:10px;
}
.control-label{
  text-align:right;
}
</style>
@endsection

@section('select2js')
<script src="{{asset('/')}}/public/css/assets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
@endsection

@section('after-app-js')
	<script src="{{ url('public/css/assets/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('public/css/assets/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
 <script src="{{asset('/')}}/public/css/assets/pages/scripts/components-ion-sliders.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
	    Ladda.bind("#ladda");

        $('input[name=filename]').on('keypress', function(e) {
            return e.which !== 13;
        });

//        $("button[value=imagesOnly]").click(function() {
//        	$("#export_filename").modal("hide");
//        });
	});

$('#advanced_search').click( function() {
		$(this).hide();
		 $('.advanced_search_options').show();
	});
	
 
</script>
@endsection