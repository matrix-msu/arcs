<?php
App::uses('AppController', 'Controller');
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
require_once(LIB . "Kora/Class/Page.php");

class OrphansController extends AppController {

  public function beforeFilter() {
    parent::beforeFilter();
  }
  /**
     * Displays a single orphans with the matching kid
   * @param kid | the kid of the page
   * @return Void
   */
  public function display($kid){

   $page = new Page($kid, PAGES_SID);
   
   if($page->doesExist()){
     //render single page orhpans

     $image = $page->getPageAttribute('Image Upload')['localName'];
     $thumb = $this->largeThumb($image);
 
     $this->set(
       array(
         'pageName'=>$page->getPageAttribute("kid"),
         'image' => $thumb,
         'pageMetadata' => array(
            'kid' => $page->getPageAttribute("kid"),
            'Record Owner' => $page->getPageAttribute("recordowner"),
            'Scan Number' => $page->getPageAttribute("Scan Number"),
         )
       )
     ); 
     $this->render("display");  
   }
   else
     throw new NotFoundException('Page KID Not Found');
  }
  
  
}
