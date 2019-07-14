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
				@if($result['status'] == 'success')
                    <div class="note note-success">
                        <h4 class="block">Inventory Items Added</h4>
                        <p>Your submitted inventory items has been successfuly added to OrderDesk Inventory Items section.</p>
                    </div>
                @else
                    <div class="note note-warning">
                        <h4 class="block">Inventory Items Not Added</h4>
                        <p>Your submitted inventory items has not been added to OrderDesk Inventory Items section. Check the issue with your input products.</p>
                    </div>  
                @endif

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12 text-center">
                        <a href="{{ url('/place-order') }}" style="display: inline-block;" class="btn btn-success"><i class="fa fa-check"></i> BACK TO ORDERDESK INVENTORY</a>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>

@endsection


@section('page_js')
    <script type="text/javascript">
        $( document ).ready(function() {

        });
    </script>
@endsection