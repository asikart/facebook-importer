<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Fbimporter model.
 */
class FbimporterModelitem extends JModelLegacy
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_FBIMPORTER';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Item', $prefix = 'FbimporterTable', $config = array())
	{
		return parent::getTable( $type , $prefix , $config );
	}
	
	/*
	 * function saveAsShare
	 * @param $
	 */
	
	public function saveAll() {
		$items 	= JRequest::getVar('item') ;
		$ids 	= JRequest::getVar('cid') ;
		$table 	= JTable::getInstance('content') ;
		$format = $this->getTable('Format') ;
		$this->params = JComponentHelper::getParams('com_fbimporter');
		
		// if sort by current, reverse ids
		/*
		if( $this->params->get('sort_by_current', 0) ){
			$ids = array_reverse($ids) ;
		}
		*/
		
		$temp = JPATH_ROOT.'/cache/fb-importer-temp';
		
		$r = '' ;
		
		if( JFile::exists($temp) )
			$r = JFile::read( $temp ) ;
		$r = json_decode($r) ;
		
		if( isset($r->data) ){
				
			foreach( $r->data as $key => &$item ){
			
				$item = new JObject($item);

				$item->id = explode( '_' , $item->id );
				$item->id = $item->id[1] ;
				
				if (isset($items[$item->id])) {
					$items[$item->id]['type'] = $item->type;
					$items[$item->id]['name'] = isset($item->name) ? $item->name : '';
					$items[$item->id]['picture'] = base64_encode(isset($item->picture) ? $item->picture : '');
					$items[$item->id]['link'] = base64_encode(isset($item->link) ? $item->link : '');
					$items[$item->id]['source'] = base64_encode(isset($item->source) ? $item->source : '');
					$items[$item->id]['likes'] = $item->likes->summary->total_count;
					$items[$item->id]['created'] = $item->created_time;
				}
				
			}
		}
		else {
			$this->setError(JText::_('COM_FBIMPORTER_CANNOT_GET_DATA'));
			return false ;
		}
		
		foreach( $ids as $id ):
			// reset article
			$table->id = null ;
			$table->created 		= null ;
			$table->publish_up 	= null ;
			$table->publish_down 	= null ;
			
			// get item
			$item = $items[$id] ;
			
			$date = JFactory::getDate( $item['created'] , JFactory::getConfig()->get('offset') ) ;
			
			// get format
			$sample = isset($item['format']) ? $item['format'] : $this->params->get('format', 1) ;
			
			$format->load($sample) ;
			
			if(!$format){
				$this->setError(JText::_('COM_FBIMPORTER_CANNOT_GET_IMPORT_FORMAT'));
				return false ;
			}
			
			
			// set article information
			
			
			$table->title	  = $item['title'] ;
			$table->catid	  = $item['catid'] ? $item['catid'] : $format->catid ;
			$table->introtext = $this->replaceText($item, $format->introtext) ;
			$table->fulltext  = $this->replaceText($item, $format->fulltext) ;
			//$table->introtext = strtr( $sample_intro , $replace ) ;
			//$table->fulltext  = strtr( $sample_full , $replace ) ;
			$table->created	  = $this->params->get('sort_by_current', 0) ? JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') )->toSQL(true) : $date->toSQL(true) ;
			$table->alias 	  = JFilterOutput::stringURLSafe($table->title . ' ' . $date->format('Y-m-d-H-i-s', true) ) ;
			$table->state	  = $format->published ;
			$table->hits 	  = 0 ;
			$table->created_by= JFactory::getUser()->get('id') ;
			$table->language  = $format->language ;
			
			// save
			$app = JFactory::getApplication();
			
			$app->triggerEvent('onContentBeforeSave', array('com_content.form', $table, true) ) ;
			$table->store();
			$app->triggerEvent('onContentAfterSave', array('com_content.form', $table, true) ) ;
			
		endforeach;
		
		return true ;
	}
	
	
	/*
	 * function saveAsCombined
	 * @param $arg
	 */
	
	public function saveAsCombined() {
		$this->params = JComponentHelper::getParams('com_fbimporter');
		$items 	= JRequest::getVar('item') ;
		$cids 	= JRequest::getVar('cid') ;
		$format = $this->getTable('Format') ;
		$table 	= JTable::getInstance('Content') ;
		$sample = JRequest::getVar('combined_sample',  $this->params->get('combined_sample', 2) ) ;
		$this->params = JComponentHelper::getParams('com_fbimporter');
		
		$format->load($sample) ;
		
		if(!$format){
			$this->setError(JText::_('COM_FBIMPORTER_CANNOT_GET_IMPORT_FORMAT'));
			return false ;
		}
		
		$catid	= JRequest::getVar('combined_catid', $this->params->get('combined_catid', $format->catid)) ;
		
		$sample_intro 	= $format->introtext ;
		$sample_full 	= $format->fulltext ;
		
		
		$temp = JPATH_ROOT.'/cache/fb-importer-temp';
		
		$r = '' ;
		
		if( JFile::exists($temp) )
			$r = JFile::read( $temp ) ;
		$r = json_decode($r) ;
		
		if( isset($r->data) ){
				
			foreach( $r->data as $key => &$item ){
			
				$item = new JObject($item);

				$item->id = explode( '_' , $item->id );
				$item->id = $item->id[1] ;
				
				if (isset($items[$item->id])) {
					$items[$item->id]['type'] = $item->type;
					$items[$item->id]['name'] = isset($item->name) ? $item->name : '';
					$items[$item->id]['picture'] = base64_encode(isset($item->picture) ? $item->picture : '');
					$items[$item->id]['link'] = base64_encode(isset($item->link) ? $item->link : '');
					$items[$item->id]['source'] = base64_encode(isset($item->source) ? $item->source : '');
					$items[$item->id]['likes'] = $item->likes->summary->total_count;
					$items[$item->id]['created'] = $item->created_time;
				}
				
			}
		}
		else {
			$this->setError(JText::_('COM_FBIMPORTER_CANNOT_GET_DATA'));
			return false ;
		}
		
		
		// Sort
		// ========================================================================
		$ids = array() ;
		foreach( $cids as $cid ):
			
			$key = JRequest::getVar('combined_sort', $this->params->get('combined_sort', 'likes')) ;
			$ids[$cid] = $items[$cid][$key] ;
			
		endforeach;
		
		if( JRequest::getVar('combined_dir', $this->params->get('combined_dir', 'desc')) == 'desc' ) {
			asort($ids) ;
		}else{
			arsort($ids);
		}
		
		
		$posts = array();
		foreach( $ids as $cid => $id ):
			
			// get item
			$item = $items[$cid] ;
			

			
			$posts[] = $this->replaceText( $item, $sample_full, $cid ) ;
		endforeach;
		
		// reset article
		$table->id = null ;
		$table->created 		= null ;
		$table->published_up 	= null ;
		$table->published_down 	= null ;
		
		$table->title	  = $this->params->get('combined_article_title',  'A Combined Article') ;
		$table->alias 	  = JFilterOutput::stringURLSafe('content-from-facebook-' . uniqid() ) ;
		$table->introtext = $sample_intro ;
		$table->fulltext  = implode( "\n" , $posts ) ;
		$table->state	  = 0 ;
		$table->hits 	  = 0 ;
		$table->catid	  = $catid ;
		$table->created_by= JFactory::getUser()->get('id') ;
		
		$table->store();
		
		return $table->id ;
	}
	
	
	/*
	 * function replaceText
	 * @param $text
	 */
	
	public function replaceText($item, $text, $id)
	{
		$date = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		
		// video type
		$link 		= base64_decode($item['link']) ; 
		$r 			= $this->handleVideoType($link) ;
		$platform 	= $r['platform'] ;
		$vid 		= $r['vid'] ;
		
		// handel message
		$message = nl2br($item['message']) ;
		$message = str_replace( "\n" , '' , $message );
		$message = str_replace( "\r" , '' , $message );
		$message = explode( '<br /><br />' , $message );
		$intro	 = array_shift($message) ;
		$full    = implode( '<br /><br />' , $message);
		
		// handle image
		$uri 	= JFactory::getURI( base64_decode($item['picture']) ) ;
		$width	= $this->params->get('image_width', 550) ;
		$image 	= $uri->getVar('url');
		
		if(!$image){
			$image = str_replace('_s.', '_n.', base64_decode($item['picture'])) ;
		}
		
		$width = $width ? $width.'px' : '' ;
		$image = '<img src="'.$image.'" alt="'.$item['title'].'" style="max-width: '.$width.';" />' ;
		
		// set replaces
		$replace['{TITLE}'] 		= $item['title'] ;
		$replace['{VIDEO}'] 		= $vid ? "{{$platform}}$vid{/{$platform}}" : $vid ;
		$replace['{INTRO_MESSAGE}'] = $this->addLink( $intro ) ;
		$replace['{IMAGE}']			= $image ;
		$replace['{LINK_URL}']		= $link ;
		$replace['{FULL_MESSAGE}'] 	= $this->addLink( $full ) ;
		$replace['{READMORE_LINK}'] = "http://www.facebook.com/".$this->params->get('fb_uid')."/posts/$id" ;
		$replace['{LINK_NAME}']		= $item['name'] ;
		$replace['{LIKES}']			= $item['likes'] ;
		$replace['{CREATED_TIME}']	= $date->toSQL(true) ;
		
		$text = strtr($text, $replace) ;
		
		return $text ;
	}
	
	
	
	/*
	 * function handleVideoType
	 * @param $link
	 */
	
	public function handleVideoType($link) {
		
		if( strpos( $link , 'youtube' ) ){
			$platform = 'youtube' ;
			$uri = JFactory::getURI( $link) ;
			$vid = $uri->getVar('v') ;
		}elseif( strpos( $link , 'vimeo' ) ){
			$platform = 'vimeo' ;
			$uri = JFactory::getURI($link) ;
			$vid = $uri->getPath();
			$vid = trim( $vid , '/' );
		}else{
			$platform = 'unknown' ;
			$vid = null ;
		}
		
		$r['platform'] = $platform ;
		$r['vid'] = $vid ;
		return $r ;
	}
	
	/*
	 * function addLink
	 * @param $arg
	 */
	
	function addLink($str) {

		$str = preg_replace('#(http|https|ftp|telnet)://([0-9a-z\.\-]+)(:?[0-9]*)([0-9a-z\_\/\?\&\=\%\.\;\#\-\~\+]*)#i','<a href="\1://\2\3\4" target="_blank" >\1://\2\3\4</a>', $str);
		
		return $str;
	}
}