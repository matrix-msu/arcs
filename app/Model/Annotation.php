<?php
/**
 * Annotation model
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class Annotation extends AppModel {
    public $name = 'Annotation';
    public $belongsTo = array('Resource', 'User');
    public $whitelist = array(
        'resource_id', 'resource_name', 'user_id', 'user_name', 'user_email', 'user_username', 'relation', 'url', 'transcript', 'x1', 'y1', 'x2', 'y2'
    );
}
