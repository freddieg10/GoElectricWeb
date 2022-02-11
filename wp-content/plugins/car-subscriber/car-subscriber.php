<?php

/**
 * Plugin Name: Car Subscriber
 * Description: Car Subscriber
 * Author: Templines
 * Version: 1.4

 */



require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/theme/autozone/car-subscriber.json',
    __FILE__,
    'car-subscriber'
);  


// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

//Log in Widget
require_once('inc/widget-login-in.php');
function carsubscriber_init_widgets() {
    register_widget('CarSubscriber_Login_Form_Widget');
}

add_action('widgets_init', 'carsubscriber_init_widgets');


/**
 * Car Support
 */
class Car_Subscriber
{
    //all strings class
    public static $strings = array();
    //all settings class
    public static $settings = array();

    public function __construct()
    {
        self::init();
        // admin
        add_action('the_post', [$this, 'expired_post']);
        add_action('show_user_profile', [$this, 'add_fielads_for_author']);
        add_action('edit_user_profile', [$this, 'add_fielads_for_author']);
        add_action( 'personal_options_update', [$this,'save_extra_profile_fields'] );
        add_action( 'edit_user_profile_update',[$this,'save_extra_profile_fields'] );
        add_action( 'admin_head', [$this, 'notice_expired'] );

        // front
        add_filter( 'body_class', [$this,'support_expired_user'] );

    }
    public static function init()
    {
        self::$settings = array(

        );
        // Load class strings.
        self::$strings = array(
            'date_support_autodealer'                => __('Period of Publication', 'cst_support'),
            'max_cars_number'                           => __('Limit of publications', 'cst_support'),
            'subscription_time_little'                => __('Your subscription will end in', 'cst_support'),
            'max_cars_number_title'                => __('Exceeded the limit of publication', 'cst_support'),
            'max_cars_number_title_left'                => __('Available', 'cst_support'),
            'subscription_time_end'                => __('Subscription ended', 'cst_support'),
            'subscription_auto_end'                => __('Publication ended', 'cst_support'),
        );

    }

    public function expired_post($post)
    {

        if( !user_can( $post->post_author, 'autodealer' )
         || user_can( $post->post_author, 'administrator' )
         || !($post->post_type === 'pixad-autos')
        ) return;

        if(!self::is_support_post_count($post->post_author) ) {
            wp_update_post(['ID' => $post->ID, 'post_status' => 'draft']);
            update_post_meta($post->ID, 'cst_time_out_support', 1);
        } else {
            wp_update_post(['ID' => $post->ID, 'post_status' => 'publish']);
            delete_post_meta($post->ID, 'cst_time_out_support');
        }

        if(!self::is_support_time($post) ) {
            wp_update_post(['ID' => $post->ID, 'post_status' => 'draft']);
            update_post_meta($post->ID, 'cst_time_out_support', 1);
        }
        else{
            wp_update_post(['ID' => $post->ID, 'post_status' => 'publish']);
            delete_post_meta($post->ID, 'cst_time_out_support');
        }

    }

    function downcounter($date){
        $check_time = strtotime($date) - time();
        if($check_time <= 0){
            return false;
        }

        $days = floor($check_time/86400);
        $hours = floor(($check_time%86400)/3600);
        $minutes = floor(($check_time%3600)/60);
        $seconds = $check_time%60;

        $str = '';
        if($days > 0) $str .=  self::declension($days,array('Day','Days','Days')).' ';
        //if($hours > 0) $str .=  self::declension($hours,array('час','часа','часов')).' ';
        //if($minutes > 0) $str .=  self::declension($minutes,array('минута','минуты','минут')).' ';
        //if($seconds > 0) $str .=  self::declension($seconds,array('секунда','секунды','секунд'));

        return $str;
    }

