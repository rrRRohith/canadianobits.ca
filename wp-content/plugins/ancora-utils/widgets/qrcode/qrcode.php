<?php

/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'ancora_widget_qrcode_load' );

/**
 * Register our widget.
 */
function ancora_widget_qrcode_load() {
	register_widget('ancora_widget_qrcode');
}

/**
 * QRCode Widget class.
 */
class ancora_widget_qrcode extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_qrcode', 'description' => __('Generate QRCode with your personal data or with any text (links)', 'ancora-utils'));

		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'ancora_widget_qrcode');

		/* Create the widget. */
		parent::__construct( 'ancora_widget_qrcode', __('Ancora - QRCode generator', 'ancora-utils'), $widget_ops, $control_ops );

		// Load required styles and scripts for Options Page
		add_action("admin_enqueue_scripts",	array($this, 'load_scripts'));
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {

		extract($args);

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title']);
		$ulname = $instance['ulname'];
		$ufname = $instance['ufname'];
		$ucompany = $instance['ucompany'];
		$uphone = $instance['uphone'];
		//$ufax = $instance['ufax'];
		$uaddr = $instance['uaddr'];
		$ucity = $instance['ucity'];
		$upostcode = $instance['upostcode'];
		$ucountry = $instance['ucountry'];
		$uemail = $instance['uemail'];
		$usite = $instance['usite'];
		//$unote = $instance['unote'];
		//$ucats = $instance['ucats'];
		$urev = $instance['urev'];
		$uid = $instance['uid'];
		$show_personal = $instance['show_personal'];
		$show_what = $instance['show_what'];
		$text = $instance['text'];
		$width = $instance['width'];
		$color = $instance['color'];
		$bg = $instance['bg'];
		$image = $instance['image'];
		
		$output = '';
		
		if ($title) 	$output .= ($before_title) . ($title) . ($after_title);
		
		$output .= '
				<div class="widget_inner' . ($show_personal ? ' with_personal_data' : '') . '">
					<div class="qrcode"><img src="' . ($image) . '" alt="" /></div>
					';
		if ($show_personal) 
			$output .= '
					<div class="personal_data">
					' . ($show_what==1 
						? '<p class="user_name odd first"><span class="theme_text">' . __('Name:', 'ancora-utils') . '</span> <span class="theme_info">' . ($ufname) . ' ' . ($ulname) . '<span></p>'
							. ($ucompany ? '<p class="user_company even"><span class="theme_text">' . __('Company:', 'ancora-utils') . '</span> <span class="theme_info">' . ($ucompany) . '<span></p>' : '')
							. ($uphone ? '<p class="user_phone odd"><span class="theme_text">' . __('Phone:', 'ancora-utils') . '</span> <span class="theme_info">' . ($uphone) . '<span></p>' : '')
							. ($uemail ? '<p class="user_email even"><span class="theme_text">' . __('E-mail:', 'ancora-utils') . '</span> <a href="' . esc_url('mailto:'.($uemail)) . '">' . ($uemail) . '</a></p>' : '')
							. ($usite ? '<p class="user_site odd"><span class="theme_text">' . __('Site:', 'ancora-utils') . '</span> <a href="' . esc_url($usite) . '" target="_blank">' . ($usite) . '</a></p>' : '')
						: $text)
						. '
					</div>
					';
		$output .= '
				</div>';

		/* Before widget (defined by themes). */
		echo ($before_widget);
	
		echo ($output);
			
		/* After widget (defined by themes). */
		echo ($after_widget);
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ulname'] = strip_tags($new_instance['ulname']);
		$instance['ufname'] = strip_tags($new_instance['ufname']);
		$instance['utitle'] = strip_tags($new_instance['utitle']);
		$instance['ucompany'] = strip_tags($new_instance['ucompany']);
		$instance['uphone'] = strip_tags($new_instance['uphone']);
		//$instance['ufax'] = strip_tags($new_instance['ufax']);
		$instance['uaddr'] = strip_tags($new_instance['uaddr']);
		$instance['ucity'] = strip_tags($new_instance['ucity']);
		$instance['upostcode'] = strip_tags($new_instance['upostcode']);
		$instance['ucountry'] = strip_tags($new_instance['ucountry']);
		$instance['uemail'] = strip_tags($new_instance['uemail']);
		$instance['usite'] = strip_tags($new_instance['usite']);
		//$instance['unote'] = strip_tags($new_instance['unote']);
		//$instance['ucats'] = strip_tags($new_instance['ucats']);
		$instance['uid'] = strip_tags($new_instance['uid']);
		$instance['urev'] = date('Y-m-d');
		$instance['show_personal'] = isset($new_instance['show_personal']) ? 1 : 0;
		$instance['show_what'] = $new_instance['show_what'];
		$instance['auto_draw'] = isset($new_instance['auto_draw']) ? 1 : 0;
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['color'] = strip_tags($new_instance['color']);
		$instance['bg'] = strip_tags($new_instance['bg']);
		$instance['image'] = strip_tags($new_instance['image']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {
		
		/* Widget admin side css */
		wp_enqueue_style( 'widget-qrcode-style',  trx_utils_get_file_url('widgets/qrcode/qrcode-admin.css'), array(), null );
		wp_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
		wp_enqueue_script('widget-qrcode-script', trx_utils_get_file_url('widgets/qrcode/jquery.qrcode-0.6.0.min.js'), array(), null, false);

		/* Set up some default widget settings. */
		$address = explode(',', ancora_get_theme_option('user_address'));
		$defaults = array(
			'title' => '', 
			'description' => __('QR Code Generator (for your vcard)', 'ancora-utils'),
			'ulname' => '', 
			'ufname' => '', 
			'ucompany' => '', 
			'uaddr' => '', 
			'ucity' => '', 
			'upostcode' => '', 
			'ucountry' => '', 
			'uemail' => '', 
			'usite' => '', 
			'uphone' => '', 
			//'ufax' => '', 
			//'unote' => '', 
			//'ucats' => '', 
			'uid' => md5(microtime()), 
			'urev' => date('Y-m-d'),
			'image' => '', 
			'show_personal' => 0,
			'show_what' => 1,
			'auto_draw' => 0,
			'width' => 160,
			'text' => '',
			'color' => '#000000',
			'bg' => ''
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<div class="widget_qrcode">
        	<div class="qrcode_tabs">
                <ul class="tabs">
                    <li class="first"><a href="#tab_settings"><?php _e('Settings', 'ancora-utils'); ?></a></li>
                    <li><a href="#tab_fields" onmousedown="ancora_qrcode_init()"><?php _e('Personal Data', 'ancora-utils'); ?></a></li>
                    <li><a href="#tab_text" onmousedown="ancora_qrcode_init()"><?php _e('Any Text', 'ancora-utils'); ?></a></li>
                </ul>
                <div id="tab_settings" class="tab_content tab_settings">
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'ancora-utils'); ?></label>
                        <input class="fld_title" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
                    </p>
                    <p>
                        <label><?php _e('Show as QR Code:', 'ancora-utils'); ?></label><br />
                        <input class="fld_show_what" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('show_what')); ?>_1" name="<?php echo esc_attr($this->get_field_name('show_what')); ?>" value="1" type="radio" <?php echo ($instance['show_what']==1 ? 'checked="checked"' : ''); ?> />
                        <label for="<?php echo esc_attr($this->get_field_id('show_what')); ?>_1"> <?php _e('Personal VCard', 'ancora-utils'); ?></label>
                        <input class="fld_show_what" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('show_what')); ?>_0" name="<?php echo esc_attr($this->get_field_name('show_what')); ?>" value="0" type="radio" <?php echo ($instance['show_what']==0 ? 'checked="checked"' : ''); ?> />
                        <label for="<?php echo esc_attr($this->get_field_id('show_what')); ?>_0"> <?php _e('Any text', 'ancora-utils'); ?></label>
                    </p>
                    <p>
                        <input class="fld_show_personal" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('show_personal')); ?>" name="<?php echo esc_attr($this->get_field_name('show_personal')); ?>" value="1" type="checkbox" <?php echo ($instance['show_personal']==1 ? 'checked="checked"' : ''); ?> />
                        <label for="<?php echo esc_attr($this->get_field_id('show_personal')); ?>"><?php _e('Show data under QR Code:', 'ancora-utils'); ?></label>
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php _e('Width:', 'ancora-utils'); ?></label>
                        <input onmousedown="ancora_qrcode_init()" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('width')); ?>" name="<?php echo esc_attr($this->get_field_name('width')); ?>" value="<?php echo esc_attr($instance['width']); ?>" style="width:100%;" class="fld_width" />
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('color')); ?>"><?php _e('Color:', 'ancora-utils'); ?></label>
                        <input onmousedown="ancora_qrcode_init()" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('color')); ?>" name="<?php echo esc_attr($this->get_field_name('color')); ?>" value="<?php echo esc_attr($instance['color']); ?>" style="width:100%; background-color:<?php echo esc_attr($instance['color']); ?>" class="iColorPicker fld_color" />
                    </p>
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('bg')); ?>"><?php _e('Bg color:', 'ancora-utils'); ?></label>
                        <input onmousedown="ancora_qrcode_init()" onfocus="ancora_qrcode_init()" id="<?php echo esc_attr($this->get_field_id('bg')); ?>" name="<?php echo esc_attr($this->get_field_name('bg')); ?>" value="<?php echo esc_attr($instance['bg']); ?>" style="width:100%; background-color:<?php echo esc_attr($instance['bg']); ?>" class="iColorPicker fld_bg" />
                    </p>
                </div>
                <div id="tab_fields" class="tab_content tab_personal">
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('ulname')); ?>"><?php _e('Last name:', 'ancora-utils'); ?></label>
                        <input class="fld_ulname" id="<?php echo esc_attr($this->get_field_id('ulname')); ?>" name="<?php echo esc_attr($this->get_field_name('ulname')); ?>" value="<?php echo esc_attr($instance['ulname']); ?>" style="width:100%;" />
                    </p>
                    
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('ufname')); ?>"><?php _e('First name:', 'ancora-utils'); ?></label>
                        <input class="fld_ufname" id="<?php echo esc_attr($this->get_field_id('ufname')); ?>" name="<?php echo esc_attr($this->get_field_name('ufname')); ?>" value="<?php echo esc_attr($instance['ufname']); ?>" style="width:100%;" />
                    </p>
                    
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('ucompany')); ?>"><?php _e('Company:', 'ancora-utils'); ?></label>
                        <input class="fld_ucompany" id="<?php echo esc_attr($this->get_field_id('ucompany')); ?>" name="<?php echo esc_attr($this->get_field_name('ucompany')); ?>" value="<?php echo esc_attr($instance['ucompany']); ?>" style="width:100%;" />
                    </p>
                    
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('uphone')); ?>"><?php _e('Phone:', 'ancora-utils'); ?></label>
                        <input class="fld_uphone" id="<?php echo esc_attr($this->get_field_id('uphone')); ?>" name="<?php echo esc_attr($this->get_field_name('uphone')); ?>" value="<?php echo esc_attr($instance['uphone']); ?>" style="width:100%;" />
                    </p>
           
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('uaddr')); ?>"><?php _e('Address:', 'ancora-utils'); ?></label>
                        <input class="fld_uaddr" id="<?php echo esc_attr($this->get_field_id('uaddr')); ?>" name="<?php echo esc_attr($this->get_field_name('uaddr')); ?>" value="<?php echo esc_attr($instance['uaddr']); ?>" style="width:100%;" />
                    </p>
                    
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('ucity')); ?>"><?php _e('City:', 'ancora-utils'); ?></label>
                        <input class="fld_ucity" id="<?php echo esc_attr($this->get_field_id('ucity')); ?>" name="<?php echo esc_attr($this->get_field_name('ucity')); ?>" value="<?php echo esc_attr($instance['ucity']); ?>" style="width:100%;" />
                    </p>
                    
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('upostcode')); ?>"><?php _e('Post code:', 'ancora-utils'); ?></label>
                        <input class="fld_upostcode" id="<?php echo esc_attr($this->get_field_id('upostcode')); ?>" name="<?php echo esc_attr($this->get_field_name('upostcode')); ?>" value="<?php echo esc_attr($instance['upostcode']); ?>" style="width:100%;" />
                    </p>
                    
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('ucountry')); ?>"><?php _e('Country:', 'ancora-utils'); ?></label>
                        <input class="fld_ucountry" id="<?php echo esc_attr($this->get_field_id('ucountry')); ?>" name="<?php echo esc_attr($this->get_field_name('ucountry')); ?>" value="<?php echo esc_attr($instance['ucountry']); ?>" style="width:100%;" />
                    </p>
            
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('uemail')); ?>"><?php _e('E-mail:', 'ancora-utils'); ?></label>
                        <input class="fld_uemail" id="<?php echo esc_attr($this->get_field_id('uemail')); ?>" name="<?php echo esc_attr($this->get_field_name('uemail')); ?>" value="<?php echo esc_attr($instance['uemail']); ?>" style="width:100%;" />
                    </p>
            
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('usite')); ?>"><?php _e('Web Site URL:', 'ancora-utils'); ?></label>
                        <input class="fld_usite" id="<?php echo esc_attr($this->get_field_id('usite')); ?>" name="<?php echo esc_attr($this->get_field_name('usite')); ?>" value="<?php echo esc_attr($instance['usite']); ?>" style="width:100%;" />
                    </p>
				</div>
                <div id="tab_text" class="tab_content tab_text">
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('fld_text')); ?>"><?php _e('Text to show as QR Code:', 'ancora-utils'); ?></label>
                        <textarea class="fld_text" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>" style="width:100%;"><?php echo esc_html($instance['text']); ?></textarea>
                    </p>
				</div>
                    
            </div>            
            <input class="fld_uid" id="<?php echo esc_attr($this->get_field_id('uid')); ?>" name="<?php echo esc_attr($this->get_field_name('uid')); ?>" value="<?php echo esc_attr($instance['uid']); ?>" type="hidden" />
            <input class="fld_urev" id="<?php echo esc_attr($this->get_field_id('urev')); ?>" name="<?php echo esc_attr($this->get_field_name('urev')); ?>" value="<?php echo esc_attr($instance['urev']); ?>" type="hidden" />
    
            <p>
                <input class="fld_button_draw" id="<?php echo esc_attr($this->get_field_id('button_draw')); ?>" name="<?php echo esc_attr($this->get_field_name('button_draw')); ?>" value="<?php echo esc_attr(__('Update', 'ancora-utils')); ?>" type="button" />
                <input class="fld_auto_draw" id="<?php echo esc_attr($this->get_field_id('auto_draw')); ?>" name="<?php echo esc_attr($this->get_field_name('auto_draw')); ?>" value="1" type="checkbox" <?php echo ($instance['auto_draw']==1 ? 'checked="checked"' : ''); ?> />
                <label for="<?php echo esc_attr($this->get_field_id('auto_draw')); ?>"> <?php _e('Auto', 'ancora-utils'); ?></label>
            </p>
            <input class="fld_image" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="" type="hidden" />
            <div id="<?php echo esc_attr($this->get_field_id('qrcode_image')); ?>" class="qrcode_image"><img src="<?php echo ($instance['image']); ?>" alt="" /></div>
            <div id="<?php echo esc_attr($this->get_field_id('qrcode_data')); ?>" class="qrcode_data">
