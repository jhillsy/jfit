<?php
// Simple webhook receiver for GitHub deployments
$secret = 'amber'; // Optional: set a secret in GitHub webhook too

// Verify the webhook came from GitHub (optional but recommended)
if (!empty($secret)) {
    $signature = isset($_SERVER['HTTP_X_HUB_SIGNATURE_256']) ? $_SERVER['HTTP_X_HUB_SIGNATURE_256'] : '';
    $payload = file_get_contents('php://input');
    $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

    if (!hash_equals($hash, $signature)) {
        http_response_code(403);
        die('Invalid signature');
    }
}

// Execute git pull
$output = shell_exec('cd /home6/joshhill/public_html/jfit && git pull 2>&1');
file_put_contents('/home6/joshhill/public_html/jfit/deploy.log', date('Y-m-d H:i:s') . " - " . $output . "\n", FILE_APPEND);

http_response_code(200);
echo "Deployment successful\n";
?>
