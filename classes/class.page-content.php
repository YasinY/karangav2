<?php
@include('class.json-data.php');
class PageContent {

/**
 * Generates the page content after user has triggered the menuitem
 *
 **/
function create_page_content() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <head>
        </head>
        <link rel="stylesheet" href="<?php echo KARANGA_CSS_FILES_URL . 'page-content.css'; ?>">
        <h2><?php _e("Manage Request configurations") ?></h2>
        <div class="wrapper">
        <form action="options.php" method="post">
            <?php settings_fields('user_data'); ?>
            <?php wp_nonce_field('handle_data', 'isengard'); ?>
                    <p>Username:</p>
                    <input type="text" name="username" value="<?php echo (get_option('username') == '') ? 'test' : get_option('username'); ?>" />
                    <p>Password:</p>
                    <input type="text" name="password" value="<?php echo (get_option('password') == '') ? 'test1234567' : get_option('password'); ?>" />
                    <p>Api Link:</p>
                    <input type="text" name="api_url" class="api_url" value="<?php echo (get_option('api_url') == '') ? 'http://192.168.1.173/otto-karanga/kapi/list' : get_option('api_url'); ?>" />
                    <p></p>
                    <input type="submit" name="save_data" class="button-primary" value="Save Data" />
                    <hr />
                    <input type="submit" name="update_galleries" class="button-primary" value="Request galleries" />
        </form>

        </div>
        <h2>Gallerien</h2>
        <?php
        echo '<div class="galleries-wrapper">'; //Wrapper
        $jsonFiles = glob(JSON_DIRECTORY_PATH . '*.json');
        foreach ($jsonFiles as $jsonFile) {
            $content = json_decode(file_get_contents($jsonFile), true);
            $imageLink = (isset($content['outfits'][0]['images']['outfit']['file']) ? $content['outfits'][0]['images']['outfit']['file'] : "None");
            $name = (isset($content['gallery']['name']) ? $content['gallery']['name'] : "None");
            if($name == "None" || $imageLink == "None")
                continue;
                echo '<div class="gallery-image-wrapper">'; //Imagewrapper
                echo '<img class="gallery-image" src="' . $imageLink . '">';
                echo '<p class="gallery-title">' . $name . '</p>';
                echo '</div>';
        }
        echo '</div>';
        
    
    }

}

?>