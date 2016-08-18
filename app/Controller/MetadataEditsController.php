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
        if (!$this->request->is('post')) return $this->json(400);
        $this->request->data['user_id'] = $this->Session->read('Auth.User.id');
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
    public function findAllByUser()
    {
        $model = $this->modelClass;
        $results = $this->$model->find('all', array(
            'conditions' => array('user_id' => $this->request->data['id'])
        ));
        $this->json(200, $results);
    }

    //single resource frontend edit associators
    public function getAllKidsByScheme()
    {
        //require_once(KORA_LIB . "Metadata_Associator_Search.php");
        if( $this->request->data['scheme_name'] ) {
            $sid = '';
            $fields = '';
            if( $this->request->data['scheme_name'] == 'Project Associator' ){
                $sid = PROJECT_SID;
                $fields = 'Name,Country,Persistent Name,Modern Name';
            }elseif( $this->request->data['scheme_name'] == 'Season Associator' ){
                $sid = SEASON_SID;
                $fields = 'Title,Type,Director,Registrar';
            }elseif( $this->request->data['scheme_name'] == 'Excavation - Survey Associator' ){
                $sid = SURVEY_SID;
                $fields = 'Name,Type';
            }elseif( $this->request->data['scheme_name'] == 'Resource Associator' ){
                $sid = RESOURCE_SID;
                $fields = 'Resource Identifier,Type,Title';
            }elseif( $this->request->data['scheme_name'] == 'Pages Associator' ){
                $sid = PAGES_SID;
                $fields = 'Format,Type,Image Upload';
            }elseif( $this->request->data['scheme_name'] == 'Subject of Observation Associator' ){
                $sid = SUBJECT_SID;
                $fields = 'Resource Identifier,Artifact - Structure Location,Artifact - Structure Description';
            }

            //Get the Resources from Kora
            $query = "kid,!=,1";
            
            //$temp_array['resource_query'] = $query;
            $user = "";
            $pass = "";
            $display = "json";
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".
                urlencode($query)."&fields=".urlencode($fields);
            //$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query);
            //$temp_array['resource_url'] = $url;
            ///initialize post request to KORA API using curl
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $scheme = json_decode(curl_exec($ch), true);

            //TODO get the search working.
            //$kora = new Metadata_Associator_Search($sid);
            //$results['kora'] = $kora;
            //$kora->print_json();

            //$this->json(200);
            $this->json(200, $scheme);
        }
    }
}
