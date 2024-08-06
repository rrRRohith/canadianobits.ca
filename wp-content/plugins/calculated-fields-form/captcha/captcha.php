<?php
/*
PHP Captcha by Codepeople.net
http://www.codepeople.net
*/

if ( ! defined( 'WP_DEBUG' ) || true != WP_DEBUG ) {
	error_reporting( E_ERROR | E_PARSE );
}

if ( ! ini_get( 'zlib.output_compression' ) ) {
	ob_clean();
}

if ( ! function_exists( 'cff_captcha_sanitize_key' ) ) {
	function cff_captcha_sanitize_key( $key ) {
		$key = strtolower( $key );
		$key = preg_replace( '/[^a-z0-9_\-]/', '', $key );
		return $key;
	}
}

if ( ! function_exists( 'sanitize_text_field' ) ) {
	function sanitize_text_field( $v ) {
		return strip_tags( $v );
	}
}

if ( ! function_exists( 'wp_unslash' ) ) {
	function wp_unslash( $v ) {
		return stripcslashes( $v );
	}
}

if ( ! class_exists( 'CP_SESSION' ) && session_id() == '' ) {
	session_start();
}

$_ps = isset( $_GET['ps'] ) ? cff_captcha_sanitize_key( sanitize_text_field( wp_unslash( $_GET['ps'] ) ) ) : '';

