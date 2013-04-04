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

include_once AKPATH_COMPONENT.'/viewitem.php' ;

/**
 * View to edit
 */
class FbimporterViewFormat extends AKViewItem
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected 	$text_prefix = 'COM_FBIMPORTER';
	protected 	$items;
	protected 	$pagination;
	protected 	$state;
	
	public		$option 	= 'com_fbimporter' ;
	public		$list_name 	= 'formats' ;
	public		$item_name 	= 'format' ;
	public		$sort_fields ;
	
	

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->fields_group = $this->get('FieldsGroup');
		$this->fields	= $this->get('FieldsName');
		$this->canDo	= AKHelper::getActions($this->option);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::displayWithPanel($tpl) ;
	}

	
	
	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		AKToolBarHelper::title( JText::_('COM_FBIMPORTER') .': '. JText::_('COM_FBIMPORTER_EDIT_IMPORT_FORMAT'), 'article-add.png');
		
		parent::addToolbar();
	}
	
	
	
	/*
	 * function handleFields
	 * @param 
	 */
	
	public function handleFields()
	{
		$form = $this->form ;
		
		parent::handleFields();
		
		// for Joomla! 3.0
		if(JVERSION >= 3) {
			
			// $form->removeField('name', 'fields');
			
		}else{
			
			// $form->removeField('name', 'fields');
			
		}
		
	}
}
