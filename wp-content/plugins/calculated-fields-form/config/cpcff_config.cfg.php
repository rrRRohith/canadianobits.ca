<?php
/**
 * Defines the plugin's constants and global variables
 */

// Calculated Fields Form constants and global variables
define( 'CP_CFF_PHPVERSION', phpversion() );
define( 'CP_SCHEME', ( is_ssl() ) ? 'https://' : 'http://' );
$GLOBALS['CP_CALCULATEDFIELDSF_DEFAULT_DEFER_SCRIPTS_LOADING'] = ( get_option( 'CP_CFF_LOAD_SCRIPTS', '1' ) == '1' ? true : false );
define( 'CP_CALCULATEDFIELDSF_USE_CACHE', 1 );
define( 'CP_CALCULATEDFIELDSF_DISABLE_REVISIONS', 0 );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_use_validation', 'true' );
define( 'CP_CALCULATEDFIELDSF_OPTIMIZATION_PLUGIN', 1 );

// Forms access:
define( 'CP_CALCULATEDFIELDSF_AMP', 1 );
define( 'CP_CALCULATEDFIELDSF_DIRECT_FORM_ACCESS', 1 );

// Thank you page cache control
define( 'CP_CALCULATEDFIELDSF_TYPC', 1 );

// Admin pages
define( 'CP_CALCULATED_FIELDS_SETTINGS_PAGE', 'cp_calculated_fields_form' );
define( 'CP_CALCULATED_FIELDS_SETTINGS_PAGE2', 'cp_calculated_fields_form_sub2' );
define( 'CP_CALCULATED_FIELDS_SETTINGS_PAGE3', 'cp_calculated_fields_form_sub3' );

define( 'CP_CALCULATEDFIELDSF_DEFAULT_template', get_option( 'CP_CALCULATEDFIELDSF_DEFAULT_template', 'cp_cff_13' ) );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_display_submit_button', get_option( 'CP_CALCULATEDFIELDSF_DEFAULT_display_submit_button', '' ) );

