@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<span aria-hidden="true" class="icon-list"></span>
					<span class="caption-subject bold uppercase">OrderDesk Integration</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<form id ="products_listing" method="post" action="{{ url('/orderDeskProductSubmit') }}" >
				{!! csrf_field() !!}

                    <h4 class="block">Product Selection</h4>
                    <div class="row input_fields_wrap" style="margin-top: 20px;">
                        <div class="productlist col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div>Name:</div>
                                    <div>
                                        <select id="proSect_1" name="productids[]" class="form-control search_orders js-example-responsive" prosect="1">
                                            <option value="">Please Select Product</option>
                                            @foreach($allProducts as $prodata)
                                            <option value="{{ $prodata->product_row_id }}" prosku="{{$prodata->product_sku}}" proprice="{{$prodata->product_price}}">{{ $prodata->product_name }}</option>    
                                            @endforeach
                                        </select>
                                    </div>      
                                </div>
                                <div class="col-md-2">
                                    <div>SKU:</div>
                                    <div>
                                        <input id="proSku_1" class="form-control pro_sku" type="" name="prosku[]">
                                    </div>      
                                </div>
                                <div class="col-md-2">
                                    <div>PRICE:</div>
                                    <div>
                                        <input id="proPrice_1" class="form-control pro_price" type="" name="proprice[]">
                                    </div>      
                                </div>
                                <div class="col-md-2">
                                    <div>ADD MORE:</div>
                                    <div>
                                        <a href="javascript:void(0)" class="nav-link nav-toggle addmore"><i class="icon-plus" style="font-size: 20px;margin-top: 10px;"></i></a>
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>                            

                    <input class="serialcount" type="hidden" name="serialcount" value="1">

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12 text-center">
                            <button style="display: inline-block;" class="btn btn-success submitorder"><i class="fa fa-check"></i> SUBMIT TO ORDERDESK</button>
                        </div>
                    </div>
                    
				</form>
			</div>
		</div>
	</div>
</div>

@endsection


@section('page_js')

<script type="text/javascript">

    $( document ).ready(function() {

        $('.addmore').click( function() {
            let serialcount = $('.serialcount').val();
            serialcount++;
            $('.input_fields_wrap').append('<div class="productlist col-md-12" style="margin-top:15px;"> <div class="form-group"> <div class="col-md-6"> <div>Name:</div> <div> <select id="proSect_'+serialcount+'" name="productids[]" class="form-control search_orders js-example-responsive" prosect="'+serialcount+'"> <option value="">Please Select Product</option> @foreach($allProducts as $prodata) <option value="{{ $prodata->product_row_id }}" prosku="{{$prodata->product_sku}}" proprice="{{$prodata->product_price}}">{{ $prodata->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-2"> <div>SKU:</div> <div> <input id="proSku_'+serialcount+'" class="form-control pro_sku" type="" name="prosku[]"> </div> </div> <div class="col-md-2"> <div>PRICE:</div> <div> <input id="proPrice_'+serialcount+'"  class="form-control pro_price" type="" name="proprice[]"> </div> </div> <div class="col-md-2"> <div>REMOVE:</div> <div> <a href="javascript:void(0)" class="nav-link nav-toggle remove_field"><i class="fa fa-remove" style="font-size: 20px;margin-top: 10px;"></i></a></div></div></div></div>');
            $('.serialcount').val(serialcount);
        });

        $('.input_fields_wrap').on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault();
            var parentclass = $(this).parent();
            $(this).closest('.productlist').remove();
        });

        $('.input_fields_wrap').on("change",".search_orders", function(e){
            var prosku = $('option:selected', this).attr('prosku');
            var proprice = $('option:selected', this).attr('proprice');
            var prosect = $(this).attr('prosect');
            //console.log(prosect+'  '+prosku+'   '+proprice);
            $('#proSku_'+prosect).val(prosku);
            $('#proPrice_'+prosect).val(proprice);
        });
    });

</script>

@endsection