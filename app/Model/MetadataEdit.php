<?php
/**
 * MetadaEdits model
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class MetadataEdit extends AppModel {

    public $name = 'MetadataEdit';

    public $useTable = 'metadata_edits';

    //public $belongsTo = array('Resource');

    public $whitelist = array('resource_kid', 'resource_name', 'scheme_id', 'control_type', 'user_id', 'field_name', 'value_before',
                              'new_value', 'approved', 'rejected', 'reason_rejected', 'metadata_kid');

    /**
     * Store a piece of metadata for a resource.
     *
     * @param string $rid
     * @param string $attr
     * @param string $val
     */
    public function store($rid, $attr) {
        $existing = $this->find('first', array(
            'conditions' => array(
                'resource_kid' => $rid//,
                //'attribute' => $attr
        )));
        return $this->save(array(
            'MetadataEdit' => array(
                'id' => $existing ? $existing['MetadaEdit']['id'] : null,
                'resource_kid' => 'stringresourceid'//,
                //'attribute' => $attr,
                //'scheme_id' => '1'
        )));
    }
}