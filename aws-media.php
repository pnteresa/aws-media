<?php
/**
 * Plugin Name: AWS Media
 * Plugin URI: http://teresa.id
 * Description: OMG Sisdis tolong tolong. Upload media to AWS dan kawan2
 * Version: 1.0.0
 * Author: Teresa Pranyoto
 * Author URI: http://teresa.id
 * Based on: https://github.com/discodrive/aws-browser-upload
 */

require 'aws-autoloader.php';
use Aws\S3\S3Client;


if (!function_exists('am_admin_menu')) {
    function am_admin_menu() {
        add_menu_page('AWS Media', 'AWS Media', 'manage_options', 'aws-media', 'am_settings');
    }
}
if (!function_exists('am_settings')) {
    function am_settings() {
        if (! current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include __DIR__ . '/settings.php';
    }
}
add_action('admin_menu', 'am_admin_menu');

$endpoint   = get_option("amHostname");
$bucket = get_option("amBucketName");
$accessKey  = get_option("amAccessKey");
$secretKey  = get_option("amSecretKey");

update_option('upload_url_path', "${endpoint}/${bucket}");

add_filter( 'wp_handle_upload', 'custom_upload_filter');
function custom_upload_filter( $file ) {
    try {
        global $endpoint, $bucket, $accessKey, $secretKey;
        $filepath = $file["file"];
        $keyname = substr($filepath, strrpos($filepath, '/') + 1);

        $s3 = S3Client::factory(array(
            'endpoint' => $endpoint,
            'region' => 'eu-west-1',
            'version' => '2006-03-01',
            'credentials' => array(
                'key' => $accessKey,
                'secret' => $secretKey
            )
        ));

        $result = $s3->putObject(array(
            'Bucket'     => $bucket,
            'Key'        => $keyname,
            'SourceFile' => $filepath,
            'ACL'        => 'public-read',
        ));
    }
    catch(Exception $e) {
        print_r($e);
    }
    return $file;
}

// TODO: Delete media

?>