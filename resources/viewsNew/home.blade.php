@extends('layouts.app')

@section('datatable-css')
 <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}/public/css/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}/public/css/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
@endsection		
		
@section('content')
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
			<div class="visual">
				<i class="fa fa-shopping-cart"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="285">0</span>
				</div>
				<div class="desc"> New Products </div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 red" href="#">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">$
					<span data-counter="counterup" data-value="129,033">0</span></div>
				<div class="desc"> Monthly Sales </div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 green" href="#">
			<div class="visual">
				<i class="fa fa-tags"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="549">0</span>
				</div>
				<div class="desc"> New Orders </div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="dashboard-stat dashboard-stat-v2 purple" href="#">
			<div class="visual">
				<i class="fa fa-ship"></i>
			</div>
			<div class="details">
				<div class="number"> 
					<span data-counter="counterup" data-value="6"></span></div>
				<div class="desc">Vendors </div>
			</div>
		</a>
	</div>
</div>
<div class="clearfix"></div>

<div class="row">
	<div class="col-lg-6 col-xs-12 col-sm-12">
		<!-- BEGIN PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-dark hide"></i>
					<span class="caption-subject font-dark bold uppercase">Products</span>
					<span class="caption-helper">weekly stats...</span>
				</div>
				<div class="actions">
					<div class="btn-group btn-group-devided" data-toggle="buttons">
						<label class="btn red btn-outline btn-circle btn-sm active">
							<input type="radio" name="options" class="toggle" id="option1">New</label>
						<label class="btn red btn-outline btn-circle btn-sm">
							<input type="radio" name="options" class="toggle" id="option2">Existing</label>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div id="site_statistics_loading">
					<img src="{{asset('/')}}/public/css/assets/global/img/loading.gif" alt="loading" /> </div>
				<div id="site_statistics_content" class="display-none">
					<div id="site_statistics" class="chart"> </div>
				</div>
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
	<div class="col-lg-6 col-xs-12 col-sm-12">
	<!-- BEGIN REGIONAL STATS PORTLET-->
		<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-share font-dark hide"></i>
				<span class="caption-subject font-dark bold uppercase">COUNTRY SPECIFIC PRODUCTS</span>
			</div>
			<div class="actions">
				<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
					<i class="icon-cloud-upload"></i>
				</a>
				<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
					<i class="icon-wrench"></i>
				</a>
				<a class="btn btn-circle btn-icon-only btn-default fullscreen" data-container="false" data-placement="bottom" href="javascript:;"> </a>
				<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
					<i class="icon-trash"></i>
				</a>
			</div>
		</div>
		<div class="portlet-body">
			<div id="region_statistics_loading">
				<img src="../assets/global/img/loading.gif" alt="loading" /> </div>
			<div id="region_statistics_content" class="display-none">
				<div class="btn-toolbar margin-bottom-10">
					<div class="btn-group btn-group-circle" data-toggle="buttons">
						<a href="" class="btn grey-salsa btn-sm active"> Vendors </a>
						<a href="" class="btn grey-salsa btn-sm"> Products </a>
					</div>
					<div class="btn-group pull-right">
						<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Select Region
							<span class="fa fa-angle-down"> </span>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:;" id="regional_stat_world"> World </a>
							</li>
							<li>
								<a href="javascript:;" id="regional_stat_usa"> USA </a>
							</li>
							<li>
								<a href="javascript:;" id="regional_stat_europe"> Europe </a>
							</li>
							<li>
								<a href="javascript:;" id="regional_stat_russia"> Russia </a>
							</li>
							<li>
								<a href="javascript:;" id="regional_stat_germany"> Germany </a>
							</li>
						</ul>
					</div>
				</div>
				<div id="vmap_world" class="vmaps display-none"> </div>
				<div id="vmap_usa" class="vmaps display-none"> </div>
				<div id="vmap_europe" class="vmaps display-none"> </div>
				<div id="vmap_russia" class="vmaps display-none"> </div>
				<div id="vmap_germany" class="vmaps display-none"> </div>
			</div>
		</div>
	</div>
		<!-- END REGIONAL STATS PORTLET-->
   </div>
</div>
                    
         
		 
<div class="row">
	<div class="col-lg-6 col-xs-12 col-sm-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption ">
					<span class="caption-subject font-dark bold uppercase">PRODUCTS BY CATEGORY</span>
					<span class="caption-helper">% of total states</span>
				</div>
				<div class="actions">
					<div class="btn-group">
						<a class="btn green-haze btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:;"> Option 1</a>
							</li>
							<li class="divider"> </li>
							<li>
								<a href="javascript:;">Option 2</a>
							</li>
							<li>
								<a href="javascript:;">Option 3</a>
							</li>
							<li>
								<a href="javascript:;">Option 4</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div id="dashboard_amchart_4" class="CSSAnimationChart"></div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-6 col-xs-12 col-sm-12">
		
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-cursor font-dark hide"></i>
					<span class="caption-subject font-dark bold uppercase">General Stats</span>
				</div>
				<div class="actions">
					<a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">
						<i class="fa fa-repeat"></i> Reload </a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-4">
						<div class="easy-pie-chart">
							<div class="number transactions" data-percent="55">
								<span>+55</span>% </div>
							<a class="title" href="javascript:;"> Products
								<i class="icon-arrow-right"></i>
							</a>
						</div>
					</div>
					<div class="margin-bottom-10 visible-sm"> </div>
					<div class="col-md-4">
						<div class="easy-pie-chart">
							<div class="number visits" data-percent="85">
								<span>+85</span>% </div>
							<a class="title" href="javascript:;"> New Art
								<i class="icon-arrow-right"></i>
							</a>
						</div>
					</div>
					<div class="margin-bottom-10 visible-sm"> </div>
					<div class="col-md-4">
						<div class="easy-pie-chart">
							<div class="number bounce" data-percent="46">
								<span>-46</span>% </div>
							<a class="title" href="javascript:;"> Mockups
								<i class="icon-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
 
	</div>

</div>

           
@endsection

@section('select2js')
 <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('/')}}/public/css/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
@endsection		

@section('after-app-js')	
 <script src="{{asset('/')}}/public/css/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
@endsection