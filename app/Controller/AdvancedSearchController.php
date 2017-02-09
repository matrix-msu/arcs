<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 28/06/16
 * Time: 11:33 AM
 */

class AdvancedSearchController extends AppController {
 
  public function initialize()
  {
    parent::initialize();
  }
  public function beforeFilter()
  {
    parent::beforeFilter();
    $this->Auth->allow(
      array(
        'display',
        'search'
      )
    );
  }
    
  /**
   * Display the advanced search page
   * @param string $query
   */
  public function display($query = '')
  {
    $title = 'Advanced Search';
    if ($query) $title .= ' - ' . urldecode($query);
      $this->set('title_for_layout', $title);
    $this->render('/AdvancedSearch/advancedsearch');
  }
  public function search($query = NULL){
    $this->autoRender = false;
    if(empty($query))
      throw new NotFoundException("Query was NOT set");

  }

}
