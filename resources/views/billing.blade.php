@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">					
					<span class="caption-subject bold uppercase">Billing</span>
				</div>
				<div class="actions">					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role="form" id="payment-form" method="post" action="" enctype="multipart/form-data">
				   {!! csrf_field() !!}
					<div class="row">
					<div class="col-md-6">
						@if(Session::has('success-message'))
							<div class="alert alert-success">
								<strong>Success! </strong> {{ Session::get('success-message') }}
							</div>
						@endif

						@if(Session::has('error-message'))
							<div class="alert alert-danger">
								<strong>Error! </strong>{{ Session::get('error-message') }}
							</div>
						@endif
					</div>
					</div>
				    <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->collection_row_id : '' }}" >
					<div class="form-body"> 
						<div class="form-group row">
							<div class="col-md-2">Name: </div>
							<div class="col-md-10"><input type="text" class="form-control input-large name" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required> </div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-2">Card Number: </div>
							<div class="col-md-10"><input type="text" class="form-control input-large card-number" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required> </div>
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-2">Expiration (MM/YYYY): </span> </label>

							<div class="col-md-2">
							<input   type="text" required class="form-control card-expiry-month" size="2" maxlength="2" data-stripe="exp_month" placeholder="MM" />
							<span class="help-block"> </span> 
							</div>
							<div class="col-md-2">
							  <input   type="text" required class="form-control card-expiry-year" size="2" data-stripe="exp_year" maxlength="4" placeholder="YYYY"/>
							  <span class="help-block"> </span> 
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-2">CVV: </div>
							<div class="col-md-10"><input type="text" data-stripe="cvc" class="form-control input-small card-cvc" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required> </div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-2">Billing Zip: </div>
							<div class="col-md-10"><input type="text" class="form-control input-small address_zip" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required> </div>
						</div>
					
					</div>
					<div class="form-actions noborder">
						<button type="submit" id="submitBtn" class="btn blue mt-ladda-btn ladda-button" data-style="slide-up" data-spinner-color="#333">
							<span class="ladda-label">Submit</span>
							<span class="ladda-spinner"></span>
						</button>
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/home')}}'">Cancel</button>					
					</div>
				</form>
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
<script src="{{ url('public/css/assets/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
	$(document).ready(function() {
        Ladda.bind('#submitBtn');
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey('{!! env('STRIPE_KEY') !!}');

        $('#payment-form').submit(function(event) {
            Stripe.card.createToken({
                number: $('input.card-number').val(),
                cvc: $('input.card-cvc').val(),
                exp_month: $('input.card-expiry-month').val(),
                exp_year: $('input.card-expiry-year').val(),
                name: $('input.name').val(),
                address_zip: $('input.address_zip').val()
            }, stripeResponseHandler);

            return false;
        });

        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');

            if (response.error) {
                $('<div class="alert alert-danger">' + response.error.message + '</div>').prependTo("#payment-form").fadeIn().delay(2000).fadeOut();
                $('#submitBtn').button('reset');
                Ladda.stopAll();
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        };
	});
</script>
<script type="text/javascript">
$(".available_field_link") . click( function() {
  var available_field_value = $(this).attr('available_field_value');
	$(".selected_fields").append('<div class="form-group" style="clear:both;padding-top:10px"><div style="float:left;padding-right:10px"><input type="text" class="form-control input-small"  name="template_fields[]" value="' + available_field_value + '"></div><div style="float:left"><input type="text" class="form-control input-small"  name="template_fields_values[]" value="{' + available_field_value + '}"></div>');
});
</script>
@endsection

@endsection
