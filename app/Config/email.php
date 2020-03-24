<?php
class EmailConfig {
    public $default = array(
	    'host' => 'smtp.matrix.msu.edu',
        'transport' => 'smtp',
        'from' => array('arcs@gmail.com' => 'ARCS'),
        'log' => true,
	    'tls' => true,
    );
    public $smtp = array(
        'transport' => 'Smtp',
        'from' => array('arcs@gmail.com' => 'ARCS'),
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'timeout' => 30,
        'username' => 'arcs@gmail.com',
        'password' => '',
        'client' => null,
        'log' => true,
        'charset' => 'utf-8',
        'headerCharset' => 'utf-8',
        'tls' => true

    );
}
