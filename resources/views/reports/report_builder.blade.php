@extends('layouts.app')
@section('select2css')
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')	
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="fa fa-line-chart"></i>
					<span class="caption-subject bold uppercase"> Report Builder</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/report-builder">
				   {!! csrf_field() !!}				   
					<div class="form-body">
						<div class="form-group">									
							<label class="col-md-2 control-label">Group By: </label>
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="group_by_element">													
									<option value="0">Select...</option>									
									<option value="vendor_row_id">Vendor</option>
									<option value="category_row_id">Category</option>
									<option value="collection_row_id">Collection</option>
									<option value="product_type_row_id">Product Type</option>									
								</select>
							</div>			
							<label class="col-md-2 control-label">Folder:</label>										
							<div class="col-md-4">										  
								<select class="table-group-action-input form-control" name="category_row_id" id="category_row_id">													
									<option value="0">Select...</option>
									@foreach($data['folders_list'] as $row)									  
										<option value="{{ $row->folder_row_id }}" @if( isset($data['folder_row_id'])  && $data['folder_row_id'] ==  $row->folder_row_id) selected='selected' @endif>{{ $row->folder_name }}</option>
									@endforeach
								</select>
							</div>													
						</div>
						<div class="form-group advanced_search_options">	
							<label class="col-md-2 control-label">Search:</label>										
							<div class="col-md-4">										  
								<input type="text" name="product_name" class="form-control"  />
							</div>
							
							<label class="col-md-2 control-label">Date Range:</label>
							<div class="col-md-4">
								<div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
									<input type="text" class="form-control" name="from">
									<span class="input-group-addon"> to </span>
									<input type="text" class="form-control" name="to"> 
								</div>
							</div>										
						</div>
						
					</div>                  
						   
					<div class="form-actions noborder">
						<button type="submit" name="submit" value="search" class="btn blue report-submit">Build Report</button>	
						<!--button type="submit" name="submit" value="csv" class="btn default report-csv" onclick="javascript:void(0)">Export To CSV</button>
						<button type="submit" name="submit" value="pdf" class="btn default report-csv" onclick="javascript:void(0)">Export To PDF</button-->
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
								<th style="width:20%;text-align:left;padding-left:10px">Vendor Name</th>              
								<th>Product Count</th>
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
			<td style="text-align:left;padding-left:10px"><?php echo  DB::table('vendors')->where('vendor_row_id',  $row->vendor_row_id)->value('vendor_name'); ?></td> 			 
			<td>{{$row->count}}</td>
		</tr>		
			
		@endforeach
		
	
							
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
		

		
		<!--div class="row">
			<div class="col-md-7"> </div>
			<div class="col-md-5">
				<div class="form-actions noborder">						
						<button type="submit" name="submit" value="csv" class="btn default report-csv" onclick="javascript:void(0)">Export To CSV</button>
						<button type="submit" name="submit" value="search" class="btn default report-csv" onclick="javascript:void(0)">Export To PDF</button>
				</div>
			</div>
		</div-->
				
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('/')}}/public/css/assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('after-app-js')
<script src="{{asset('/')}}/public/css/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
@endsection