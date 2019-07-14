@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">					
					<i class="fa fa-plug"></i><span class="caption-subject bold uppercase">Manage Integrations</span>
                    
				</div>
				<div class="actions" style="text-align: right;">
                    
				</div>
			</div>

            <div class="portlet-body form">
                <div class="form-body"> 
                    <div class="form-group row">
                        <div class="col-md-3" style="text-align: center; padding:1%;">
                            <img src="{{ url('/') }}/public/images/orderdesk.png" style="width: 88%; height: auto;">
                            <a class="btn btn-xs btn-primary" href="{{ url('/orderdesk-integration')}}" style="margin-top: 15px;">Settings</a>
                            <button class="btn btn-xs btn dark" style="margin-top: 15px;">Disable</button>
                        </div>
                    </div>
                </div>
            </div>        

            
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
<style type="text/css">
.portlet-body form {color:#808080;}
.available_fields {line-height:25px; padding-top:20px}
.available_fields a{padding-right:5px;}
a:hover{text-decoration:none}
.mt-checkbox, .mt-radio { padding-left: 20px;}
.checkbox_text{padding-right:15px}
</style>

@section('page_js')
<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>

@endsection

@endsection
