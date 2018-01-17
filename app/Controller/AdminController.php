<?php
App::uses('ConnectionManager', 'Model');
/**
 * Admin controller.
 *
 * This is largely a read-only group of views. Admin actions are carried out
 * through ajax requests to the proper controller actions on the client-side.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class AdminController extends AppController {
    public $name = 'Admin';
    public $uses = array(
        'User',
        'Flag',
        'Mapping',
        'Collection',
        'MetadataEdit',
        'Comment',
        'Keyword',
        'Annotation'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Access->isAdmin()) {
            $this->Session->setFlash('You must be an Admin to access the Admin ' .
                ' console.', 'flash_error');
            $this->redirect('/');
        }

        $mappings = $this->Mapping->find('all', array(
            'conditions' => array(
                'Mapping.role' => 'Admin',
                'Mapping.id_user' => $this->Auth->user('id'),
                'Mapping.status' => 'confirmed'
            )
        ));
        if( empty($mappings) ){
            $this->Session->setFlash('You must be an Admin to access the Admin ' .
                ' console.', 'flash_error');
            $this->redirect('/');
            die;
        }
        $first = true;

        if( isset($this->request->params['pass']) && !empty($this->request->params['pass']) ){
            $_SESSION['currentProjectName'] = $this->request->params['pass'][0];
        }

        if( isset($_SESSION['currentProjectName']) ){
            $first = false;
        }

        $projectPicker = '<select id="projectSelect" class="styled-select" style="color:rgb(124, 124, 124) !important;margin-top:200px" >';

        foreach ($mappings as $map) {
            $name = parent::getProjectNameFromPID($map['Mapping']['pid']);
            if ($name != '') {
                if( $first == true ){
                    $_SESSION['currentProjectName'] = $name;
                }
                if ($_SESSION['currentProjectName'] == $name) {
                    $first = false;
                    $projectPicker .= '<option selected="selected" disabled="" hidden="" value="" class="">' . $name . '</option>';
                } else {
                    $url = '/'.BASE_URL.'admintools/'.$this->request->params['action']."/".$name;
                    $projectPicker .= "<option value='" . $url . "' label='$name'>$name</option>";
                }
            }
        }
        $projectPicker .= "</select>";

        $url = '/'.BASE_URL.'admintools/'.$this->request->params['action']."/".$_SESSION['currentProjectName'];
        if( $_SERVER['REQUEST_URI']!=$url && $_SERVER['REQUEST_URI']!=$url.'/' ){
            echo '<script>window.location.replace("'.$url.'");</script>';
        }
        $script = '<script>
                    window.onload = function(){
                        $("#projectSelect").change(function(){
                            window.location.replace(this.value);
                        })
                    }
                </script>';
        echo $projectPicker;
        echo $script;
    }

    /**
     * Displays information about the system configuration.
     */
    public function status() {
        $this->set('core', array(
            'debug' => Configure::read('debug'),
            'database' => @ConnectionManager::getDataSource('default')
        ));
        $uploads_path = Configure::read('uploads.path');
        $this->set('uploads', array(
            'url' => Configure::read('uploads.url'),
            'path' => $uploads_path,
            'exists' => is_dir($uploads_path),
            'writable' => is_writable($uploads_path),
            'executable' => is_executable($uploads_path)
        ));
        clearstatcache();
        $ghostscript = '/usr/bin/gs';
        $this->set('dependencies', array(

            'Ghostscript' => is_executable($ghostscript),
            'Imagemagick' => class_exists('Imagick')
        ));
    }

    /**
     * Displays the error and debug logs.
     */
    public function logs() {
        $this->set(array(
            'error'  => @file_get_contents(LOGS . 'error.log'),
            'debug'  => @file_get_contents(LOGS . 'debug.log'),
            'worker' => @file_get_contents(LOGS . 'worker.log'),
            'relic'  => @file_get_contents(LOGS . 'relic.log')
        ));
    }

    /**
     * Add, edit, and delete users.
     */
    public function users() {
        $this->User->recursive = -1;
        $this->User->flatten = true;
        $this->set('users', $this->User->find('all', array(
            'order' => 'User.created'
        )));
    }

    /**
     * View resource and collection flags.
     */
    public function flags() {
        $this->set('flags', $this->Flag->find('all', array(
            'order' => 'Flag.created DESC'
        )));
    }

    public function metadata_edits(){
        $this->set('metadata', $this->MetadataEdit->find('all', array(
        )));
    }

    /**
     * View and re-run jobs.
     */
    public function jobs() {
        $this->set('jobs', $this->Job->find('all', array(
            'order' => 'Job.created DESC'
        )));
    }

    /**
     * Stats
     */
    public function stats() {
        $this->set(array(
            'user_count' => $this->User->find('count'),
            'resource_count' => $this->Resource->find('count'),
            'collection_count' => $this->Collection->find('count'),
            'metadatum_count' => $this->Metadatum->find('count'),
            'comment_count' => $this->Comment->find('count'),
            'annotation_count' => $this->Annotation->find('count'),
            'keyword_count' => $this->Keyword->find('count'),
            'flag_count' => $this->Flag->find('count')
        ));
    }

    /**
     * Additional admin tools
     */
    public function tools() {
    }
}
