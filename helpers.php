<?php

function isCurrentPage(string $path): bool {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentPath === $path || str_starts_with($currentPath, $path . '/');
} 