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

include_once AKPATH_COMPONENT.'/viewlist.php' ;

/**
 * View class for a list of Fbimporter.
 */
class FbimporterViewFormats extends AKViewList
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
	public	 	$no_trash 	= false ;
	public		$sort_fields ;

	
	
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->filter		= $this->get('Filter');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		parent::displayWithPanel($tpl);
	}

	
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		// Set title.
		AKToolBarHelper::title( JText::_('COM_FBIMPORTER') .': '. JText::_('COM_FBIMPORTER_IMPORT_FORMAT_SETTING'), 'article.png');
		
		parent::addToolbar();
	}
	
	
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		$ordering_key = $this->state->get('items.nested') ? 'a.lft' : 'a.ordering' ;
		
		$this->sort_fields = array(
			$ordering_key 		=> JText::_('JGRID_HEADING_ORDERING'),
			'a.published' 		=> JText::_('JPUBLISHED'),
			'a.title' 			=> JText::_('JGLOBAL_TITLE'),
			'b.title' 			=> JText::_('JCATEGORY'),
			'd.title' 			=> JText::_('JGRID_HEADING_ACCESS'),
			'a.created_by' 		=> JText::_('JAUTHOR'),
			'e.title' 			=> JText::_('JGRID_HEADING_LANGUAGE'),
			'a.created' 		=> JText::_('JDATE'),
			'a.id' 				=> JText::_('JGRID_HEADING_ID')
		);
		
		return $this->sort_fields ;
	}
	
	
}
