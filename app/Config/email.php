<?php
class EmailConfig {
    public $default = array(
	'host' => 'smtp.matrix.msu.edu',
        'transport' => 'smtp',
        'from' => array('arcs@arcs.matrix.msu.edu' => 'ARCS'),
        'log' => true,
	'tls' => true,
    );
}
