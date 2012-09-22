<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$lang = JFactory::getLanguage();

// define
define('FBIMPORTER_SITE' , JPATH_COMPONENT_SITE ) ;
define('FBIMPORTER_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);

//include joomla api
jimport('joomla.application.component.controller');
jimport('joomla.application.component.controllerform');
jimport('joomla.application.component.controlleradmin');

jimport('joomla.application.component.view');

jimport('joomla.application.component.modeladmin');
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.modelitem');

jimport('joomla.html.toolbar');

// include Component Custom class
include_once JPath::clean( FBIMPORTER_ADMIN."/class/viewpanel.class.php" ) ;
include_once JPath::clean( FBIMPORTER_ADMIN."/helpers/aktext.php" ) ;
include_once JPath::clean( FBIMPORTER_ADMIN."/helpers/toolbar.php" ) ;
include_once JPath::clean( JPATH_ADMINISTRATOR."/includes/toolbar.php" ) ;

if( $app->isSite() ){
	include_once JPath::clean( FBIMPORTER_ADMIN."/helpers/fbimporter.php" ) ;
	$lang->load('', JPATH_ADMINISTRATOR);
	$lang->load('com_fbimporter', FBIMPORTER_ADMIN );
}else{
	include_once JPath::clean( FBIMPORTER_ADMIN."/helpers/fbimporter.php" ) ;
}

// set Base to fix toolbar anchor bug
$doc->setBase( JFactory::getURI()->toString() );

// include css
$doc->addStyleSheet('administrator/templates/bluestork/css/template.css');

// version
FbimporterHelper::_('version.detectVersion');