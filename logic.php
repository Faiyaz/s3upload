<?php
// Set the error reporting and display
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('html_errors', true);

// Set and define app specific variables
$plupload = '/js/plupload-2.1.2/js/plupload.full.min.js';
$domain = $_SERVER['SERVER_NAME'];
$page = $_SERVER['PHP_SELF'] == '/index.php' ? '' : $_SERVER['PHP_SELF'];
define('SUCCESS_REDIRECT', "http://{$domain}{$page}");

// Get the configuration
$config = require 'config.php';

// AWS specific variables
$aws_access_key = $config['AWS_ACCESS_KEY_ID'];
$aws_secret_key = $config['AWS_SECRET_ACCESS_KEY'];
$bucket = $config['BUCKET'];
$key = '${filename}';
$acl = 'authenticated-read';

// Create the policy
$policy = base64_encode(json_encode(array(
    'expiration' => date('Y-m-d\TH:i:s.000\Z', strtotime('+1 day')),
    'conditions' => array(
        array('bucket' => $bucket),
        array('starts-with', '$key', ''),
        array('acl' => $acl),
        array('starts-with', '$name', ''), // plupload library internally adds this field
        array('starts-with', '$Filename', ''), // plupload library internally adds this field
        array('success_action_redirect' => SUCCESS_REDIRECT)
    )
)));

// Create the signature
$signature = base64_encode(hash_hmac('sha1', $policy, $aws_secret_key, true));