// Default forms
define( 'CP_CALCULATEDFIELDSF_DEFAULT_form_structure', '[[{"name":"fieldname2","index":0,"title":"Number","predefined":"5","ftype":"fnumber","userhelp":"","csslayout":"","required":false,"size":"medium","min":"","max":"","dformat":"digits","formats":["digits","number"]},{"name":"separator1","index":1,"title":"The field below will show the double of the number above.","userhelp":"","ftype":"fSectionBreak","csslayout":""},{"name":"fieldname1","index":2,"title":"Calculated Value","eq":"fieldname2*2","ftype":"fCalculated","userhelp":"","csslayout":"","predefined":"","required":false,"size":"medium","readonly":true}],[{"title":"Calculated Form","description":"Starting form. Basic calculated fields sample. ","formlayout":"top_aligned", "formtemplate": "' . esc_js( CP_CALCULATEDFIELDSF_DEFAULT_template ) . '"}]]' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_form_structure1', '[[{"name":"fieldname5","index":0,"title":"Simple Sum of two numbers","userhelp":"","ftype":"fSectionBreak","csslayout":""},{"name":"fieldname2","index":1,"title":"First Number","userhelp":"","dformat":"number","min":"","max":"","predefined":"3","ftype":"fnumber","csslayout":"","required":false,"size":"small","formats":["digits","number"]},{"name":"fieldname6","index":2,"title":"Second Number","predefined":"2","ftype":"fnumber","userhelp":"","csslayout":"","required":false,"size":"small","min":"","max":"","dformat":"digits","formats":["digits","number"]},{"name":"fieldname4","index":3,"readonly":true,"title":"Sum","predefined":"","userhelp":"Note: Sum of First Number + Second Number","eq":"fieldname2+fieldname6","ftype":"fCalculated","csslayout":"","required":false,"size":"medium"},{"name":"fieldname7","index":4,"title":"Sum of selected fields","userhelp":"","ftype":"fSectionBreak","csslayout":""},{"choices":["Item A: $10","Item B: $20","Item C: $40"],"choiceSelected":[true,true,false],"name":"fieldname8","index":5,"title":"Select/un-select some items","ftype":"fcheck","userhelp":"","csslayout":"","layout":"one_column","required":false},{"name":"fieldname9","index":6,"title":"Sum of selected items","eq":"fieldname8","ftype":"fCalculated","userhelp":"","csslayout":"","predefined":"","required":false,"size":"medium","readonly":false}],[{"title":"Simple Operations","description":"Below you can test two simple and frequent operations.","formlayout":"top_aligned", "formtemplate": "' . esc_js( CP_CALCULATEDFIELDSF_DEFAULT_template ) . '"}]]' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_form_structure2', '[[{"name":"fieldname1","index":0,"title":"Check-in","ftype":"fdate","userhelp":"","csslayout":"","predefined":"","size":"medium","required":false,"dformat":"mm/dd/yyyy","showDropdown":false,"dropdownRange":"-10:+10","formats":["mm/dd/yyyy","dd/mm/yyyy"]},{"name":"fieldname2","index":1,"title":"Check-out","ftype":"fdate","userhelp":"","csslayout":"","predefined":"","size":"medium","required":false,"dformat":"mm/dd/yyyy","showDropdown":false,"dropdownRange":"-10:+10","formats":["mm/dd/yyyy","dd/mm/yyyy"]},{"choices":["Parking - $10","Breakfast - $20","Premium Internet Access - $3"],"choiceSelected":[false,false,false],"name":"fieldname3","index":2,"title":"Optional Services","ftype":"fcheck","userhelp":"","csslayout":"","layout":"one_column","required":false,"choicesVal":["10","20","3"]},{"name":"fieldname4","index":3,"title":"","userhelp":"Note: The cost of the optional services are per each night.","ftype":"fSectionBreak","csslayout":""},{"name":"fieldname5","index":4,"title":"Total Cost","eq":"abs(fieldname2-fieldname1) * (fieldname3+50)","userhelp":"The formula is: (checkout - checkin) * (optionals + base rate)<br />Without the optional services the formula would be: (checkout-checkin) * base rate","ftype":"fCalculated","csslayout":"","predefined":"","required":false,"size":"medium","readonly":false}],[{"title":"Calculation with Dates","description":"The form below gives a quote for a stay in a hotel based in the check-in date, check-out date and some optional services. The base rate used is $50 per night.","formlayout":"top_aligned", "formtemplate": "' . esc_js( CP_CALCULATEDFIELDSF_DEFAULT_template ) . '"}]]' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_form_structure3', '[[{"name":"fieldname2","index":0,"title":"Height","userhelp":"In centimeters","dformat":"number","min":"30","max":"250","predefined":"180","ftype":"fnumber","csslayout":"","required":false,"size":"small","formats":["digits","number"]},{"choices":["Male","Female"],"name":"fieldname3","index":1,"choiceSelected":"Male","title":"Sex","ftype":"fdropdown","userhelp":"","csslayout":"","size":"medium","required":false},{"name":"fieldname5","index":2,"title":"Ideal Weight","userhelp":"Formula used:<br />Men: (height - 100)*0.90<br />Woman: (height - 100)*0.85","ftype":"fSectionBreak","csslayout":""},{"name":"fieldname4","index":3,"readonly":true,"title":"Ideal Weight","predefined":"","userhelp":"Note: Based in the above data and formula","eq":"(fieldname2-100)*(fieldname3==\'Male\'?0.90:0.85)","ftype":"fCalculated","csslayout":"","required":false,"size":"medium"}],[{"title":"Ideal Weight Calculator","description":"This sample uses a simple formula but with a conditional rule (if male or female).  The conditional expression is built using the JavaScript ternary operator. It\'s basically as follows: <em>condition ? value_if_true : value_if_false</em>.","formlayout":"top_aligned", "formtemplate": "' . esc_js( CP_CALCULATEDFIELDSF_DEFAULT_template ) . '"}]]' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_form_structure4', '[[{"name":"fieldname1","index":0,"title":"Enter the first day of last menstrual period","ftype":"fdate","userhelp":"","csslayout":"","predefined":"01/01/2013","size":"medium","required":false,"dformat":"mm/dd/yyyy","showDropdown":false,"dropdownRange":"-10:+10","formats":["mm/dd/yyyy","dd/mm/yyyy"]},{"name":"fieldname4","index":1,"title":"","userhelp":"Note: The dates below are approximate calculations. The real date may be slightly different.","ftype":"fSectionBreak","csslayout":""},{"name":"fieldname5","index":2,"title":"Conception Date","eq":"cdate(fieldname1+14)","userhelp":"","ftype":"fCalculated","csslayout":"","predefined":"","required":false,"size":"medium","readonly":false},{"name":"fieldname6","index":3,"title":"Due Date","eq":"cdate(fieldname1+40*7)","ftype":"fCalculated","userhelp":"","csslayout":"","predefined":"","required":false,"size":"medium","readonly":false}],[{"title":"Pregnancy Calculator","description":"The form below calculates the conception date and due date based in the first day of last menstrual period. The calculated values are converted to date again after the calculation.","formlayout":"top_aligned", "formtemplate": "' . esc_js( CP_CALCULATEDFIELDSF_DEFAULT_template ) . '"}]]' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_form_structure5', '[[{"name":"fieldname2","index":0,"title":"Loan Amount","userhelp":"","dformat":"number","min":"","max":"","predefined":"20000","ftype":"fnumber","csslayout":"","required":false,"size":"small","formats":["digits","number"]},{"name":"fieldname6","index":1,"title":"Residual Value","userhelp":"","predefined":"10000","ftype":"fnumber","csslayout":"","required":false,"size":"small","min":"","max":"","dformat":"number","formats":["digits","number"]},{"name":"fieldname7","index":2,"predefined":"7.5","title":"Interest Rate %","ftype":"fnumber","userhelp":"","csslayout":"","required":false,"size":"small","min":"","max":"","dformat":"number","formats":["digits","number"]},{"name":"fieldname8","index":3,"title":"Number of Months","dformat":"number","predefined":"36","ftype":"fnumber","userhelp":"","csslayout":"","required":false,"size":"small","min":"","max":"","formats":["digits","number"]},{"name":"fieldname5","index":4,"title":"","userhelp":"Results based in the data entered above:","ftype":"fSectionBreak","csslayout":""},{"name":"fieldname4","index":5,"readonly":true,"title":"Monthly Payment","predefined":"","userhelp":"","eq":"prec((fieldname2*fieldname7/1200*pow(1+fieldname7/1200,fieldname8)-fieldname6*fieldname7/1200)/(pow(1+fieldname7/1200,fieldname8)-1),2)","ftype":"fCalculated","csslayout":"","required":false,"size":"medium","dformat":"number"},{"name":"fieldname9","index":6,"title":"Total Payment","readonly":true,"eq":"prec(fieldname4*fieldname8,2)","ftype":"fCalculated","userhelp":"","csslayout":"","predefined":"","required":false,"size":"medium"},{"name":"fieldname10","index":7,"title":"Interest Amount","eq":"prec(fieldname6+fieldname9-fieldname2,2)","ftype":"fCalculated","userhelp":"","csslayout":"","predefined":"","required":false,"size":"medium","readonly":false}],[{"title":"Lease Calculator","description":"This sample uses a more complex formula for a lease calculator. It includes the \"power\" (pow) and \"precision\" (prec) functions.","formlayout":"top_aligned", "formtemplate": "' . esc_js( CP_CALCULATEDFIELDSF_DEFAULT_template ) . '"}]]' );

// Email constants
define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_subject', 'Contact from the blog...' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_inc_additional_info', 'true' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_return_page', CPCFF_AUXILIARY::site_url() . '/' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_message', "The following contact message has been sent:\n\n<%INFO%>\n\n" );

