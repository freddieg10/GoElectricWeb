jQuery.noConflict()(function($) {

    "use strict";
    let $window = window;

// Register
$window.initRegisterFormOption = function(){
    let header_register = $('.fl-dropdown-register'),
        header_login = $('.fl-dropdown-login');
    header_register.on('click', function(){
        if($(this).hasClass('open')) {
            $(this).removeClass('open');
        }
        else{
            $(this).addClass('open');
        }
        if(header_login.hasClass('open')){
            header_login.removeClass('open');
        }
    });
};

//Register Form
$window.initRegisterFormOptionFunction = function(){
    let header_sub_menu_login = $('.fl-login-form-entry'),
        $body =  $('body'),
        login_sub_menu = $('.fl-login-sub-menu');
    function register_form_display() {
        header_sub_menu_login.removeClass('login-in').removeClass('loading').addClass('register');
    }
    function login_form_display() {
        header_sub_menu_login.removeClass('register').addClass('login-in').removeClass('loading');
    }
    function login_form_display_on_click() {
        if(login_sub_menu.hasClass('opened') && header_sub_menu_login.hasClass('register')){
            header_sub_menu_login.removeClass('register').removeClass('loading').addClass('login-in');
        } else if(login_sub_menu.hasClass('opened')){
            login_sub_menu.removeClass('opened');
        } else {
            if(header_sub_menu_login.hasClass('register')){
                header_sub_menu_login.removeClass('register').addClass('login-in');
            }
            login_sub_menu.addClass('opened');
        }
    }
    function register_form_display_on_click() {
        if(login_sub_menu.hasClass('opened') && header_sub_menu_login.hasClass('login-in')){
            header_sub_menu_login.removeClass('login-in').removeClass('loading').addClass('register');
        } else if(login_sub_menu.hasClass('opened')){
            login_sub_menu.removeClass('opened');
        } else {
            if(header_sub_menu_login.hasClass('login-in')){
                header_sub_menu_login.removeClass('login-in').addClass('register');
            }
            login_sub_menu.addClass('opened');
        }
    }

    $body.on('click','.fl-login-sub-menu a.registration-link',  function(e){
        header_sub_menu_login.addClass('loading');
        setTimeout(register_form_display, 700);
        e.preventDefault();
    });
    $body.on('click','.fl-login-sub-menu a.login-in-link',  function(e){
        header_sub_menu_login.addClass('loading');
        setTimeout(login_form_display, 700);
        e.preventDefault();
    });

    $body.on('click','.fl-login-register--header .fl-dropdown-login',  function(e){
        if(login_sub_menu.hasClass('opened') && header_sub_menu_login.hasClass('register')){
            header_sub_menu_login.addClass('loading');
        }
        setTimeout(login_form_display_on_click, 100);
        e.preventDefault();
    });
    $body.on('click','.fl-login-register--header .fl-dropdown-register',  function(e){
        if(login_sub_menu.hasClass('opened') && header_sub_menu_login.hasClass('login-in')){
            header_sub_menu_login.addClass('loading');
        }
        setTimeout(register_form_display_on_click, 100);
        e.preventDefault();
    });
};



    let initCustomFunction = function(){

        // Register
        initRegisterFormOption();
        // Register Form
        initRegisterFormOptionFunction();

    };

    $(document).ready(function(){
        initCustomFunction();
        if($window && typeof parent.vc != 'undefined' && typeof parent.vc.events != 'undefined') {
            parent.vc.events.on('shortcodeView:ready', function() {
                setTimeout(initVcCustomFunction, 200);
            });
        }
    });

});
