<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    // ...
    'module_layouts' => array(
       'Album'       => 'layoutAlbum/layout.phtml',
       'Admin'       => 'layoutAdmin/layout.phtml',
       'Index'       => 'layout/layout.phtml',
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => '192.168.20.4',
                    'port'     => '3306',
                    'user'     => 'suite_aplicativo',
                    'password' => 'Apli$uite&11',
                    'dbname'   => 'icaav_facturacion',
                )
            )
        )
    ),/*
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => '127.0.0.1',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'RAOR940203',
                    'dbname'   => 'zf_demo',
                )
            )
        )
    ),*/
);
