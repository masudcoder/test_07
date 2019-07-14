@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">					
					<span class="caption-subject bold uppercase">OrderDesk Integration</span>
                    
				</div>
				<div class="actions" style="text-align: right;">
                    <img src="{{ url('/') }}/public/images/orderdesk.png" style="width: 22%; height: auto;">				
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
            @if(empty($data['user_orderdeskdetails']))
                <div class="note note-warning">
                    <p>You didn't yet setup your OrderDesk Integration method.</p>
                </div>
            @endif
            <form id="orderdeskform" class="form-horizontal form-row-seperated" method="post" action="{{ url('/')}}/store-integration-info">
                {!! csrf_field() !!}
    			<div class="portlet-body form">
    				<div class="form-body"> 
    					<div class="form-group row">
    						<div class="col-md-2">Store ID: </div>
    						<div class="col-md-10">
                                <input id="storeId" type="text" class="form-control" name="store_id"  value="@if(isset($data['user_orderdeskdetails'][0]['store_id']) && ($data['user_orderdeskdetails'][0]['store_id'] != '')){{$data['user_orderdeskdetails'][0]['store_id']}}@endif" required>
                            </div>
    					</div>
                        <div class="form-group row">
                            <div class="col-md-2">API Key: </div>
                            <div class="col-md-10">
                                <input id="appApiKey" type="text" class="form-control" name="api_key" value="@if(isset($data['user_orderdeskdetails'][0]['api_key']) && ($data['user_orderdeskdetails'][0]['api_key'] != '')){{$data['user_orderdeskdetails'][0]['api_key']}}@endif" required> 
                            </div>
                        </div>

                        <div class="form-group row validaccount" style="display: none;">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <div class="note note-success">
                                    <p>Verification Successfully Done. This OrderDesk accout is valid.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row invalidaccount" style="display: none;">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <div class="note note-danger">
                                    <p>Verification Successfully Done. This OrderDesk accout is <b>not</b> valid.</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <a class="btn btn-success saveorderdesk"><i class="fa fa-check"></i><span>Save OrderDesk Info</span></a>
                                <a class="btn btn dark" href="{{ url('/integrations')}}"><i class="fa fa-backward"></i><span>Back</span></a>
                            </div>
                        </div>
    				</div>
    			</div>
            </form>
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
        $('.saveorderdesk').click(function() {
            // need to verify the orderDesk api details

            var storeid = $('#storeId').val();
            var appapikey = $('#appApiKey').val();
            if((storeid == '') || (appapikey == '')){
                alert('Please provide required fields.');
                return false;
            }
            $(".saveorderdesk span").text("Verifying Information.....");
            $('.validaccount').hide();
            $('.invalidaccount').hide();
            
            $.ajax({
                url: "{{ url('verify-orderdesk-details') }}/"+storeid+'/'+appapikey,
                type: "GET",
                dataType:"html",       
                success: function(data){
                    var obj = jQuery.parseJSON(data);
                    //console.log(obj.status);
                    $(".saveorderdesk span").text("Save OrderDesk Info");
                    if(obj.status == 'success') {
                        $('.validaccount').show('slow');
                        setTimeout(function(){
                          $('#orderdeskform').submit();
                        }, 2000);
                    } else {
                        $('.invalidaccount').show('slow');
                        $('#storeId').val('');
                        $('#appApiKey').val('');
                        return false;
                    }
                },
            });

            
        });
    });
</script>

@endsection

@endsection
