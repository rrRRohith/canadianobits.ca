<!-- Begin PayPal Donations by https://www.tipsandtricks-hq.com/paypal-donations-widgets-plugin -->
<?php
$url = isset($pd_options['sandbox']) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
?>

<form id="form_donation" action="<?php echo apply_filters('ancora_paypal_donations_url', $url); ?>" method="post"<?php
if (isset($pd_options['new_tab'])) {
        echo ' target="_blank"';
}
?>>
    <div class="ancora-paypal-donations">
        <input type="hidden" name="cmd" value="_donations" />
        <input type="hidden" name="bn" value="TipsandTricks_SP" />
        <input type="hidden" name="business" value="<?php echo $pd_options['paypal_account']; ?>" />
<?php
        # Build the button
        $paypal_btn = '';
        $indent = str_repeat(" ", 8);

        // Optional Settings
        if ($pd_options['page_style'])
            $paypal_btn .=  $indent.'<input type="hidden" name="page_style" value="' .$pd_options['page_style']. '" />'.PHP_EOL;
        if ($return_page)
            $paypal_btn .=  $indent.'<input type="hidden" name="return" value="' .$return_page. '" />'.PHP_EOL; // Return Page
        if ($purpose)
            $paypal_btn .=  $indent.'<input type="text" name="item_name" placeholder="' .$purpose. '" />'.PHP_EOL;  // Purpose
        if ($reference)
            $paypal_btn .=  $indent.'<input type="text" name="item_number" placeholder="' .$reference. '" />'.PHP_EOL;  // LightWave Plugin
        if ($amount)
            $paypal_btn .=  $indent.'<input type="text" name="amount" placeholder="' . $amount . '" />'.PHP_EOL;

        // More Settings
        if (isset($pd_options['return_method']))
            $paypal_btn .= $indent.'<input type="hidden" name="rm" value="' .$pd_options['return_method']. '" />'.PHP_EOL;
        if (isset($pd_options['currency_code']))
            $paypal_btn .= $indent.'<input type="hidden" name="currency_code" value="' .$pd_options['currency_code']. '" />'.PHP_EOL;
        if (isset($pd_options['button_localized']))
            { $button_localized = $pd_options['button_localized']; } else { $button_localized = 'en_US'; }
        if (isset($pd_options['set_checkout_language']) and $pd_options['set_checkout_language'] == true)
            $paypal_btn .= $indent.'<input type="hidden" name="lc" value="' .$pd_options['checkout_language']. '" />'.PHP_EOL;

        // Settings not implemented yet
        //      $paypal_btn .=     '<input type="hidden" name="amount" value="20" />';

        // Get the button URL
        if ( $pd_options['button'] != "custom" && !$button_url)
            $paypal_btn .=  $indent.'<div class="ancora_button"><button type="submit" form="form_donation" name="submit" class="button-hover" data-text="Make a Donation" value="Make a Donation">Make a Donation</button></div>'.PHP_EOL;

        // PayPal stats tracking
        if (!isset($pd_options['disable_stats']) or $pd_options['disable_stats'] != true)
            $paypal_btn .=  $indent.'<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />'.PHP_EOL;
        echo $paypal_btn;
?>
    </div>
</form>
<!-- End PayPal Donations -->
