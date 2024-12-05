<?php
try {
    echo bin2hex(random_bytes(32));
} catch (\Random\RandomException $e) {
    echo "Error generating key: " . $e->getMessage();
}
?>
