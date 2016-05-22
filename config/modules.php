<?php

/**
 * Register application modules
 */
$application->registerModules(array(
    'frontend' => array(
        'className' => 'Webdinhdalat\Frontend\Module',
        'path' => __DIR__ . '/../apps/frontend/Module.php'
    ),
    'backend' => array(
        'className'=>'Webdinhdalat\Backend\Module',
        'path'=> __DIR__ . '/../apps/backend/Module.php'
    )
));
