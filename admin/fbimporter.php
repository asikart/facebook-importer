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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_fbimporter')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// init
include_once 'includes'.DS.'init.php';

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JController::getInstance('Fbimporter');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
