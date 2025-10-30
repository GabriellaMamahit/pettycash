<?php
// Autoload PSR SimpleCache dummy (if not installed)
if (!interface_exists('Psr\\SimpleCache\\CacheInterface')) {
    $psrCache = APPPATH . 'third_party/Psr/SimpleCache/CacheInterface.php';
    if (file_exists($psrCache)) {
        require_once $psrCache;
    }
}

// Autoloader sederhana untuk PhpSpreadsheet manual install
spl_autoload_register(function ($class) {
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = __DIR__ . '/src/PhpSpreadsheet/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});