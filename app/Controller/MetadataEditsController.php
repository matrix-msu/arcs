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
class MetadataEditsController extends MetaResourcesController {
    public $name = 'MetadataEdits';

    public function beforeFilter() {
        parent::beforeFilter();
        // if (!$this->request->is('ajax')) {
            // return $this->redirect('/400');
        // }
    }

    //I'm calling this from addMetadataEdits() on the single resource page- on page load.
    public function add() {
        //$response['hello'] = 'testing';
        //return $this->json(200, $response);
        //if($this->_modelExists('MetadataEdit')){
        //do model exists logic
            //$response['type'] = '1';
        //} else {
        //do other logic
          //  $response['type'] = '0';
        //}
        //var_dump($this->MetadataEdit);
        //$response['models'] = App::objects('model');
        //$response['controller_name'] = $this->name;
        //$response['get_name'] = $this->MetadataEdit->getName();
        //$response['name'] = $this->MetadataEdit->name;
        //$response['MetadataEdits'] = $this->MetadataEdit;
        //return $this->json(200, $response);
        if (!$this->request->is('post')) return $this->json(400);
        $this->request->data['user_id'] = $this->Session->read('Auth.User.id');
        //$response['request']  = $this->request->data;
        //$response['request_type']  = gettype($this->request->data);
        //$UsersController = new UsersController;

        //$response['user']  = $UsersController;
        //$response['user_session']  = $UsersController->session;
        //$response['user_session_2']  = $this->Session->read('Auth.User.id');
        //$response['meta_session']  = $this->Session;
        //$retval['datatype']  = gettype($this->request->data);
        /*
        $savedata_array['resource_kid'] = $this->request->data['resource_kid'];
        $savedata_array['scheme_name'] = $this->request->data['scheme_name'];
        $savedata_array['field_name'] = $this->request->data['field_name'];
        $savedata_array['user_id'] = $this->request->data['user_id'];
        $savedata_array['resource_name'] = $this->request->data['resource_name'];
        $savedata_array['value_before'] = $this->request->data['value_before'];
        $savedata_array['new_value'] = 'testing.new_value';
        $savedata_array['approved'] = decbin(1);
        $savedata_array['rejected'] = decbin(0);
        $savedata_array['reason_rejected'] = 'who knows testing';

        $savedata_array['scheme_id'] = 5;
        //$save_array['MetadataEdit'] = $savedata_array;
        $response['save_data'] = $savedata_array;
        //$retval['debug'] = $this->MetadataEdits->validationErrors;
        */

        //$retval['name']  = $this->MetadataEdits->name;
        //return $this->json(200, $response);
        // add resource_name, user_id, user_name, user_email, user_username
        /*
        return $this->json(200, $this->MetadataEdits->find('list', array(
            'fields' => array('Metadata_edits.id', 'Metadata_edits.resource_kid', 'Metadata_edits.user_id')
        )));
        */
        //if ($this->MetadataEdits->add($save_array))
        //if ($this->MetadataEdits->save(array($this->MetadataEdits->name => $save_array)))
            //return $this->json(200, $save_array);
        //debug($this->MetadataEdits->validationErrors);
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
}
