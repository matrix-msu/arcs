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
    $this->Auth->allow("display");
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
           'pid' => $page->getPageAttribute("pid"),
           'Scheme Id' => $page->getPageAttribute("schemeID"),
           'linkers' => $page->getPageAttribute("linkers"),
           'System Timestamp' => $page->getPageAttribute("systimestamp"),
           'Record Owner' => $page->getPageAttribute("recordowner"),
           'Resource Identifier' => $page->getPageAttribute("Resource Identifier"),
           'Format' => $page->getPageAttribute("Format"),
           'Type' => $page->getPageAttribute("Type"),
           'Page Identifier' => $page->getPageAttribute("Page Identifier"),
           'Scan Number' => $page->getPageAttribute("Scan Number"),
           'Image Original Name' => $page->getPageAttribute("Image Upload",'originalName'),
           'Image Local Name' => $page->getPageAttribute("Image Upload","localName"),
           'Image Size' => $page->getPageAttribute("Image Upload","size"),
           'Image Type' => $page->getPageAttribute("Image Upload","type"),
           'Resource systimestamp Associator' => $page->getPageAttribute("Resourcesystimestamp Associator"),
           'Scan Specifications' => $page->getPageAttribute("Scan Specifications"),
           'Scan Equipment' => $page->getPageAttribute("Scan Equipment"),
           'Scan Date Month' => $page->getPageAttribute("Scan Date","month"),
           'Scan Date Day' => $page->getPageAttribute("Scan Date","day"),
           'Scan Date Year' => $page->getPageAttribute("Scan Date","year"),
           'Scan Date Era' => $page->getPageAttribute("Scan Date","era"),
           'Scan Date Prefix' => $page->getPageAttribute("Scan Date","prefix"),
           'Scan Date Suffix' => $page->getPageAttribute("Scan Date","suffix"),
           'Scan Creator Status' => $page->getPageAttribute("Scan Creator Status"),
           'Scan Creator' => $page->getPageAttribute("Scan Creator"),
           'Orphan' => $page->getPageAttribute("Orphan"),
           'ID' => $page->getPageAttribute("id"),
           'Legacy' => $page->getPageAttribute("Legacy"),
           'Display' => $page->getPageAttribute("Display"),
           
         )
       )
     ); 
     $this->render("display");  
   }
   else
     throw new NotFoundException('Page KID Not Found');
  }
  
  
}
