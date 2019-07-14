@extends('layouts.app')

@section('select2css')
<link href="{{asset('/')}}/public/css/assets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')	
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					
					<span class="caption-subject bold uppercase"> Search</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/search">
				   {!! csrf_field() !!}				   
					<div class="form-body">
					
						<div class="form-group" style="padding:0 0 5px 0">								
							<label class="col-md-2 control-label">Search By Keyword: </label>
															
							<div class="col-md-10">										  
								<input type="text" name="keyword" class="form-control"  /><br />
							</div>													
						</div>
						
						
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
							</div><br />													
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
								<select class="table-group-action-input form-control">	
									<option value="0">Select...</option>
									<option value="">Product Type - 1</option>
										<option value="">Product Type - 2</option>									
								</select>
							</div>										
						</div>	
						

						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">Product Status:</label>										
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="product_status" id="product_status">													
									<option value="0">Select...</option>
									<option value="1" @if( isset($data['product_status']) && $data['product_status'] == 1) selected='selected' @endif>Archived Products</option>
									<option value="2">New Products</option>	
									<option value="3" @if( isset($data['product_status']) && $data['product_status'] == 3 ) selected='selected' @endif>Favorites Products</option>										
								</select>
							</div>
							
							<label class="col-md-2 control-label">Group By:</label>
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control">		
									<option value="0">Select...</option>
									<option value="">Small</option>
									<option value="">Medium</option>	
									<option value="">Large</option>	
									<option value="">Red</option>	
									<option value="">Green</option>
									<option value="">Blue</option>
								</select>
							</div>										
						</div>	
						
						
						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">Product Name:</label>										
							<div class="col-md-4">										  
								<input type="text" name="product_name" class="form-control"  />
							</div>
							
							<label class="col-md-2 control-label">Product Sku:</label>
							<div class="col-md-4">										  
								<input type="text" name="product_sku" class="form-control"  />
							</div>										
						</div>
						
						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">AKU:</label>										
							<div class="col-md-4">										  
								<input type="text" name="aku_code" class="form-control"  />
							</div>
							
							<label class="col-md-2 control-label">Barcode:</label>
							<div class="col-md-4">										  
								<input type="text" name="upc" class="form-control"  />
							</div>										
						</div>	
						
						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">Stock Levels :</label>
							<div class="col-md-4">
								<select class="table-group-action-input form-control" name="stock_level">		
									<option value="0">Select...</option>
									<option value="0">On-Demand / Unlimited</option>
									<option value="0">Inventoried / Unlimited</option>
									<option value="0">Inventoried / Limited</option>									
								</select>
							</div>																	
						</div>	
					</div>                  
						   
					<div class="form-actions noborder">
						<button type="submit" name="submit" value="search" class="btn blue report-submit">SEARCH</button>	
						<button type="submit" name="submit" value="csv" class="btn default report-csv" onclick="javascript:void(0)">Export To CSV</button>
						<button type="submit" name="submit" value="pdf" class="btn default report-csv" onclick="javascript:void(0)">Export To PDF</button>
					</div>
					
					
				
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
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
								<th style="width:30%;text-align:left;padding-left:10px">Vendor Name</th>              
								<th style="width:10%">Product Count</th>
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
			<td style="text-align:left;padding-left:10px">{{$row['vendor_row_id']}}</td> 			 
			<td>${{$row['count']}}</td>
			
			<td>
				
			</td>
			
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
			<div class="col-md-7"> </div>
			<div class="col-md-5">
				<div class="form-actions noborder">						
						<button type="submit" name="submit" value="csv" class="btn default report-csv" onclick="javascript:void(0)">Export To CSV</button>
						<button type="submit" name="submit" value="search" class="btn default report-csv" onclick="javascript:void(0)">Export To PDF</button>
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

 <script src="{{asset('/')}}/public/css/assets/pages/scripts/components-ion-sliders.min.js" type="text/javascript"></script>

<script type="text/javascript"> 

$('#advanced_search').click( function() {
		$(this).hide();
		 $('.advanced_search_options').show();
	});
	
	
 
</script>
@endsection