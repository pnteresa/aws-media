<?php
/**
 * Plugin Name: AWS Media
 * Plugin URI: http://teresa.id
 * Description: OMG Sisdis tolong tolong. Upload media to AWS dan kawan2
 * Version: 1.0.0
 * Author: Teresa Pranyoto
 * Author URI: http://teresa.id
 */

require 'aws-autoloader.php';
use Aws\S3\S3Client;

//
//define('AM_BUCKET_NAME', get_option('amBucketName'));
//define('AM_HOSTNAME', get_option('amHostname'));
//define('AM_ACCESS_KEY', get_option('amAccessKeyId'));
//define('AM_SECRET_ACCESS_KEY', get_option('amSecretAccessKey'));

update_option('upload_url_path', '{endpoint}/{bucket}');

add_filter( 'wp_handle_upload', 'custom_upload_filter');
function custom_upload_filter( $file ) {
    try {
        $bucket = "test-bucket";
        $filepath = $file["file"];
        $keyname = substr($filepath, strrpos($filepath, '/') + 1);

        $s3 = S3Client::factory(array(
            'endpoint' => '*** host ***',
            'region' => 'whatever',
            'version' => '2006-03-01',
            'credentials' => array(
                'key' => '*** key ***',
                'secret' => '*** secret ***'
            )
        ));

        $result = $s3->putObject(array(
            'Bucket' => $bucket,
            'Key'    => $keyname,
            'SourceFile'   => $filepath,
            'ACL'    => 'public-read',
        ));
    }
    catch(Exception $e) {
        print_r($e);
    }
    return $file;
}

// TODO: Delete media

?>