define( 'CP_CALCULATEDFIELDSF_DEFAULT_cu_enable_copy_to_user', 'true' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cu_user_email_field', '' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cu_subject', 'Confirmation: Message received...' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cu_message', "Thank you for your message. We will reply you as soon as possible.\n\nThis is a copy of the data sent:\n\n<%INFO%>\n\nBest Regards." );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_email_format', 'text' );

// Captcha constants
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_enable_captcha', get_option( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_enable_captcha', 'true' ) );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_width', '180' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_height', '60' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_chars', '5' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_font', 'font-1.ttf' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_min_font_size', '25' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_max_font_size', '35' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_noise', '200' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_noise_length', '4' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_background', 'ffffff' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_border', '000000' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_cv_text_enter_valid_captcha', 'Please enter a valid captcha code.' );

// Payments contstants
define( 'CP_CALCULATEDFIELDSF_DEFAULT_CURRENCY_SYMBOL', '$' );
define( 'CP_CALCULATEDFIELDSF_GBP_CURRENCY_SYMBOL', chr( 163 ) );
define( 'CP_CALCULATEDFIELDSF_EUR_CURRENCY_SYMBOL_A', 'EUR ' );
define( 'CP_CALCULATEDFIELDSF_EUR_CURRENCY_SYMBOL_B', chr( 128 ) );

