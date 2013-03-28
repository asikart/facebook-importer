<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Fbimporter records.
 */
class FbimporterModelItems extends JModelList
{

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'filter_order_Dir', 'filter_order', 
				'search' , 'filter',
				'import_num'
            );
		}
		
		$this->config = $config ;
		
		$this->temp = JPATH_CACHE.'/fb-importer-temp' ;
		
        parent::__construct($config);
    }


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_fbimporter');
		$this->setState('params', $params);
		
		
		foreach( $this->filter_fields as $field ){
			$this->setState($field, $app->getUserStateFromRequest($this->context.'.field.'.$field, $field) );
		}

		// List state information.
		parent::populateState('a.id', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('search');
		$id.= ':' . $this->getState('filter');

		return parent::getStoreId($id);
	}
	
	
	public function getFilter()
	{
		// Get filter inputs from from xml files in /models/form.
		JForm::addFormPath(FBIMPORTER_ADMIN.'/models/forms');
        JForm::addFieldPath(FBIMPORTER_ADMIN.'/models/fields');
		
		// load forms
		$form['search'] = JForm::getInstance('com_fbimporter.items.search', 'items_search', array( 'control' => 'search' ,'load_data'=>'true'));
		$form['filter'] = JForm::getInstance('com_fbimporter.items.filter', 'items_filter', array( 'control' => 'filter' ,'load_data'=>'true'));
		
		// Get default data of this form. Any State key same as form key will auto match.
		$form['search']->bind( $this->getState('search') );
		$form['filter']->bind( $this->getState('filter') );
		
		return $form;
	}
	
	/*
	 * function getItems
	 * @param $pks
	 */
	
	public function getItems() {
		
		$db = JFactory::getDbo() ;
		$q = $db->getQuery(true) ;
		$params = $this->getState('params');
		$temp = $this->temp ;
		$date = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		
		$r = '' ;
		
		if( JFile::exists($temp) )
			$r = JFile::read( $temp ) ;
		$r = json_decode($r) ;
		
		if( isset($r->data) ){
				
			foreach( $r->data as $key => &$item ){
			
				$item = new JObject($item);
				$item->continue = false ;
		
				if( !property_exists($item, 'message') ){
					unset($r->data[$key]);
					$item->continue = true ;
					continue ;
				}


				// set title
				$item->message = nl2br($item->message);
				$item->message = explode( '<br />' , $item->message );
				$item->title   = $title = $item->message;
				//AK::show($item->title) ;
				
				// set message and id
				$item->message = implode( '<br />' , $item->message );
				$item->id = explode( '_' , $item->id );
				$item->id = $item->id[1] ;
			
				// set category
				$escape = "[]{}()$^.*?-=+&%#!" ;
				
				$lft 	= $params->get('category_match_left');
				$rgt	= $params->get('category_match_right');
				
				if( strpos( $escape ,$lft) !== false ){
					$lft = '\\'.$lft ;
				}
				
				if( strpos( $escape ,$rgt ) !== false ){
					$rgt = '\\'.$rgt ;
				}
				
				//$regex 	= "/{$lft}(.*){$rgt}(.*)/" ;
				//preg_match( $regex, trim($title), $matches ); // get cat name
				
				$item->catid = null ;
				
				if(isset($matches[1]) && $matches[2]){
					$category_name 	= $matches[1] ;
					
					$q->select('id')
						->from('#__categories')
						->where("title='{$category_name}'")
						->where("extension='com_content'")
						;
					$db->setQuery($q);
					$result = $db->loadResult();
					
					if($result){
						$item->catid 	= $result ;
						$item->title 	= trim($matches[2]) ;
						$item->cat_name = $category_name ;
					}
					
				}else{
					// if not match, continue
					if($params->get('category_not_match_continue'))
						$item->continue = true ;
				}
				
				// title max char
				$max = $params->get('title_max_char') ;
				if($max){
					if(JString::strlen($item->title) > $max){
						$item->message = JString::substr( $item->title, $max )."\n\n".$item->message;
						$title = JString::substr( $item->title, 0, $max );
						
						$title 		= explode( ' ', $title ) ;
						$last_word 	= array_pop($title);
						if($last_word && JString::strlen($last_word) < 10 ) {
							$item->message = $last_word.$item->message ;
						}else{
							$title[] = $last_word ;
						}
						
						$item->title = implode(' ', $title);
					}
				}
				
				// get date & alias
				$q->clear();

				$item->date 	= JFactory::getDate( $item->created_time , JFactory::getConfig()->get('offset') );
				
				$item->alias 	= JFilterOutput::stringURLSafe($item->title. ' ' . $item->date->format('Y-m-d-H-i-s', true) ) ;
				
				$q->select('id')
					->from('#__content')
					->where("alias = '{$item->alias}'")
					;
				$db->setQuery($q);
				$itemid = $db->loadResult();
				$q->clear();
				$item->exists = $itemid ;
				
			}

			return $r->data ;
		}else{
			return array();
		}
	}
	
	/*
	 * function refresh
	 * @param $arg
	 */
	
	public function refresh() {
		JLoader::import( 'includes.facebook.facebook' , FBIMPORTER_ADMIN ) ;
		
		$nowTime = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') )->toUnix(true) ;
		$fromTime = JFactory::getDate( '2012-03-25' , JFactory::getConfig()->get('offset') )->toUnix() ;
		$temp = $this->temp ;
		
		$params = $this->getState('params');
		
		$config = array();
		$config['appId'] =  $params->get( 'app_id', '420381114686923');
		$config['secret'] = $params->get( 'secret', 'e5fcb4294864136013ae747090b07778');
		
		$fb = new Facebook($config);
		//$user = $fb->api('/animapp') ;
		
		
		$limit = $this->getState( 'import_num' , 50 );
		
		$params = $this->getState('params');
		$uid = $params->get('fb_uid', 'facebook');
		
		$r = $fb->api("/{$uid}/posts?limit=" . $limit );
		
		JPath::setPermissions( $temp );
		JFile::write( $temp , json_encode($r) );
		JFile::write( $temp.'X.txt' , print_r($r, 1) );
	}
}