if ( isset( $_GET['hdwtest'] ) && 'sessiontest' == $_GET['hdwtest'] ) {
	if ( ! isset( $_GET['autocall'] ) || 1 != $_GET['autocall'] ) {
		if ( class_exists( 'CP_SESSION' ) ) {
			CP_SESSION::set_var( 'tmpvar', 'ok' );
		} else {
			$_SESSION['tmpvar'] = 'ok';
		}
	} else {
		if (
			( class_exists( 'CP_SESSION' ) && CP_SESSION::get_var( 'tmpvar' ) != 'ok' ) ||
			( ! class_exists( 'CP_SESSION' ) && empty( $_SESSION['tmpvar'] ) )
		) {
			die( 'Session Error' );
		} else {
			die( 'Sessions works on your server!' );
		}
	}

	$current_url  = ( ! empty( $_SERVER['REQUEST_URI'] ) ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ( ! empty( $_SERVER['PATH_INFO'] ) ? sanitize_text_field( wp_unslash( $_SERVER['PATH_INFO'] ) ) : '' );
	$current_url .= ( ( strpos( $current_url, '?' ) === false ) ? '?' : '&' ) . 'hdwtest=sessiontest&autocall=1';
	header( 'Location: ' . $current_url );
	exit;
}

// configuration
$imgX = ( ! empty( $_GET['width'] ) && is_numeric( $_GET['width'] ) ) ? intval( $_GET['width'] ) : 180;
$imgY = ( ! empty( $_GET['height'] ) && is_numeric( $_GET['height'] ) ) ? intval( $_GET['height'] ) : 60;

$letter_count = ( ! empty( $_GET['letter_count'] ) && is_numeric( $_GET['letter_count'] ) ) ? intval( $_GET['letter_count'] ) : 5;
$min_size     = ( ! empty( $_GET['min_size'] ) && is_numeric( $_GET['min_size'] ) ) ? floatval( $_GET['min_size'] ) : 35;
$max_size     = ( ! empty( $_GET['max_size'] ) && is_numeric( $_GET['max_size'] ) ) ? floatval( $_GET['max_size'] ) : 45;
$noise        = ( ! empty( $_GET['noise'] ) && is_numeric( $_GET['noise'] ) ) ? intval( $_GET['noise'] ) : 200;
$noiselength  = ( ! empty( $_GET['noiselength'] ) && is_numeric( $_GET['noiselength'] ) ) ? intval( $_GET['noiselength'] ) : 5;
$bcolor       = cpcff_decodeColor( ! empty( $_GET['bcolor'] ) ? sanitize_text_field( wp_unslash( $_GET['bcolor'] ) ) : 'FFFFFF' );
$border       = cpcff_decodeColor( ! empty( $_GET['border'] ) ? sanitize_text_field( wp_unslash( $_GET['border'] ) ) : '000000' );

$noisecolor         = 0xcdcdcd;
$random_noise_color = true;
$tcolor             = cpcff_decodeColor( '666666' );
$random_text_color  = true;

header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Pragma: no-cache' );

function cpcff_decodeColor( $hexcolor ) {
	$color  = hexdec( $hexcolor );
	$c['b'] = $color % 256;
	$color  = $color / 256;
	$c['g'] = $color % 256;
	$color  = $color / 256;
	$c['r'] = $color % 256;
	return $c;
}

function cpcff_similarColors( $c1, $c2 ) {
	return sqrt( pow( $c1['r'] - $c2['r'], 2 ) + pow( $c1['g'] - $c2['g'], 2 ) + pow( $c1['b'] - $c2['b'], 2 ) ) < 125;
}

function cpcff_make_seed() {
	list($usec, $sec) = explode( ' ', microtime() );
	return (float) $sec + ( (float) $usec * 100000 );
}
mt_srand( cpcff_make_seed() );
$randval = mt_rand();

$str    = '';
$length = 0;
for ( $i = 0; $i < $letter_count; $i++ ) {
	 $str .= chr( mt_rand( 97, 122 ) ) . ' ';
}

if ( class_exists( 'CP_SESSION' ) ) {
	CP_SESSION::set_var( 'rand_code' . $_ps, str_replace( ' ', '', $str ) );
} else {
	$_SESSION[ 'rand_code' . $_ps ] = str_replace( ' ', '', $str );
}

$image      = imagecreatetruecolor( $imgX, $imgY );
$backgr_col = imagecolorallocate( $image, $bcolor['r'], $bcolor['g'], $bcolor['b'] );
$border_col = imagecolorallocate( $image, $border['r'], $border['g'], $border['b'] );

if ( $random_text_color ) {
	do {
		$selcolor = mt_rand( 0, 256 * 256 * 256 );
	} while ( cpcff_similarColors( cpcff_decodeColor( $selcolor ), $bcolor ) );
	$tcolor = cpcff_decodeColor( $selcolor );
}

$text_col = imagecolorallocate( $image, $tcolor['r'], $tcolor['g'], $tcolor['b'] );

imagefilledrectangle( $image, 0, 0, $imgX, $imgY, $backgr_col );
imagerectangle( $image, 0, 0, $imgX - 1, $imgY - 1, $border_col );
for ( $i = 0;$i < $noise;$i++ ) {
	if ( $random_noise_color ) {
		$color = mt_rand( 0, 256 * 256 * 256 );
	} else {
		$color = $noisecolor;
	}
	$x1 = mt_rand( 2, $imgX - 2 );
	$y1 = mt_rand( 2, $imgY - 2 );
	imageline( $image, $x1, $y1, mt_rand( $x1 - $noiselength, $x1 + $noiselength ), mt_rand( $y1 - $noiselength, $y1 + $noiselength ), $color );
}

$selected_font = 'font-1.ttf';
if ( isset( $_GET['font'] ) ) {
	switch ( $_GET['font'] ) {
		case 'font-2.ttf':
			$selected_font = 'font-2.ttf';
			break;
		case 'font-3.ttf':
			$selected_font = 'font-3.ttf';
			break;
		case 'font-4.ttf':
			$selected_font = 'font-4.ttf';
			break;
	}
}

$font = dirname( __FILE__ ) . '/' . $selected_font; // font

// Removed @2x, the patch fixes an issue caused by other plugin that includes the @2x in the name of font files.
$font = str_replace( array( '\\', '@2x' ), array( '/', '' ), $font );

$font_size = rand( $min_size, $max_size );

$angle = rand( -15, 15 );

if ( function_exists( 'imagettfbbox' ) && function_exists( 'imagettftext' ) ) {
	$box = imagettfbbox( $font_size, $angle, $font, $str );
	$x   = (int) ( $imgX - $box[4] ) / 2;
	$y   = (int) ( $imgY - $box[5] ) / 2;
	imagettftext( $image, $font_size, $angle, $x, $y, $text_col, $font, $str );
} elseif ( function_exists( 'imageFtBBox' ) && function_exists( 'imageFTText' ) ) {
	$box = imageFtBBox( $font_size, $angle, $font, $str );
	$x   = (int) ( $imgX - $box[4] ) / 2;
	$y   = (int) ( $imgY - $box[5] ) / 2;
	imageFTText( $image, $font_size, $angle, $x, $y, $text_col, $font, $str );
} else {
	$angle = 0;
	$font  = 6;
	$wf    = ImageFontWidth( 6 ) * strlen( $str );
	$hf    = ImageFontHeight( 6 );
	$x     = (int) ( $imgX - $wf ) / 2;
	$y     = (int) ( $imgY - $hf ) / 2;
	imagestring( $image, $font, $x, $y, $str, $text_col );
}

header( 'Content-type: image/png' );
imagepng( $image );
imagedestroy( $image );
exit;