<?php if ($instance['show_personal']==1) { ?>
                <ul>
				<?php if ($instance['show_what']==1) { ?>
                    <li class="user_name odd first"><?php echo  __('Name:', 'ancora-utils') . ' ' . ($instance['ufname']) . ' ' . ($instance['ulname']); ?></li>
                    <?php 
						echo  ($instance['ucompany'] ? '<li class="user_company even">' . __('Company:', 'ancora-utils') . ' ' . ($instance['ucompany']) . '</li>' : '')
							. ($instance['uphone'] ? '<li class="user_phone odd">' . __('Phone:', 'ancora-utils') . ' ' . ($instance['uphone']) . '</li>' : '')
							. ($instance['uemail'] ? '<li class="user_email even">' . __('E-mail:', 'ancora-utils') . ' ' . '<a href="' . esc_url('mailto:'.($instance['uemail'])) . '">' . ($instance['uemail']) . '</a></li>' : '')
							. ($instance['usite'] ? '<li class="user_site odd">' . __('Site:', 'ancora-utils') . ' ' . '<a href="' . esc_url($instance['usite']) . '" target="_blank">' . ($instance['usite']) . '</a></li>' : '');
					?>
				<?php } else { ?>
                    <li class="text odd first"><?php echo ($instance['text']); ?></li>
				<?php } ?>
                </ul>
<?php } ?>
            </div>
		</div>

        <script type="text/javascript">
            jQuery(document).ready(function(){
				ancora_qrcode_init();
				ancora_color_picker();
            });
			function ancora_qrcode_init() {
				jQuery('#widgets-right .widget_qrcode:not(.inited)').each(function() {
					var widget = jQuery(this).addClass('inited');
					widget.find('input.iColorPicker:not(.colored)').each(function() {
						var obj = jQuery(this);
						if (obj.attr('id').indexOf('__i__') < 0) {
							obj.addClass('colored');
							ancora_set_color_picker(obj.attr('id'));
						}
					});
					widget.find('div.qrcode_tabs').tabs();
					widget.find('.fld_button_draw').click(function() {
						ancora_qrcode_update(widget);
					});
					widget.parents('form').find('.widget-control-save').click(function() {
						ancora_qrcode_update(widget);
					});
					widget.find('.tab_personal input,.tab_text textarea,.fld_auto_draw,.iColorPicker').change(function () {
						if (widget.find('.fld_auto_draw').attr('checked')=='checked') {
							widget.find('.fld_button_draw').hide();
							ancora_qrcode_update(widget);
						} else 
							widget.find('.fld_button_draw').show();
					});
					if (widget && widget.find('.fld_auto_draw').attr('checked')=='checked')
						widget.find('.fld_button_draw').hide();
				});
			}
            function ancora_qrcode_update(widget) {
				ancora_qrcode_show(widget, {
                        ufname:		widget.find('.fld_ufname').val(),
                        ulname:		widget.find('.fld_ulname').val(),
                        ucompany:	widget.find('.fld_ucompany').val(),
                        usite:		widget.find('.fld_usite').val(),
                        uemail:		widget.find('.fld_uemail').val(),
                        uphone:		widget.find('.fld_uphone').val(),
                        //ufax:		widget.find('.fld_ufax').val(),
                        uaddr:		widget.find('.fld_uaddr').val(),
                        ucity:		widget.find('.fld_ucity').val(),
                        upostcode:	widget.find('.fld_upostcode').val(),
                        ucountry:	widget.find('.fld_ucountry').val(),
                        //unote:	widget.find('.fld_unote').val(),
                        //ucats:	widget.find('.fld_ucats').val(),
                        uid:		widget.find('.fld_uid').val(),
                        urev:		widget.find('.fld_urev').val(),
                        text: 		widget.find('.fld_text').val()
                    }, 
                    {
                        qrcode: widget.find('.qrcode_image').eq(0),
                        personal: widget.find('.qrcode_data'),
                        show_personal: widget.find('.fld_show_personal').attr('checked')=='checked',
                        show_what: widget.find('.fld_show_what').attr('checked')=='checked' ? 1 : 0,
                        width: widget.find('.fld_width').val(),
                        color: widget.find('.fld_color').val(),
                        bg: widget.find('.fld_bg').val()
                    }
                );
				var image = widget.find('.qrcode_image canvas').get(0).toDataURL('image/png');
				widget.find('.fld_image').val(image);
				widget.find('.qrcode_image img').attr('src', image);
            }
			function ancora_qrcode_show(widget, vc, opt) {
				if (opt.show_what==1) {
					var text = 'BEGIN:VCARD\n'
						+ 'VERSION:3.0\n'
						+ 'FN:' + vc.ufname + ' ' + vc.ulname + '\n'
						+ 'N:' + vc.ulname + ';' + vc.ufname + '\n'
						+ (vc.ucompany ? 'ORG:' + vc.ucompany + '\n' : '')
						+ (vc.uphone ? 'TEL;TYPE=cell, pref:' + vc.uphone + '\n' : '')
						+ (vc.ufax ? 'TEL;TYPE=fax, pref:' + vc.ufax + '\n' : '')
						+ (vc.uaddr || vc.ucity || vc.ucountry ? 'ADR;TYPE=dom, home, postal, parcel:;;' + vc.uaddr + ';' + vc.ucity + ';;' + vc.upostcode + ';' + vc.ucountry + '\n' : '')
						+ (vc.usite ? 'URL:' + vc.usite + '\n' : '')
						+ (vc.uemail ? 'EMAIL;TYPE=INTERNET:' + vc.uemail + '\n' : '')
						+ (vc.ucats ? 'CATEGORIES:' + vc.ucats + '\n' : '')
						+ (vc.unote ? 'NOTE:' + vc.unote + '\n' : '')
						+ (vc.urev ? 'NOTE:' + vc.urev + '\n' : '')
						+ (vc.uid ? 'UID:' + vc.uid + '\n' : '')
						+ 'END:VCARD';
				} else {
					var text = vc.text;
				}
				opt.qrcode
					.empty()
					.qrcode({
						'text': text,
						'color': opt.color,
						'bgColor': opt.bg!='' ? opt.bg : null,
						'width': opt.width,
						'height': opt.width,
						'size': opt.width
					});
				if (opt.show_personal == 0)
					opt.personal.empty().hide(); 
				else
					opt.personal.html(
						'<ul>'
							+ (opt.show_what==1 
								? '<li class="user_name odd first">' + vc.ufname + ' ' + vc.ulname + '</li>'
									+ (vc.ucompany ? '<li class="user_company even">' + vc.ucompany + '</li>' : '')
									+ (vc.uphone ? '<li class="user_phone odd">' + vc.uphone + '</li>' : '')
									+ (vc.uemail ? '<li class="user_email even"><a href="mailto:' + vc.uemail + '">' + vc.uemail + '</a></li>' : '')
									+ (vc.usite ? '<li class="user_site odd"><a href="' + vc.usite + '" target="_blank">' + vc.usite + '</a></li>' : '')
								: '<li class="text odd first">' + vc.text + '</li>')
						+ '</ul>'
					).show();
			}
			
			if (!window.ancora_set_color_picker) {
				function ancora_set_color_picker(id_picker) {
					jQuery('#'+id_picker).click(function (e) {
						"use strict";
						ancora_color_picker_show(null, jQuery(this), function(fld, clr) {
							"use strict";
							fld.css('backgroundColor', clr).val(clr);
						});
					});
				}
			}
        </script>
	<?php
	}
	
	// Load scripts
	function load_scripts() {
		if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('js/__packed.js'))) {
			wp_enqueue_script( 'ancora-core-utils-script', ancora_get_file_url('js/core.utils.js'), array('jquery'), null, true );
		}
		wp_enqueue_script('widget-qrcode-script', trx_utils_get_file_url('widgets/qrcode/jquery.qrcode-0.6.0.min.js'), array('jquery'), null, true);
	}
}
?>