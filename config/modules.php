<?php

/**
 * Register application modules
 */
$application->registerModules(array(
    'frontend' => array(
        'className' => 'Webdinhdalat\Frontend\Module',
        'path' => __DIR__ . '/../apps/frontend/Module.php'
    )
));
