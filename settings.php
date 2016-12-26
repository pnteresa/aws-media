<?php
$settings = ['amBucketName', 'amHostname', 'amAccessKey', 'amSecretKey'];

// Loop through the array
for ($i = 0; $i < count($settings); $i++) {
    // If an option is set, assign it to a variable
    if (get_option($settings[$i])) {
        $$settings[$i] = get_option($settings[$i]);
    }

    if (isset($_POST[$settings[$i]]) && wp_verify_nonce( $_POST['_wpnonce'])) {
        update_option($settings[$i], $_POST[$settings[$i]]);
    }
}


?>
<div class="wrap">
    <h2>AWS Media Settings</h2>

    <form action="" method="post">
        <?php wp_nonce_field(); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="amBucketName">Bucket Name</label></th>
                <td>
                    <input type="text" name="amBucketName" value="<?php echo $amBucketName; ?>" id="amBucketName" class="regular-text"/>
                    <p class="description">The name of your bucket exactly as it appears on AWS S3</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="amHostname">Hostname/Endpoint</label></th>
                <td>
                    <input type="text" name="amHostname" value="<?php echo $amHostname; ?>" id="amHostname" class="regular-text"/>
                    <p class="description">The full hostname e.g. "https://s3.pranyoto.sisdis.ui.ac.id"</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="amAccessKey">Access Key</label></th>
                <td>
                    <input type="text" name="amAccessKey" value="<?php echo $amAccessKey; ?>" id="amAccessKey" class="regular-text"/>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="amSecretKey">Access Key Secret</label></th>
                <td>
                    <input type="text" name="amSecretKey" value="<?php echo $amSecretKey; ?>" id="amSecretKey" class="regular-text"/>
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <p class="submit"><input type="submit" value="Save Settings" class="button button-primary"></p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>