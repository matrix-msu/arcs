<?php
class EmailConfig {
    public $default = array(
	    'host' => 'smtp.matrix.msu.edu',
        'transport' => 'smtp',
        'from' => array('arcs@arcs.matrix.msu.edu' => 'ARCS'),
        'log' => true,
	    'tls' => true,
    );
    public $smtp = array(
        'transport' => 'Smtp',
        'from' => array('arcs@matrix.msu.edu' => 'ARCS'),
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'timeout' => 30,
        'username' => 'arcs.matrix.msu@gmail.com',
        'password' => 'VrS_aR_-F_UzS2LF',
        'client' => null,
        'log' => true,
        'charset' => 'utf-8',
        'headerCharset' => 'utf-8',
        'tls' => true

    );
}
