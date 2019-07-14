@extends('layouts.app')

@section('select2css')
 <link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
 <link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />	
@endsection

@section('content')					 
 <div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">					
					<div class="import-instruction"> Click the button below to import a product CSV. </div>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<a href="#myModal1" role="button" class="btn sbold green" data-toggle="modal"> CLick Here To Import <i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="col-md-6">
						   
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
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
					
					
					<div style="padding:15px 0 0 0">
						<table width="100%" cellspacing="4" cellpadding="4">
							<tr>
								<td align="left" colspan="2">
								<div style="padding:0 0 10px 0;color:#a9a9a9">
								  Note: If you want to use your own CSV format, please first create an Import Template, which will then be an option in the dropdown below.
								</div>
								</td>													
							</tr>
							
							<tr>
								<td align="left" style="width:150px">Select Template:</td>
								<td align="left">
									<select class="form-control input-medium" name="template_row_id"> 
									<option value="0">Select</option>
										@foreach($data['import_templates'] as $template)
											<option value="{{ $template->template_row_id}}">{{ $template->template_name}}</option> 
										@endforeach
									</select> 
								</td>							
							</tr>
						</table>
					</div>
					
			</div>
			<div class="modal-footer">
				<button class="btn default" data-dismiss="modal" aria-hidden="true">Cancel</button>
				 <button class="btn sbold green">Upload File</button>
			</div>
			 </form>   
		</div>
	</div>
</div>
@endsection	

@section('select2js')
	<script src="{{asset('/')}}/public/css/assets/global/scripts/datatable.js" type="text/javascript"></script>
	<script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
	<script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
@endsection	

@section('after-app-js')
	<!-- BEGIN PAGE LEVEL SCRIPTSproduct -->		 
	 <script src="{{asset('/')}}/public/css/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->		
@endsection	

@section('page_js')
 <script type="text/javascript"> 
 $('.deleteLink').click( function() {
	if( confirm('Are you sure to Delete ? ') )
	{
		var deleteID = $(this).attr('deleteID');   
		window.location.href = "{{ url('/')}}/delete-product/" + deleteID;    
	}        
 });
 
 </script> 
@endsection