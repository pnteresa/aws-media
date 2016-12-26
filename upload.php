<html>
<head>
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.7.19.min.js"></script>
</head>
<body>

<script>
    function upload(file) {
        var accessKey = "B7SUJYA1XB1JX5EYXA58";
        var secretKey = "h1APjqCBu31eZvMqfGZWPseZkq8vJoxUeFjcGt3n";
        var bucketName = "test-bucket";
        var hostname = "s3.pranyoto.sisdis.ui.ac.id";

        var s3 = new AWS.S3({
            accessKeyId: accessKey,
            secretAccessKey:  secretKey,
            sslEnabled: true,
            endpoint: hostname,
            s3ForcePathStyle: true,
            s3BucketEndpoint: false,
            params: {Bucket: bucketName}
        });

        s3.upload({
            Key: file.name,
            Body: file,
            ACL: 'public-read',
            Bucket: bucketName
        }, function(err,data) {
            if (s3.upload) {
                if(err) {
                    console.log('There was an error uploading your file', err.message);
                    return;
                }
                ajaxRequest(data);
                alert('Successfully uploaded file.');
            } else {
                alert('The filesize is too large, please upload a smaller file.');
            }
        }).send(function(err, data) { console.log(err, data) });
    }

    function get(url) {
        var blob = null;
        var xhr = new XMLHttpRequest();
        var filename = url.substring(url.lastIndexOf("/") + 1, url.length);

        $.post( ".php",  } );

        xhr.open("GET", url);
        xhr.send();
        xhr.responseType = "blob";
        xhr.onload = function()
        {
            blob = xhr.response;
            var f = new File([blob], filename);
            upload(f);
        }

    }
</script>

<?php

$file = 'testFile.txt';
$current = file_get_contents($file);
$url = $_POST["url"];
$cmd = "<script>get('".$url."')</script>";
$current .= $cmd."\n";

// Write the contents back to the file
file_put_contents($file, $current);
echo $cmd;
?>
</body>
</html>

