<?php
$target = realpath(__DIR__ . '/../frontend-user/public/storage');
$link = __DIR__ . '/public/storage';

if (is_link($link)) {
    unlink($link);
}

if (symlink($target, $link)) {
    echo "Symlink created: $link -> $target\n";
} else {
    echo "Failed to create symlink.\n";
}
