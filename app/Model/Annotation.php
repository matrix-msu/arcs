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
        "page_kid", "relation_id", "resource_kid", "relation_resource_kid", 'relation_page_kid', 'relation_resource_name', 'resource_name', 'user_id', 'user_name', 'user_email', 'user_username', 'url', 'transcript', 'incoming', 'x1', 'y1', 'x2', 'y2', 'order_transcript'
    );
    /**
     * Find all meta-resources
     */
    public function findAll()
    {
        $model = $this->modelClass;
        $results = $this->$model->find('all', array(
            'conditions' => array('page_kid' => $this->request->data['id'])
        ));
        $this->json(200, $results);
    }
}