// PayPal constants
define( 'CP_CALCULATEDFIELDSF_DEFAULT_ENABLE_PAYPAL', 1 );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_MODE', 'production' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_RECURRENT', '0' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_IDENTIFY_PRICES', '0' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_ZERO_PAYMENT', '0' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_EMAIL', 'put_your@email_here.com' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PRODUCT_NAME', 'Reservation' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_COST', '25' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_CURRENCY', 'USD' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_LANGUAGE', 'EN' );

// Database table names
global $wpdb;
define( 'CP_CALCULATEDFIELDSF_FORMS_TABLE', 'cp_calculated_fields_form_settings' );
define( 'CP_CALCULATEDFIELDSF_FORMS_REVISIONS_TABLE', 'cp_calculated_fields_form_revision' );
define( 'CP_CALCULATEDFIELDSF_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX', 'cp_calculated_fields_form_discount_codes' );
define( 'CP_CALCULATEDFIELDSF_DISCOUNT_CODES_TABLE_NAME', @$wpdb->prefix . 'cp_calculated_fields_form_discount_codes' );
define( 'CP_CALCULATEDFIELDSF_POSTS_TABLE_NAME_NO_PREFIX', 'cp_calculated_fields_form_posts' );
define( 'CP_CALCULATEDFIELDSF_POSTS_TABLE_NAME', @$wpdb->prefix . 'cp_calculated_fields_form_posts' );

// Default texts constants and global variables
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_is_required', 'This field is required.' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_is_email', 'Please enter a valid email address.' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_datemmddyyyy', 'Please enter a valid date with this format(mm/dd/yyyy)' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_dateddmmyyyy', 'Please enter a valid date with this format(dd/mm/yyyy)' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_number', 'Please enter a valid number.' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_digits', 'Please enter only digits.' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_max', 'Please enter a value less than or equal to {0}.' );
define( 'CP_CALCULATEDFIELDSF_DEFAULT_vs_text_min', 'Please enter a value greater than or equal to {0}.' );

global $cpcff_default_texts_array;
$cpcff_default_texts_array = array(
	'page_of_text'        => array(
		'label' => 'Page X of Y (text)',
		'text'  => 'Page {0} of {0}',
	),
	'audio_tutorial_text' => array(
		'label' => 'Audio tutorial (text)',
		'text'  => 'Help',
	),
	'errors'              => array(
		'currency'    => array(
			'label' => '"Invalid Currency" text',
			'text'  => 'Please enter a valid currency value.',
		),
		'maxlength'   => array(
			'label' => '"Max length/characters" text',
			'text'  => 'Please enter no more than {0} characters.',
		),
		'minlength'   => array(
			'label' => '"Min length/characters" text',
			'text'  => 'Please enter at least {0} characters.',
		),
		'equalTo'     => array(
			'label' => '"Equal to" text',
			'text'  => 'Please enter the same value again.',
		),
		'accept'      => array(
			'label' => '"Accept these file extensions" text',
			'text'  => 'Please enter a value with a valid extension.',
		),
		'upload_size' => array(
			'label' => '"Maximum upload size in kB" text',
			'text'  => 'The file you\'ve chosen is too big, maximum is {0} kB.',
		),
		'phone'       => array(
			'label' => '"Phone number" text',
			'text'  => 'Invalid phone number.',
		),
	),
);

add_action( 'init', 'cpcff_init_constants', 1 );
if ( ! function_exists( 'cpcff_init_constants' ) ) {
	function cpcff_init_constants() {
		$current_user_id = get_current_user_id();
		$host            = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
		preg_match( '/[^\.\/]+(\.[^\.\/]+)?$/', $host, $matches );
		$domain = ( ! empty( $matches ) ) ? $matches[0] : '';

		if ( ! empty( $current_user_id ) ) {
			// User emails
			if ( ! defined( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email' ) ) {
				$user_email = get_the_author_meta( 'user_email', $current_user_id );
				if ( empty( $user_email ) || ( $pos = strpos( $user_email, $domain ) ) === false ) {
					define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email', 'admin@' . $domain );
				} else {
					define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email', $user_email );
				}
			}

			if ( ! defined( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_destination_emails' ) ) {
				if ( ! isset( $user_email ) ) {
					$user_email = get_the_author_meta( 'user_email', $current_user_id );
				}
				define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_destination_emails', ( ! empty( $user_email ) ) ? $user_email : CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email );
			}
		} else {
			if ( ! defined( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email' ) ) {
				define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email', 'admin@' . $domain );
			}

			if ( ! defined( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_destination_emails' ) ) {
				define( 'CP_CALCULATEDFIELDSF_DEFAULT_fp_destination_emails', CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email );
			}
		}
	} // End cpcff_init_constants
}
