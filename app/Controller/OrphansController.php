<?php
/**
 * Comments controller.
 *
 * This controller will only respond to ajax requests.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
require_once(KORA_LIB . "General_Search.php");

class OrphansController extends AppController{

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow("display");
    }

    /**
     * Displays a single orphans with the matching kid
     * @param kid | the kid of the page
     * @return Void
     */
    public function display($kid){

        $pName = parent::convertKIDtoProjectName($kid);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getPageSIDFromProjectName($pName);

        $fields = array('ALL');
        $kora = new General_Search($pid, $sid, 'kid', '=', $kid, $fields);
        $page = json_decode($kora->return_json(), true);

        if( ! empty($page) ){

            $page = $page[$kid];
            $tempArray = array(
                'Image Original Name' => $page['Image_Upload']['originalName'],
                'Image Local Name' => $page['Image_Upload']['localName'],
                'Image Size' => $page['Image_Upload']['size'],
                'Image Type' => $page['Image_Upload']['type']
            );
            $uploadIndex = array_search("Image_Upload",array_keys($page));
            $page = array_slice($page, 0, $uploadIndex, true) +
                $tempArray +
                array_slice($page, $uploadIndex, count($page) - 1, true) ;

            unset(
                $page['kid'],
                $page['pid'],
                $page['schemeID'],
                $page['linkers'],
                $page['systimestamp'],
                $page['recordowner'],
                $page['Image_Upload']
            );
            $this->set('image', KORA_FILES_URI.'p'.$pid."/f".$sid."/".$page['Image Local Name']);
            $this->set('pageMetadata', $page);
            $this->set('pageName', $page['Image Original Name']);
            $this->set('projectName', $pName);
            $this->render("display");

        } else{
            throw new NotFoundException('Page KID Not Found');
        }
    }
}
