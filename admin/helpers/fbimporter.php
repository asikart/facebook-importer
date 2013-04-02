<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

include_once dirname(__FILE__).'/../includes/core.php' ;

/**
 * Fbimporter helper.
 */
class FbimporterHelper extends AKProxy
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		$app = JFactory::getApplication() ;
		
		
		JSubMenuHelper::addEntry(
			JText::_('COM_FBIMPORTER_TOOL'),
			'index.php?option=com_fbimporter&view=items',
			$vName == 'items'
		);
		
		$app->triggerEvent( 'onAfterAddSubmenu', array('com_fbimporter.helper' ,$vName) );

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_fbimporter';

		$actions = array(
			'core.admin', 
			'core.manage', 
			'core.create', 
			'core.edit', 
			'core.edit.own', 
			'core.edit.state', 
			'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	/*
	 * function getVersion
	 * @param 
	 */
	
	public static function getVersion()
	{
		return JVERSION ;
	}
}


class FMHelper extends FbimporterHelper
{
	
}
