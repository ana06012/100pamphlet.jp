<?php
 
/*
plugin name: My upload images
Plugin URI: http://web.contempo.jp/weblog/tips/p617
Description: Create metabox with media uploader. It allows user to upload and sort images in any post_type you want. 
Author: Mizuho Ogino
Author URI: http://web.contempo.jp/
Version: 1.3.6
Text Domain: mui
Domain Path: /languages
License: http://www.gnu.org/licenses/gpl.html GPL v2 or later
*/


add_action( 'plugins_loaded', 'mui_textdomain' );
function mui_textdomain() {
	load_plugin_textdomain( 'mui', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

add_action('admin_menu', 'mui_menu');
function mui_menu() {
	add_options_page( __( 'My Upload Images', 'mui' ), __( 'My Upload Images', 'mui' ), 'edit_pages', __FILE__, 'mui_options' );
}

function mui_options() { 
	if ( isset($_POST["mui_options_nonce"]) && wp_verify_nonce($_POST['mui_options_nonce'], basename(__FILE__)) ) { // save options
		$update_options = array( 
			'posttype' => ( isset( $_POST[ 'mui_posttype' ] ) ? $_POST[ 'mui_posttype' ] : '' ), 
			'pages' => ( isset( $_POST[ 'mui_pages' ] ) ? $_POST[ 'mui_pages' ] : '' ),
			'keepvalues' => ( isset( $_POST[ 'mui_keepvalues' ] ) ? $_POST[ 'mui_keepvalues' ] : '' ),
			'postthumb' => ( isset( $_POST[ 'mui_postthumb' ] ) ? $_POST[ 'mui_postthumb' ] : '' ),
			'imgtitle' => ( isset( $_POST[ 'mui_imgtitle' ] ) ? $_POST[ 'mui_imgtitle' ] : '' ),
			'title' => wp_strip_all_tags( ( isset( $_POST[ 'mui_title' ] ) ? $_POST[ 'mui_title' ] : '' ) ),
			'position' => ( isset( $_POST[ 'mui_position' ] ) ? $_POST[ 'mui_position' ] : '' )
		);
		update_option( 'mui_options', $update_options );
		echo '<div class="updated fade"><p><strong>'. __('Options saved.', 'mui'). '</strong></p></div>';
	}

	$opt = get_option( 'mui_options' );
	if ( empty( $opt ) ){
		$update_options = array( 
			'posttype' => get_option( 'mui_posttype' ), 'pages' => get_option( 'mui_pages' ), 'keepvalues' => get_option( 'mui_keepvalues' ), 'postthumb' => get_option( 'mui_postthumb' ), 'title' => get_option( 'mui_title' ), 'position' => get_option( 'mui_position' )
		);
		delete_option( 'mui_posttype' ); delete_option( 'mui_pages' ); delete_option( 'mui_keepvalues' ); delete_option( 'mui_postthumb' ); delete_option( 'mui_title' ); delete_option( 'mui_position' );
		update_option( 'mui_options', $update_options ); // overwrite old version settings
	}

	$posttype = $opt['posttype'];
	$default = array();
	if ($posttype): foreach( $posttype as $key => $val ):
		$default[$val] = true;
	endforeach; endif;
	$pages = $opt['pages'];
	if ($pages): foreach( $pages as $key => $val ):
		$default[$val] = true;
	endforeach; endif;

	$post_types = get_post_types( array( 'public' => true ), 'objects' ); 
	unset($post_types['attachment']); 
	$inputs = $individuals = '';
	if ($post_types) : foreach($post_types as $post_type) :
		if ( isset($default[ $post_type->name ]) ) $checked = ' checked="checked"'; else $checked = ''; 
		$inputs .= "\t\t\t".'<p><label for="field-mui_posttype-'.$post_type->name.'"><input id="field-mui_posttype-'.$post_type->name.'" type="checkbox" name="mui_posttype[]" value="'.$post_type->name.'"'.$checked.'/>'.$post_type->label.'</label></p>'."\n";
		if ( $post_type->capability_type == 'page' ) {
			$pages = get_posts( '&post_type=' .$post_type->name. '&post_status=any&numberposts=-1' );
			if ($pages) : 
				$individuals .= "\t".'<tr id="individuals-'.$post_type->name.'">'."\n\t\t".'<th scope="row">'.sprintf(__('Select %s', 'mui'), $post_type->label).'</th>'."\n\t\t".'<td>'."\n";
				$individuals .= "\t\t".'<script type="text/javascript">jQuery( function($){ var ckbtn = $("input#field-mui_posttype-'.$post_type->name.'"), cktaget = $("tr#individuals-'.$post_type->name.'").hide(); if ( ckbtn.is(":checked") ) cktaget.show(); ckbtn.click( function () { if ( ckbtn.is(":checked") ) cktaget.show(); else cktaget.hide(); }); });</script>'."\n";
				foreach($pages as $page) :
					if ( isset($default[ $page->ID ]) ) $checked = ' checked="checked"'; else $checked = ''; 
					$individuals .= "\t\t\t".'<p><label for="field-mui_pages-'.$page->ID.'"><input id="field-mui_pages-'.$page->ID.'" type="checkbox" name="mui_pages[]" value="'.$page->ID.'"'.$checked.'/>'.esc_html( $page->post_title ).'</label></p>'."\n";
				endforeach; 
				$individuals .= "\t\t".'</td>'."\n\t".'</tr>'."\n";
			endif;
		}
	endforeach; endif;

	if ( !isset( $opt['keepvalues'] ) ) $opt['keepvalues'] = 'keep';
	$val = $opt['keepvalues'];

	if ( !isset( $opt['imgtitle'] ) ) $opt['imgtitle'] = 'none';
	$val = $opt['imgtitle'];

	if ( !isset( $opt['postthumb'] ) ) $opt['postthumb'] = 'none';
	$val = $opt['postthumb'];

	if ( !isset( $opt['position'] ) ) $opt['position'] = 'side';
	$val = $opt['position'];

	echo
		'<div class="wrap">'."\n".
		'<h2>' .__( 'My Upload Images Settings', 'mui' ).'</h2>'."\n".
		'<h3>' .__( 'Select post_types to display the metabox.', 'mui' ). '</h3>'."\n".
		'<form action="" method="post">'."\n".
		'<table class="form-table">'."\n".
		"\t".'<tr>'."\n".
		"\t\t".'<th scope="row">'.__( 'Metabox title', 'mui' ).'</th>'."\n".
		"\t\t".'<td>'."\n\t\t\t".'<input type="text" name="mui_title" class="text" size="40" value="'.( isset( $opt[ 'title' ] ) ? esc_attr( $opt[ 'title' ] ) : __( 'My Upload Images', 'mui' ) ).'" />'."\n\t\t".'</td>'."\n".
		"\t".'</tr>'."\n".
		"\t".'<tr>'."\n".
		"\t\t".'<th scope="row">'.__( 'Select post types', 'mui' ).
		'<p style="font-size:.8em;font-weight:normal;">' .__( 'If the post_type has "capability_type" parameter as "page", pages will be individually selectable.', 'mui' ). '</p></th>'."\n".
		"\t\t".'<td>'."\n". $inputs. "\t\t".'</td>'."\n".
		"\t".'</tr>'."\n".
		$individuals. 
		"\t".'<tr>'."\n".
		"\t\t".'<th scope="row">'.__( 'Title of image', 'mui' ).'</th>'."\n".
		"\t\t".'<td>'."\n".
		"\t\t\t". '<select name="mui_imgtitle"><option value="display"'.( isset( $opt['imgtitle'] ) && $opt['imgtitle'] === 'display' ? ' selected' : '' ).'>'.__( 'Showing image title', 'mui' ).'</option><option value="none"'.( isset( $opt['imgtitle'] ) && $opt['imgtitle'] === 'none' ? ' selected' : '' ).'>'.__( 'No showing title', 'mui' ).'</option></select>'."\n".
		"\t\t".'</td>'."\n".
		"\t".'</tr>'."\n".
		"\t".'<tr>'."\n".
		"\t\t".'<th scope="row">'.__( 'Featured images', 'mui' ).'</th>'."\n".
		"\t\t".'<td>'."\n".
		"\t\t\t". '<select name="mui_postthumb"><option value="generate"'.( isset( $opt['postthumb'] ) && $opt['postthumb'] === 'generate' ? ' selected' : '' ).'>'.__( 'Generate a featured image from the first of my upload images', 'mui' ).'</option><option value="none"'.( isset( $opt['postthumb'] ) && $opt['postthumb'] === 'none' ? ' selected' : '' ).'>'.__( 'No automatically generating', 'mui' ).'</option></select>'."\n".
		"\t\t".'</td>'."\n".
		"\t".'</tr>'."\n".
		"\t".'<tr>'."\n".
		"\t\t".'<th scope="row">'.__( 'Put the metabox', 'mui' ).
		'<p style="font-size:.8em;font-weight:normal;">' .__( 'If conflict with a plugin of custom fields, set value to "on the side".', 'mui' ). '</p></th>'."\n".
		"\t\t".'<td>'."\n".
		"\t\t\t". '<select name="mui_position"><option value="side"'.( isset( $opt['position'] ) && $opt['position'] === 'side' ? ' selected' : '' ).'>'.__( 'on the side', 'mui' ).'</option><option value="advanced"'.( isset( $opt['position'] ) && $opt['position'] === 'advanced' ? ' selected' : '' ).'>'.__( 'after the editor', 'mui' ).'</option><option value="mui_after_title"'.( isset( $opt['position'] ) && $opt['position'] === 'mui_after_title' ? ' selected' : '' ).'>'.__( 'after the title', 'mui' ).'</option></select>'."\n".
		"\t\t".'</td>'."\n".
		"\t".'</tr>'."\n".
		"\t".'<tr>'."\n".
		"\t\t".'<th scope="row">'.__( 'When the plugin is uninstalled', 'mui' ).'</th>'."\n".
		"\t\t".'<td>'."\n".
		"\t\t\t". '<select name="mui_keepvalues"><option value="keep"'.( isset( $opt['keepvalues'] ) && $opt['keepvalues'] === 'keep' ? ' selected' : '' ).'>'.__( 'Keep the options and customfields', 'mui' ).'</option><option value="delete"'.( isset( $opt['keepvalues'] ) && $opt['keepvalues'] === 'delete' ? ' selected' : '' ).'>'.__( 'Delete the options and customfields', 'mui' ).'</option></select>'."\n".
		"\t\t".'</td>'."\n".
		"\t".'</tr>'."\n".
		'</table>'."\n".
		'<p class="submit"><input type="submit" name="Submit" class="button-primary" value="'.__( 'Save changes', 'mui' ).'" /></p>'."\n".
		'<input type="hidden" name="mui_options_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />'."\n".
		'</form>'."\n".
		'</div>'."\n";
}

add_action( 'admin_menu', 'mui_metaboxes_init', 100 );
function mui_metaboxes_init(){ 
	$opt = get_option( 'mui_options' );
	if ( empty( $opt ) ){
		if ( !$mui_keepvalues = get_option( 'mui_keepvalues' ) ) $mui_keepvalues = 'keep';
		if ( !$mui_postthumb = get_option( 'mui_postthumb' ) ) $mui_postthumb = 'none';
		if ( !$mui_position = get_option( 'mui_position' ) ) $mui_position = 'side';
		$update_options = array( 
			'posttype' => get_option( 'mui_posttype' ), 'pages' => get_option( 'mui_pages' ), 'keepvalues' => $mui_keepvalues, 'postthumb' => $mui_postthumb, 'title' => get_option( 'mui_title' ), 'position' => $mui_position
		);
		delete_option( 'mui_posttype' ); delete_option( 'mui_pages' ); delete_option( 'mui_keepvalues' ); delete_option( 'mui_postthumb' ); delete_option( 'mui_title' ); delete_option( 'mui_position' );
		update_option( 'mui_options', $update_options ); // overwrite old version settings
		$opt = get_option( 'mui_options' );
	}
	if ( empty($opt['posttype']) ) return; 
	if ( !$opt_title = $opt['title'] ) $opt_title = __( 'My Upload Images', 'mui' );
	if ( !$opt_position = $opt['position'] ) $opt_position = 'side';
	$posttype = $opt['posttype'];
	foreach( $posttype as $key => $val ):
		if ( get_post_type_object( $val )->capability_type == 'page' ){
			if ( isset($_GET['post']) && $_GET['post'] ) $post_id = $_GET['post'];
			elseif ( isset($_POST['post_ID']) && $_POST['post_ID'] ) $post_id = $_POST['post_ID'];
			$opt_p = $opt['pages'];
			if ($opt_p): foreach( $opt_p as $key_p => $val_p ):	
				if ( isset( $post_id ) && $post_id == $val_p) add_meta_box( 'mui_images', $opt_title, 'set_mui_uploader', $val, $opt_position, 'high' );
			endforeach; endif;
		} else {
			add_meta_box( 'mui_images', $opt_title, 'set_mui_uploader', $val, $opt_position, 'high' );
		}
	endforeach; 
	add_action( 'save_post', 'save_mui_images' );
	add_action( 'edit_form_after_title', function(){
		$opt = get_option( 'mui_options' );
		if( $opt['position'] === 'mui_after_title' ) do_meta_boxes( $val, 'mui_after_title', $post_id );
	});
}

function set_mui_uploader(){ 
	$post = get_post();
	$post_id = $post->ID;
	$mui_li = '';
	if ( $post_id ):
		$mui_images = get_post_meta( $post_id, 'my_upload_images', true );
		if ( $mui_images): foreach( $mui_images as $key => $img_id ):
			$thumb_src = wp_get_attachment_image_src ( $img_id,'medium' );
			if ( empty ($thumb_src[0]) ){ // If the file is not exist, delete the ID.
				delete_post_meta( $post_id, 'my_upload_images', $img_id );
			} else {
				$mui_li.= 
				"\t".'<li class="mui_img" id="mui_img_'.$img_id.'" title="'.__('Sort it in any order', 'mui' ).'">'."\n".
				"\t\t".'<a href="#" class="mui_remove button" title="'.__( 'Remove this image from the list', 'mui' ).'"></a>'."\n".
				"\t\t".'<div class="mui_img_wrap">'."\n".
				"\t\t\t".'<img src="'.$thumb_src[0].'"/><div class="mui_img_title"><span>'.wp_strip_all_tags( get_the_title( $img_id ) ).'</span></div>'."\n".
				"\t\t\t".'<input type="hidden" name="my_upload_images[]" value="'.$img_id.'" />'."\n".
				"\t\t".'</div>'."\n".
				"\t".'</li>'."\n";
			}
		endforeach; endif;
	endif;
?>
<style type="text/css">
	#mui_images .inside { padding-top:8px; padding-bottom:13px; }
	#mui_list { display:block; list-style-type:none; margin:0 -6px; padding:0; }
	#mui_list:after { content:' '; display:block; height:0; clear:both; visibility:hidden; }
	#mui_list li { float:left; display:block; margin:6px; padding:0; height:160px; position:relative; }
	#mui_list .mui_img_wrap { display:inline-block; max-width:100%; margin:0; padding:5px; position:relative; background:#efefef; border:1px solid #ccc; -webkit-border-radius:2px; -moz-border-radius:2px; border-radius:2px; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; box-sizing:border-box; }
	#mui_list .mui_img_wrap:hover { background:#9cc; cursor:move; }
	#mui_list .mui_img_wrap img { margin:0; padding:0; max-height:150px; width:auto; vertical-align:text-bottom; }
	#mui_list .mui_img_wrap .mui_img_title { position:absolute; right:5px; bottom:5px; left:5px; text-align:right; overflow:hidden; }
	#mui_list .mui_img_wrap .mui_img_title span { display:inline-block; background:rgba(0,0,0,.5); color:#fff; font-size:10px; line-height:12px; padding:1px 4px; }
	#mui_list .mui_img_wrap input { display:none; }
	@media screen and (min-width : 851px){
		#side-sortables #mui_list { text-align:center; }
		#side-sortables #mui_list li { height:auto; float:none; max-width:100%; width:auto; margin:5px 0; display:inline-block; }
		#side-sortables #mui_list .mui_img_wrap img { max-height:120px; max-width:100%; width:auto; height:auto; }
	}
	@media screen and (max-width : 850px){
		#mui_list li { float:left; margin:8px; padding:0; height:138px; }
		#mui_list .mui_img_wrap img { max-height:130px; max-width:100%; width:auto; height:auto; }
	}
	#mui_list a.mui_remove { height:32px; width:32px; text-align:center; position:absolute; top:-8px; right:-8px; text-decoration:none; padding:0; -webkit-border-radius:50%; -moz-border-radius:50%; border-radius:50%; z-index:20; }
	a.mui_remove:before { font-family:"dashicons"; content:"\f158"; display:block; text-align:center; vertical-align:middle; font-size:20px; line-height:20px; padding:6px 0; }
	a.mui_remove:hover { background:#387; }
	#mui_button a { padding:6px; margin-bottom:20px; height:32px; width:100%; line-height:20px; font-weight:bold; text-align:center; }
<?php 
	$opt = get_option( 'mui_options' );
	if ( $opt['imgtitle'] !== 'display' ) echo '#mui_list .mui_img_wrap .mui_img_title { display:none; }'."\n"; 
?>
</style>
<div id="mui_button">
	<a id="mui_media" class="button"><?php echo __( 'Add and edit images', 'mui' ); ?></a>
</div>
<ul id="mui_list">
<?php echo $mui_li; ?>
</ul>
<input type="hidden" name="mui_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
<script type="text/javascript">
jQuery( function( $ ){
	var custom_uploader = wp.media({
		state : 'mui_state',
		frame: 'post',
		multiple: true
	});
	custom_uploader.states.add([
		new wp.media.controller.Library({
			id:	'mui_state',
			library: wp.media.query( { type: 'image' } ),
			title: <?php echo '\''.__( 'Upload images', 'mui' ).'\''; ?>,
			priority: 70,
			toolbar: 'select',
			menu: false,
			filterable: 'uploaded',
			multiple: custom_uploader.options.multiple ? 'reset' : false
		})
	]);
	// $( '#mui_images' ).addClass( 'wp-editor-wrap' ).on('drop', function( e ) { 
	// 	$(this).removeClass( 'wp-editor-wrap' );
	// 	custom_uploader.open();
	// });
	$( '#mui_media' ).on('click', function( e ) {
		var clickagain = function() { if ( !$( '.media-frame' ).length ) { custom_uploader.open(); } }
		setTimeout( clickagain, 100); // The parameter "menu:false" delay open() event. 
		custom_uploader.open();
		return false;
	});
	var ex_ul = $( '#mui_list' ), ex_ids = [];
	custom_uploader.on( 'ready', function( ){
		$( 'select.attachment-filters [value="uploaded"]' ).attr( 'selected', true ).parent().trigger('change'); // Change the default view to "Uploaded to this post".
	// }).on( 'open', function( ){ $( '.media-frame' ).addClass( 'hide-menu' ).addClass( 'hide-router' ); // Remove left menu
	}).on( 'close', function( ){ 
		var this_id = 0, 
			attach_list = $( 'ul.attachments', '.media-frame-content' ), 
			attach_ids = [];
		if ( attach_list.length ) {
			attach_list.children( 'li' ).each( function( ){
				this_id = $( this ).data( 'id' );
				attach_ids.push( this_id );
			});
			ex_ul.children( 'li' ).each( function( ){
				this_id = Number( $(this).attr( 'id' ).slice(8) ); //#mui_img_(N)
				if ( $.inArray( this_id, attach_ids ) > -1 ){
					ex_ids.push( this_id );
				} else {  // Remove the ID removed in the upoloader. 
					ex_ul.find( 'li#mui_img_' + this_id ).remove();
				}
			});
		}
	}).on( 'select', function( ){ 
		var this_id = 0, this_url = '',
			selection = custom_uploader.state().get( 'selection' );
		selection.each( function( file ){
			this_id = file.toJSON().id;
			if ( file.attributes.sizes.medium ) this_url = file.attributes.sizes.medium.url;
			else if ( file.attributes.sizes.large ) this_url = file.attributes.sizes.large.url;
			else this_url = file.attributes.url;
			if ( $.inArray( this_id, ex_ids ) > -1 ){ // Remove the ID duplicate in the list.
				ex_ul.find( 'li#mui_img_' + this_id ).remove();
			}
			ex_ul.append( '<li class="mui_img" id="mui_img_' + this_id + '"></li>' ).find( 'li:last' ).append(
				'<a href="#" class="mui_remove button" title="' + <?php echo '\''.__( 'Remove this image from the list', 'mui' ).'\''; ?> + '"></a>' +
				'<div class="mui_img_wrap">' + 
				'<img src="' + this_url + '" /><div class="mui_img_title"><span>' + file.toJSON().title + '</span></div>' +
				'<input type="hidden" name="my_upload_images[]" value="'+ this_id +'" />' + 
				'</div>'
			);
		});
	});

	$(document).on( 'click', '.mui_remove', function( e ) {
		img_obj = $(this).parents( 'li.mui_img' ).remove();
		return false;
	});
	$( '#mui_list' ).sortable({
		cursor : 'move',
		tolerance : 'pointer',
		opacity: 0.6
	});
});
</script>
<?php }


function save_mui_images( $post_id ){
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	if ( !isset($_POST['mui_nonce']) || isset($_POST['mui_nonce']) && !wp_verify_nonce($_POST['mui_nonce'], basename(__FILE__))) return $post_id; 
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;
	}
	$new_images = isset($_POST['my_upload_images']) ? $_POST['my_upload_images']: null; 
	$ex_images = get_post_meta( $post_id, 'my_upload_images', true ); 
	if ( $ex_images !== $new_images ){
		if ( $new_images ){
			update_post_meta( $post_id, 'my_upload_images', $new_images ); 
		} else {
			delete_post_meta( $post_id, 'my_upload_images', $ex_images ); 
		}
	}
	$opt = get_option('mui_options');
	if ( isset($opt['postthumb']) && $opt['postthumb'] == 'generate' ) { // USING MY UPLOAD IMAGES AS POST THUMBNAIL
		if ( $image = get_post_meta( $post_id, 'my_upload_images', true ) ){
			update_post_meta( $post_id, '_thumbnail_id', $image[0] );
		}
	}
}

