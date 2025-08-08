<?php
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../config/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            // echo "Chargement automatique: $file<br>";
            require_once $file;
            return;
        }
    }
    // echo "Class non trouvée : $class<br>";
});
