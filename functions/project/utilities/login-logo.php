<?php 
/**
 *  Custtom login
 *  @author: Eli
 */
function my_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logos/wp-admin.png);
            height: 80px;
            width: 235px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
            background-size: contain;
            margin-bottom: 0;
            padding: 0;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');
?>