<?php require 'logic.php' ?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>S3 Direct Upload</title>
    <script src="js/plupload.full.min.js"></script>
</head>
<body>
<div class="container"><h1>S3Upload - with progress report</h1>

    <ul id="filelist"></ul>
    <br />

    <div id="container">
        <a id="browse" href="javascript:;">[Browse...]</a>
        <a id="start-upload" href="javascript:;">[Start Upload]</a>
    </div>

    <br />
    <pre id="console"></pre></div>
<script>
    var uploader = new plupload.Uploader({

        browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
        // General settings
        runtimes : 'html5,flash,silverlight',

        flash_swf_url : 'js/plupload-2.1.2/js/Moxie.swf',
        silverlight_xap_url : 'js/plupload-2.1.2/js/Moxie.xap',

        // S3 specific settings
        url : 'http://fh-s3uploads.s3.amazonaws.com/',

        multipart_params: {
            'key': '${filename}', // use filename as a key
            'Filename': '${filename}', // adding this to keep consistency across the runtimes
            'acl': '<?php echo $acl ?>',
            'success_action_redirect': '<?php echo SUCCESS_REDIRECT; ?>',
            'AWSAccessKeyId' : '<?php echo $aws_access_key; ?>',
            'policy': '<?php echo $policy; ?>',
            'signature': '<?php echo $signature; ?>'
        }
    });

    uploader.init();


    uploader.bind('FilesAdded', function(up, files) {
        var html = '';
        plupload.each(files, function(file) {
            if (up.files.length > 1) {
                up.removeFile(file);
            }
            html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
        });
        document.getElementById('filelist').innerHTML += html;
    });

    uploader.bind('UploadProgress', function(up, file) {
        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    });

    uploader.bind('Error', function(up, err) {
        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
    });

    document.getElementById('start-upload').onclick = function() {
        uploader.start();
    };
</script>
</body>
</html>