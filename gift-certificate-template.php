<?php if (!defined('ABSPATH')) exit; ?>

<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// For gmail compatibility, including CSS styles in head/body are stripped out therefore styles need to be inline. These variables contain rules which are added to the template inline. !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
$wrapper = "
	width:100%;
	-webkit-text-size-adjust:none !important;
	margin:0;
	padding: 70px 0 70px 0;
	background: url('https://www.riverbendgardens.ca/wp-content/themes/riverbend/images/RB-login-bg.jpg');
	background-size: cover;
";
$template_container = "
	box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
	background-color: " . esc_attr( $body ) . ";
";
$template_header = "
	background-color: " . esc_attr( $base ) .";
	color: $base_text;
	border-bottom: 0;
	font-family:Arial;
	font-weight:bold;
	line-height:100%;
	vertical-align:middle;
";
$body_content = "
	background-color: " . esc_attr( $body ) . ";
";
$body_content_inner = "
	color: $text_lighter_20;
	font-family:Arial;
	font-size:14px;
	line-height:150%;
	text-align:left;
";
$header_content_h1 = "
	color: " . esc_attr( $base_text ) . ";
	margin:0;
	padding: 28px 24px;
	text-shadow: 0 1px 0 $base_lighter_20;
	display:block;
	font-family:Arial;
	font-size:30px;
	font-weight:bold;
	text-align:left;
	line-height: 150%;
";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo get_bloginfo( 'name' ); ?></title>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<div style="<?php echo $wrapper; ?>">
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tr>
                	<td align="center" valign="top">
						<div>
							<img src="" alt="Riverbend Gardens Fresh Veggies!" />
						</div>
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="<?php echo $template_container; ?>">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Body -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                    	<tr>
                                            <td valign="top" style="<?php echo $body_content; ?>">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div style="<?php echo $body_content_inner; ?>">
																<div>
																	<h3>CSA GIFT CERTIFICATE</h3>
																	<p>	<?php echo $coupon_code; ?></p>
																</div>
																<p><?php echo sprintf(__('This coupon code worth', 'wc_smart_coupons'), $smart_coupon_type, woocommerce_price($amount) ); ?> can be redeemed at: <a href="http://www.riverbendgardens.ca/csa">www.riverbendgardens.ca/csa</a></p>
																<p>The 2015 season will be available online for purchase in early January, 2015.</p>
																
																<?php echo $message_from_sender; ?>
																
																
																<?php if ( !empty( $from ) ) { ?>
																	<p><?php echo __( 'You got this gift card', 'wc_smart_coupons' ) . ' ' . $from . $sender; ?></p>
																<?php } ?>
																
																<div style="clear:both;"></div>
															</div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Footer -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                    	<tr>
                                        	<td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle">

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>