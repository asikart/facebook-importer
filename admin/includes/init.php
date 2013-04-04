<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_fbimporter
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

$doc 	= JFactory::getDocument();
$app 	= JFactory::getApplication();
$lang 	= JFactory::getLanguage();
$params = JComponentHelper::getParams('com_fbimporter') ;



// Define
// ========================================================================
define('FBIMPORTER_SITE' , JPATH_COMPONENT_SITE );
define('FBIMPORTER_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);
define('FBIMPORTER_SELF' , JPATH_COMPONENT);



// Include Helpers
// ========================================================================

// Core init, it can use by module, plugin or other component.
include_once JPath::clean( JPATH_ADMINISTRATOR . "/components/com_fbimporter/includes/core.php" ) ;

if( $app->isSite() ){
	$lang->load('', JPATH_ADMINISTRATOR);
	$lang->load('com_fbimporter', FBIMPORTER_ADMIN );
}else{
	FbimporterHelper::_('lang.loadAll', $lang->getTag());
	FbimporterHelper::_('include.sortedStyle', 'includes/css');
}

// Detect version
FbimporterHelper::_('plugin.attachPlugins');

// Enable CCK Engine
JForm::addFieldPath(AKPATH_FORM.'/fields/cck');

// Debug
define('AKDEBUG', FbimporterHelper::_('system.getConfig', 'system.debug')) ;