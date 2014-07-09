<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Fbimporter helper.
 *
 * @since 1.0
 */
abstract class FbimporterHelper
{
	/**
	 * Configure the Link bar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_FBIMPORTER_TOOL'),
			'index.php?option=com_fbimporter&view=items',
			($vName == 'items')
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_FBIMPORTER_FORMAT_SETTING'),
			'index.php?option=com_fbimporter&view=formats',
			($vName == 'formats')
		);

		$dispatcher = \JEventDispatcher::getInstance();
		$dispatcher->trigger('onAfterAddSubmenu', array('com_fbimporter', $vName));
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   string  $option  Action option.
	 *
	 * @return  JObject
	 */
	public static function getActions($option = 'com_fbimporter')
	{
		$user   = JFactory::getUser();
		$result = new \JObject;

		$actions = array(
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.edit.own',
			'core.edit.state',
			'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $option));
		}

		return $result;
	}
}
