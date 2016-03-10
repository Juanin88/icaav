<?php
// Conexion a la base de datos. doctrine.local.php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'params' => array(
                    'host' => '192.168.20.4',
                    'port' => 3306,
                    'user' => 'dbadmin',
                    'password' => 'a1s2d3f4',
                    'dbname' => 'zf_demo',
                    'driverOptions' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ),
                )
            )
        )
    )
);