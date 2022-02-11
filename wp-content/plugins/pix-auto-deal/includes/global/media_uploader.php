<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

##############################################
# Ajax Media Uploader 
# Credits: krishnakantsharma.com
##############################################
add_action( 'wp_enqueue_scripts', 'pixad_enqueue_uploader_scripts' );
add_action( 'admin_enqueue_scripts', 'pixad_enqueue_uploader_scripts' );
function pixad_enqueue_uploader_scripts() {
	
	// Load photo upload scripts only if [page = add_pixad] or [post_type = pixad-autos]
	if( is_admin() || isset( $_GET['pixad'] ) && $_GET['pixad'] == 'add-new-pixad' || isset( $_GET['pixad'] ) && $_GET['pixad'] == 'edit-pixad' ) {
		wp_enqueue_script('plupload-all');
 
		wp_register_script('media-uploader', PIXAD_AUTO_URI . 'assets/js/media-uploader.js', array('jquery'));
		wp_enqueue_script('media-uploader');
 
		wp_register_style('media-uploader', PIXAD_AUTO_URI . 'assets/css/media-uploader.css');
		wp_enqueue_style('media-uploader');
	}
	
}

if( isset( $_GET['pixad'] ) && $_GET['pixad'] == 'add-new-pixad' || isset( $_GET['pixad'] ) && $_GET['pixad'] == 'edit-pixad' ) {
add_action( 'wp_head', 'pixad_plupload_head' );}
add_action( 'admin_head', 'pixad_plupload_head' ); 
function pixad_plupload_head() {
	// place js config array for plupload
    $plupload_init = array(
        'runtimes' => 'html5,silverlight,flash,html4',
        'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
        'container' => 'plupload-upload-ui', // will be adjusted per uploader
        'drop_element' => 'drag-drop-area', // will be adjusted per uploader
        'file_data_name' => 'async-upload', // will be adjusted per uploader
        'multiple_queues' => true,
        'max_file_size' => wp_max_upload_size() . 'b',
        'url' => admin_url('admin-ajax.php'),
        'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
        'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
        'filters' => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
        'multipart' => true,
        'urlstream_upload' => true,
        'multi_selection' => false, // will be added per uploader
         // additional post data to send to our ajax hook
        'multipart_params' => array(
            '_ajax_nonce' => "", // will be added per uploader
            'action' => 'plupload_action', // the ajax action name
            'imgid' => 0 // will be added per uploader
        )
    );
?>
<script type="text/javascript">  
    var base_plupload_config=<?php echo json_encode($plupload_init); ?>;
</script>  
<?php }
/**
 * Setup ajax handler to handle asynchronous file upload.
 */
add_action( 'wp_ajax_plupload_action', 'pixad_plupload_action' );
function pixad_plupload_action() {
 
    // check ajax noonce
    $imgid = $_POST["imgid"];
    check_ajax_referer($imgid . 'pluploadan');
 
    // handle file upload
    $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));
    // send the uploaded file url in response
	//print_r( $status );
	echo $status['url'];
	exit;
}

function pixad_json_decode($value){
	return json_decode(base64_decode($value));
}

?>