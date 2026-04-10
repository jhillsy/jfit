<?php
// Log the webhook request
error_log("Webhook received at " . date('Y-m-d H:i:s'));

// Change to the repository directory
chdir('/home6/joshhill/public_html/jfit');

// Execute git pull
$output = shell_exec('git pull origin main 2>&1');

// Log the result
error_log("Git pull output: " . $output);

// Return success
http_response_code(200);
echo "OK";
?>
