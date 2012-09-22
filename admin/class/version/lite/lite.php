<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */


// no direct access
defined('_JEXEC') or die;

/**
 * Fbimporter Pro plugin
 */
class plgFbimporterLite extends JPlugin
{
	
	/**
	 * Flower before save content method
	 *
	 * Method is called right before content is saved into the database.
	 * Article object is passed by reference, so any changes will be saved!
	 * NOTE:  Returning false will abort the save with an error.
	 *You can set the error by calling $article->setError($message)
	 *
	 * @param	string		The context of the content passed to the plugin.
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @return	bool		If false, abort the save
	 * @since	1.6
	 */
	public function onContentBeforeSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Code Here
		if( FbimporterHelper::_('version.get', 'pro') ){
			return true ;
		}
		
		$option = JRequest::getVar('option') ;
		$view 	= JRequest::getVar('view') ;
		
		if( 'com_fbimporter' == $option && 'item' == $view ){
			$article->fulltext = $article->fulltext . '<br />Powered by <a href="http://demo.asikart.com/fbimporter">Asikart FBImporter</a>.' ;
		}
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	// AKFramework Functions
	// ====================================================================================
	
	
	/**
	 * function call
	 * 
	 * A proxy to call class and functions
	 * Example: $this->call('folder1.folder2.function', $args) ; OR $this->call('folder1.folder2.Class::function', $args)
	 * 
	 * @param	string	$uri	The class or function file path.
	 * 
	 */
	
	public function call( $uri ) {
		// Split paths
		$path = explode( '.' , $uri );
		$func = array_pop($path);
		$func = explode( '::', $func );
		
		// set class name of function name.
		if(isset($func[1])){
			$class_name = $func[0] ;
			$func_name = $func[1] ;
			$file_name = $class_name ;
		}else{
			$class_name = null ;
			$func_name = $func[0] ;
			$file_name = $func_name ;
		}
		
		$func_path 		= implode('/', $path).'/'.$file_name;
		$include_path 	= dirname(__FILE__).'/lib';
		
		// include file.
		if( !function_exists ( $func_name ) && !class_exists($class_name) ) :			
			$file = JPATH_COMPONENT_ADMINISTRATOR.'/class/'.$func_path.'.php' ;
			
			if( !file_exists($file) ) {
				$file = dirname(__FILE__).'/lib/'.$func_path.'.php' ;
			}
			
			if( file_exists($file) ) {
				include_once( $file ) ;
			}
		endif;
		
		// Handle args
		$args = func_get_args();
        array_shift( $args );
        
		// Call Function
		if(isset($class_name) && method_exists( $class_name, $func_name )){
			return call_user_func_array( array( $class_name, $func_name ) , $args );
		}elseif(function_exists ( $func_name )){
			return call_user_func_array( $func_name , $args );
		}
		
	}
	
	
	
	public function includeEvent($func) {
		$include_path = JPATH_ROOT.'/'.$this->params->get('include_path', 'easyset');
		$event = trim($include_path, '/').'/'.'events'.DS.$func.'.php' ;
		if(file_exists( $event )) return $event ;
	}
	
	
	
	public function resultBool($result = array()) {
		foreach( $result as $result ):
			if(!$result) return false ;
		endforeach;
		
		return true ;
	}
	
}
