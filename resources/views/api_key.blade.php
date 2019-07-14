@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">					
					<span class="caption-subject bold uppercase">API Key</span>
				</div>
				<div class="actions">					
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body"> 
					<div class="form-group row">
						<div class="col-md-2">API / Secret Key: </div>
						<div class="col-md-10">
                             <input type="text" class="form-control input-large name" value="{{ $data['api_key'] }}"> 
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
