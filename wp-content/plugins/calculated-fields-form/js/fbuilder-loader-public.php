<?php
global $cff_backend_script_generator, $cff_script_generator_min;

error_reporting( E_ERROR | E_PARSE );

if ( empty( $cff_backend_script_generator ) ) {
	header( 'Content-Type: application/x-javascript; charset=UTF-8' );
}

ob_start(); // Turn on output buffering
?>
fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery(window).bind( 'pageshow', function( event ){ if( typeof event.originalEvent[ 'persisted' ] != 'undefined' && event.originalEvent[ 'persisted' ] ) location.reload(); } );
fbuilderjQuery.fbuilderjQueryGenerator = function(){
	(function($) {
		// Namespace of fbuilder
		if(!('fbuilder' in $))
		{
			$.fbuilder = $.fbuilder || {};
			$.fbuilder[ 'objName' ] = 'fbuilderjQuery';

<?php
	// Load Module files
try {
	$md            = dir( dirname( __FILE__ ) . '/modules' );
	$modules_files = array();
	while ( false !== ( $entry = $md->read() ) ) {
		if ( strlen( $entry ) > 3 && is_dir( $md->path . '/' . $entry ) ) {
			if ( file_exists( $md->path . '/' . $entry . '/public' ) ) {
				$m = dir( $md->path . '/' . $entry . '/public' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
				while ( false !== ( $mentry = $m->read() ) ) {
					if ( strlen( $mentry ) > 3 && strtolower( substr( $mentry, strlen( $mentry ) - 3 ) ) == '.js' ) {
						$modules_files[] = $m->path . '/' . $mentry;
					}
				}
			}
		}
	}
	sort( $modules_files );
	foreach ( $modules_files as $file ) {
		require $file;
	}
} catch ( Exception $e ) {
	error_log( $e->getMessage() );
}

	// Load Control files
	require 'fbuilder-pro-public.jquery.js';
try {
	$d              = dir( dirname( __FILE__ ) . '/fields-public' );
	$controls_files = array();
	while ( false !== ( $entry = $d->read() ) ) {
		if ( strlen( $entry ) > 3 && strtolower( substr( $entry, strlen( $entry ) - 3 ) ) == '.js' ) {
			if ( file_exists( $d->path . '/' . $entry ) ) {
				$controls_files[] = $d->path . '/' . $entry;
			}
		}
	}
	sort( $controls_files );
	foreach ( $controls_files as $file ) {
		require $file;
	}

	do_action( 'cpcff_load_controls_public' );
} catch ( Exception $e ) {
	error_log( $e->getMessage() );
}
?>
			$.fbuilder.generate_form = function(fnum){
				try {
					var cp_calculatedfieldsf_fbuilder_config = window["cp_calculatedfieldsf_fbuilder_config"+fnum];
					if(
						cp_calculatedfieldsf_fbuilder_config &&
						$("#fbuilder"+fnum).length &&
						$("#fbuilder"+fnum).attr('data-processed') == undefined
					)
					{
						if($("#fbuilder"+fnum).is(':visible'))
						{
							var f = $("#fbuilder"+fnum).fbuilder(( typeof cp_calculatedfieldsf_fbuilder_config.obj == 'string' ) ?  $.parseJSON(cp_calculatedfieldsf_fbuilder_config.obj) : cp_calculatedfieldsf_fbuilder_config.obj );
							f.attr('data-processed', 1);
							f.fBuild.loadData("form_structure"+fnum);
						}
						else
						{
							$.fbuilder.form_become_visible(
								"#fbuilder"+fnum,
								(function(n){ return function(){
									$.fbuilder.generate_form(n);};
								})(fnum)
							);
						}
					}
				} catch (e) {if(typeof console != 'undefined') console.log(e);}
			}; // End generate_form

			$.fbuilder.form_become_visible = function(element, callback){
				if(!('hidden_forms' in $.fbuilder)) $.fbuilder.hidden_forms = [];
				$.fbuilder.hidden_forms.push({'element':element, 'callback':callback});

				if('form_become_visible_interval' in $.fbuilder) clearInterval($.fbuilder['form_become_visible_interval']);

				$.fbuilder['form_become_visible_interval'] = setInterval(function(){
					for(var i = $.fbuilder.hidden_forms.length - 1; 0<=i; i--)
					{
						if($($.fbuilder.hidden_forms[i]['element']).is(':visible'))
						{
							$.fbuilder.hidden_forms[i]['callback'].call();
							$.fbuilder.hidden_forms.splice(i,1);
						}
					}
					if($.fbuilder.hidden_forms.length == 0) clearInterval($.fbuilder['form_become_visible_interval']);
				}, 500);
			}; // End form_become_visible

		} // End if(!('fbuilder' in $))

		var fcount = 1;
		var fnum = "_"+fcount;

		while(typeof window["cp_calculatedfieldsf_fbuilder_config"+fnum] != 'undefined' || fcount < 10 )
		{
			$.fbuilder.generate_form(fnum);
			fcount++;
			fnum = "_"+fcount;
		}
	})(fbuilderjQuery);
};
fbuilderjQuery(fbuilderjQuery.fbuilderjQueryGenerator);
fbuilderjQuery(window).on('load',fbuilderjQuery.fbuilderjQueryGenerator);

/* Elementor popup*/
fbuilderjQuery( document ).on( 'elementor/popup/show', function( event, id, instance ){
	var popup = fbuilderjQuery('[data-elementor-type="popup"]');
	if(popup.length){
		var psequence = fbuilderjQuery('[name="cp_calculatedfieldsf_pform_psequence"]'),
			fnum,flist;
		if(psequence.length){
			fnum = psequence.val();
			if(popup.find('#fieldlist'+fnum+':empty').length) {
				popup.find("#fbuilder"+fnum).removeAttr('data-processed');
				fbuilderjQuery.fbuilderjQueryGenerator();
			}
		}
	}
} );
<?php
	$buffered_contents = ob_get_contents();
	ob_end_clean(); // Clean the output buffer and turn off output buffering
if ( ! empty( $_REQUEST['min'] ) || ! empty( $cff_script_generator_min ) ) {
	if ( ! class_exists( 'JSMin' ) ) {
		require_once rtrim( dirname( __FILE__ ), '/' ) . '/JSMin.php';
	}

	try {
		$buffered_contents = JSMin::minify( $buffered_contents );
	} catch ( Exception $err ) {
		error_log( $err->getMessage() );
	}
}

try {
	$all_js_path = rtrim( dirname( __FILE__ ), '/' ) . '/cache/all.js';
	@file_put_contents( $all_js_path, $buffered_contents );
} catch ( Exception $err ) {
	error_log( $err->getMessage() );
}

if ( empty( $cff_backend_script_generator ) ) {
	print $buffered_contents; // phpcs:ignore WordPress.Security.EscapeOutput
}
