<?php
App::uses('MetadataEdit', 'Model');
App::uses('MetaResourcesController', 'Controller');
//App::import('Controller', 'Users');
/**
 * Metadata controller.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */

//require_once(KORA_LIB . "General_Search.php");
require_once(KORA_LIB . "Advanced_Search.php");

class MetadataEditsController extends AppController {
    public $name = 'MetadataEdits';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('findAllByUser');
    }

    //I'm calling this from addMetadataEdits() in edit_metadata.js
    public function add() {
        if (!$this->request->is('post')) return $this->json(400);
        $this->request->data['user_id'] = $this->Session->read('Auth.User.id');
        $this->request->data['user_name'] = $this->Session->read('Auth.User.name');

        $pName = parent::convertKIDtoProjectName($this->request->data['resource_kid']);

        if($this->request->data['scheme_id'] == 'project'){
            $this->request->data['scheme_id'] = parent::getProjectSIDFromProjectName($pName);
        }elseif($this->request->data['scheme_id'] == 'Seasons'){
            $this->request->data['scheme_id'] = parent::getSeasonSIDFromProjectName($pName);
        }elseif($this->request->data['scheme_id'] == 'excavations'){
            $this->request->data['scheme_id'] = parent::getSurveySIDProjectName($pName);
        }elseif($this->request->data['scheme_id'] == 'archival objects'){
            $this->request->data['scheme_id'] = parent::getResourceSIDFromProjectName($pName);
        }elseif($this->request->data['scheme_id'] == 'subjects'){
            $this->request->data['scheme_id'] = parent::getSubjectSIDFromProjectName($pName);
        }
        if ($this->MetadataEdit->save($this->request->data)){
            $response['aftersave'] = 'true';
            return $this->json(201);
        }
        else
            return $this->json(400);
    }

    private function _modelExists($modelName){
        $models = App::objects('model');
        return in_array($modelName,$models);
    }

    public function edit($id) {
        if (!($this->request->is('post') || $this->request->is('put')))
            return $this->json(400);
        if ($this->MetadataEdits->add($this->request->data))
            return $this->json(200);
        else
            return $this->json(400);
    }

    /**
     * Find all metadata edits associated with user id
     */
    public function findAllByUser(){
        $model = $this->modelClass;
        $results = $this->$model->find('all', array(
            'conditions' => array(
                'AND' => array('user_id' => $this->request->data['id'], 'MetadataEdit.approved' => '1'),
            )
        ));
        foreach( $results as $key => $edit ){
            $results[$key]['MetadataEdit']['kid'] = $edit['MetadataEdit']['resource_kid'];
            $results[$key] = $results[$key]['MetadataEdit'];
        }
        $this->json(200, $results);
    }

    //single resource frontend edit associators
    public function getAllKidsByScheme(){


        $this->autoRender = false;
        if( $this->request->data['scheme_name'] && $this->request->data['meta_kid'] ) {

            $pName = parent::convertKIDtoProjectName($this->request->data['meta_kid']);
            $sid = '';
            $fields = '';
            if( $this->request->data['scheme_name'] == 'Project Associator' ){
                $sid = parent::getProjectSIDFromProjectName($pName);
                $fields = array('Name','Country','Persistent Name','Modern Name');

            }elseif( $this->request->data['scheme_name'] == 'Season Associator' ){
                $sid = parent::getSeasonSIDFromProjectName($pName);
                $fields = array('Title','Type','Director','Registrar');

            }elseif( $this->request->data['scheme_name'] == 'Excavation - Survey Associator' ){
                $sid = parent::getSurveySIDProjectName($pName);
                $fields = array('Name','Type');

            }elseif( $this->request->data['scheme_name'] == 'Resource Associator' ){
                $sid = parent::getResourceSIDFromProjectName($pName);
                $fields = array('Resource Identifier','Type','Title');

            }elseif( $this->request->data['scheme_name'] == 'Pages Associator' ){
                $sid = parent::getPageSIDFromProjectName($pName);
                $fields = array('Format','Type','Image Upload', 'Resource Identifier');

            }elseif( $this->request->data['scheme_name'] == 'Subject of Observation Associator' ){
                $sid = parent::getSubjectSIDFromProjectName($pName);
                $fields = array('Resource Identifier','Artifact - Structure Location','Artifact - Structure Description');
            }

            //Get the Resources from Kora
            $pid = parent::getPIDFromProjectName($pName);
            $kora = new Advanced_Search($pid, $sid, $fields, 0);
            $kora->add_clause("kid", "!=", "1");

            //do this nonsense so that php will return an array of objects and
            //not an object of objects.
            return json_encode(array_values(json_decode($kora->search(), True)));
        }
        return false;
    }
}
