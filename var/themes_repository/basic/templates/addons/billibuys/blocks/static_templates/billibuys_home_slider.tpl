{** block-description:billibuys_home_slider **}

<script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
<script type="text/javascript" src="js/jquery-timing.min.js"></script>
<script type="text/javascript" src="js/jquery.cslider.js"></script>

<link rel="stylesheet" type="text/css" href="css/style.css" />

{capture name="slide"}
	{literal}
		$lang_group = {$lang_group}
		$step_subheading = {$step_subheading}
		$step_number = {$step_number}
	{/literal}
{/capture} 

<div id="da-slider" class="da-slider buyerslider">

	<div class="da-slide">
		<h2>{__('for_the_buyers')}</h2>
		<p>{__('step')} 1 {__('request_a_product')}</p>
		<span class="slide-body">{__('step_1_buyer')}</span>

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>

		<!-- <p>{__('step_1_buyer')}</p> -->
		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>

	<div class="da-slide">
		<h2>{__('for_the_buyers')}</h2>
		<p>{__('step')} 2 {__('get_bids')}</p>
		<span class="slide-body">{__('step_2_buyer')}</span>
		<!-- <p>{__('step_1_buyer')}</p> -->

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>

		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>

		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>

	<div class="da-slide">
		<h2>{__('for_the_buyers')}</h2>
		<p>{__('step')} 3 {__('purchase_items')}</p>
		<span class="slide-body">{__('step_3_buyer')}</span>
		<!-- <p>{__('step_1_buyer')}</p> -->

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>

		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>

	<nav class="da-arrows">
        <span class="da-arrows-prev"></span>
        <span class="da-arrows-next"></span>
    </nav>

</div>

<div id="da-slider" class="da-slider sellerslider">

	<div class="da-slide">
		<h2>{__('for_the_sellers')}</h2>
		<p>{__('step')} 1</p>
		<span class="slide-body">{__('step_1_seller')}</span>
		<!-- <p>{__('step_1_buyer')}</p> -->

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>

		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>

	<div class="da-slide">
		<h2>{__('for_the_sellers')}</h2>
		<p>{__('step')} 2</p>
		<span class="slide-body">{__('step_2_seller')}</span>
		<!-- <p>{__('step_1_buyer')}</p> -->

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>

		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>

	<div class="da-slide">
		<h2>{__('for_the_sellers')}</h2>
		<p>{__('step')} 3</p>
		<span class="slide-body">{__('step_3_seller')}</span>
		<!-- <p>{__('step_1_buyer')}</p> -->

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>

		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>

	<div class="da-slide">
		<h2>{__('for_the_sellers')}</h2>
		<p>{__('step')} 4</p>
		<span class="slide-body">{__('step_4_seller')}</span>
		<!-- <p>{__('step_1_buyer')}</p> -->

		<div class="da-img stickimg">
			<img src="http://placekitten.com/400/80" />
		</div>
		
		<div class="da-img">
			<img src="http://placekitten.com/350/250" />
		</div>
	</div>	

	<nav class="da-arrows">
        <span class="da-arrows-prev"></span>
        <span class="da-arrows-next"></span>
    </nav>
</div>

<a href="{'billibuys.view'|fn_url}"><span class="find_out_how_subbtn">
	{__('try_for_free')}
</span></a>