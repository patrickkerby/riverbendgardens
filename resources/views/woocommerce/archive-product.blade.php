{{--
The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
  @php
    do_action('get_header', 'shop');
    do_action('woocommerce_before_main_content');
  @endphp
<section class="row justify-content-center">
			<div class="col-md-10 veggie-content">
				<div class="callstoaction row justify-content-center">
          <h3>Pickup locations available across Edmonton.</h3>
          <h3>Curious what to expect in your CSA? <a href="#" data-toggle="modal" data-target="#pickupModal-csa">Here's a handy chart!</a></h3>
				</div>
			</div>
			<div class="modal fullmodal fade" id="pickupModal-csa" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content">
					<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="modal-body">
						<div class="container-fluid">                
						 @include('partials.flexible-csachart')
						</div>
					</div>
					</div>
				</div>
			</div>
		</section>
  @if(woocommerce_product_loop())
    <section>
    @php
      woocommerce_product_loop_start();
    @endphp

    @if(wc_get_loop_prop('total'))
      {{-- @while(have_posts()) --}}
        @php
          do_action('woocommerce_shop_loop'); 
          the_post();
          // wc_get_template_part('content', 'product');
        @endphp
      {{-- @endwhile --}}
    @endif

    @php
      woocommerce_product_loop_end();
      do_action('woocommerce_after_shop_loop');
    @endphp
  @else
    @php
      do_action('woocommerce_no_products_found');
    @endphp
    </section>
  @endif

  @php
    do_action('woocommerce_after_main_content');
    do_action('get_sidebar', 'shop');
    do_action('get_footer', 'shop');
  @endphp
@endsection