    function declension($digit,$expr,$onlyword=false){
        if(!is_array($expr)) $expr = array_filter(explode(' ', $expr));
        if(empty($expr[2])) $expr[2]=$expr[1];
        if (is_numeric($digit)) {
            $i=preg_replace('/[^0-9]+/s','',$digit)%100;

        }
        if($onlyword) $digit='';
        if(isset($i)){
            if($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
            else
            {
                $i%=10;
                if($i==1) $res=$digit.' '.$expr[0];
                elseif($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
                else $res=$digit.' '.$expr[2];
            }
        }
        if(!empty($res) && $res != NULL && $res != ''){
            return trim($res);

        }

    }
    function declension_autos($count){
        $post_count = count_user_posts(wp_get_current_user()->ID, $post_type = 'pixad-autos', $public_only = false);

        if($post_count <= $count){
            $res = $count - $post_count;
        }
        if(!empty($res) && $res != NULL && $res != ''){
            return trim($res);

        }
    }



    function notice_expired()
    {

       

        if(!self::is_support_author(wp_get_current_user()->ID)){

            add_action( 'admin_notices', function(){
                echo '<div class="update-nag"><p>'. esc_attr( self::$strings['subscription_time_end'] ).'</p></div>';
            } );
        }
        if(self::is_support_author_long(wp_get_current_user()->ID)){
            add_action( 'admin_notices', function(){
                echo '<div class="car_sbscr_notice"><p>'. esc_attr( self::$strings['subscription_time_little'] ). ' ' . esc_attr(self::downcounter(get_user_meta(wp_get_current_user()->ID, 'date-support-autodealer', true))).'</p></div>';


                //echo '<div class="update-nag cst-notice__little-time"><p>'. esc_attr( self::$strings['subscription_time_little'] . ' '.get_user_meta(wp_get_current_user()->ID, 'date-support-autodealer', true) ).'</p></div>';
               // echo '<div class="update-nag cst-notice__little-time"><p>'. esc_attr( self::$strings['max_cars_number_title'] . ' '.get_user_meta(wp_get_current_user()->ID, 'max-cars-number', true) ).'.</p></div>';
            } );
        }

        if(!self::is_support_post_count(wp_get_current_user()->ID)){
            add_action( 'admin_notices', function(){
                echo '<div class="update-nag"><p>'. esc_attr( self::$strings['subscription_auto_end'] ).'</p></div>';
            } );
        } else {
            add_action( 'admin_notices', function(){
                echo '<div class="car_sbscr_notice"><p>'. esc_attr( self::$strings['max_cars_number_title_left']) . ' ' . self::declension(self::declension_autos(get_user_meta(wp_get_current_user()->ID, 'max-cars-number', true)),array('Publication','Publications','Publications')).'</p></div>';
            } );
        }

    }
    public static function is_support_time($post) {

        return self::is_support_author($post->post_author);
    }

    public static function is_support_author($post_author)
    {
        if( !user_can( $post_author, 'autodealer' )
         || user_can( $post_author, 'administrator' )
        ) return true;

        $support_date = get_user_meta($post_author, 'date-support-autodealer', true);
        if(!empty($support_date)) {
            $current = new DateTime();
            $expiration = DateTime::createFromFormat('Y-m-d', $support_date);

            if($expiration
                && $current <= $expiration) {
                return true;
            }
            return false;
        }
        return true;
    }

    public static function is_support_post_count($post_author)
    {

        $support_post_count = get_user_meta( $post_author, 'max-cars-number', true );

        $post_count = count_user_posts($post_author, $post_type = 'pixad-autos', $public_only = false);

        if(!empty($support_post_count)) {
            if($post_count >= $support_post_count) {
                return false;
            }else{
                return true;
            }
        }
        return true;
    }

    public static function is_support_author_long($post_author)
    {
        if( !user_can( $post_author, 'autodealer' )
         || user_can( $post_author, 'administrator' )
        ) return true;

        $support_date = get_user_meta($post_author, 'date-support-autodealer', true);

        if(!empty($support_date)) {
            $current = new DateTime();
            $expiration = DateTime::createFromFormat('Y-m-d', $support_date);
            $time_long = clone $current;
            $interval = new DateInterval('P3D');
            $time_long->add($interval);

            if($expiration && $current <= $expiration && $time_long <= $expiration) {

                return true;

            }

            return false;
        }


        return true;
    }

    function add_fielads_for_author($user) {
        ?>
        <table class="form-table">
        <?php 
            if (is_super_admin(get_current_user_id()) && !is_super_admin($user->ID)) {?>
                <tr>
                    <th><label for="date-support-autodealer"><?php echo esc_html(self::$strings['date_support_autodealer']);?></label></th>
                    <td>
                        <input type="date" name="date-support-autodealer" value="<?php echo esc_attr( get_the_author_meta( 'date-support-autodealer', $user->ID ) ); ?>" min=""><br>
                    </td>
                </tr>

                <tr>
                    <th><label for="date-support-autodealer"><?php echo esc_html(self::$strings['max_cars_number']);?></label></th>
                    <td>
                        <input type="number" name="max-cars-number" value="<?php echo esc_attr( get_the_author_meta( 'max-cars-number', $user->ID ) ); ?>" min=""><br>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php
    }
    function save_extra_profile_fields( $user_id ) {

        if ( !current_user_can( 'edit_user', $user_id ) ) return false;

        update_user_meta( $user_id, 'date-support-autodealer', $_POST['date-support-autodealer'] );
        update_user_meta( $user_id, 'max-cars-number', $_POST['max-cars-number'] );
    }

    function support_expired_user( $classes ) {

        if(!self::is_support_author(wp_get_current_user()->ID)){

            $classes[] = 'autodealer-expired';
        }

        return $classes;
    }

} //end class
new Car_Subscriber;


//Custom Functions
function crsbscr_wp_kses($fl_string){
    $allowed_tags = array(
        'img' => array(
            'src' => array(),
            'alt' => array(),
            'width' => array(),
            'height' => array(),
            'class' => array(),
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
        'div' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h1' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h2' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h3' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h4' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h5' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h6' => array(
            'class' => array(),
            'id' => array(),
        ),
        'p' => array(
            'class' => array(),
            'id' => array(),
        ),
        'strong' => array(
            'class' => array(),
            'id' => array(),
        ),
        'i' => array(
            'class' => array(),
            'id' => array(),
        ),
        'del' => array(
            'class' => array(),
            'id' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'id' => array(),
        ),
        'li' => array(
            'class' => array(),
            'id' => array(),
        ),
        'ol' => array(
            'class' => array(),
            'id' => array(),
        ),
        'input' => array(
            'class' => array(),
            'id' => array(),
            'type' => array(),
            'style' => array(),
            'name' => array(),
            'value' => array(),
        ),
    );
    if (function_exists('wp_kses')) {
        return wp_kses($fl_string,$allowed_tags);
    }
}
function carsubscriber_login_form() {
    $args = array(
        'redirect'                      =>  esc_url( wp_login_url( get_permalink() ) ),
        'form_id'                       => 'loginform-custom',
        'label_username'                => '',
        'label_password'                => '',
    );

    if (class_exists('CarSubscriber_Login_Form_Widget')) {
        $args = array(
            'label_log_in'              => esc_html__('Sign in', 'car-subscriber'),
            'label_lost_password'       => esc_html__('Forgot password', 'car-subscriber').'?',
        );
        $carsubscriber_login_widget = new CarSubscriber_Login_Form_Widget();
        $carsubscriber_login_widget->wp_login_form($args);
    } else {
        wp_login_form($args);
    }
}

function carsubscriber_login_show() {
    $login_out  = '';
    $login_out .= '<div class="fl-login-register--header fl-top-wrapper-right">';
        $login_out .= '<span class="fl-dropdown-login">';
        $login_out .= esc_html__('Login','car-subscriber');
        $login_out .= '</span>';

        if ( get_option('users_can_register') ) {
            $login_out .= '<span class="fl-header-register-delimiter">'. esc_html__('or','car-subscriber') . '</span>';
            $login_out .= '<span class="fl-dropdown-register">';
            $login_out .= esc_html__('Register','car-subscriber');
            $login_out .= '</span>';
        }

        if( class_exists('Car_Subscriber')){
            if ( ! defined( 'ABSPATH' ) ) { exit; }
            $login_out .= '<div class="fl-login-sub-menu">';
            if (!is_user_logged_in()){
                $login_out .= carsubscriber_login_form();

            }
            $login_out .= '</div>';
        } else {
            $login_out .= '<a href="'.esc_url( wp_logout_url( get_permalink() ) ).'" class="fl-logout-links">';
            $login_out .= '<span>'.esc_html__('Logout','car-subscriber').'</span>';
            $login_out .= '</a>';
        }
 
    $login_out .= '</div>';
    return $login_out;
}