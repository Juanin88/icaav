<?php
// Conexion a la base de datos. doctrine.local.php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'params' => array(
                    'host' => 'localhost',
                    'port' => 3306,
                    'user' => 'root',
                    'password' => 'root',
                    'dbname' => 'icaav',
                    'driverOptions' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ),
                )
            )
        )
    )
);