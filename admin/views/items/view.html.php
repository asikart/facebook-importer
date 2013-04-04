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

include_once AKPATH_COMPONENT.'/viewlist.php' ;

/**
 * View class for a list of Fbimporter.
 */
class FbimporterViewItems extends AKViewList
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');

		//$this->pagination	= $this->get('Pagination');
		$this->filter		= $this->get('Filter');
		$this->formats		= $this->get('Formats');
		
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
		$state	= $this->get('State');
		$canDo	= FbimporterHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_FBIMPORTER'), 'fbimporter.png');
		
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration( ' .icon-48-fbimporter { background-image: url(components/com_fbimporter/images/ak-fbimporter-logo-48.png) ; } ' );

        //Check if the form exists before showing the add/edit buttons
       

		if ($canDo->get('core.create')) {
			JToolBarHelper::custom( 'item.saveAll' , 'new' , 'new' , 'COM_FBIMPORTER_IMPORT' , true ) ;
			// JToolBarHelper::custom( 'item.saveAsCombined' , 'new' , 'new' , 'COM_FBIMPORTER_IMPORT_AS_COMBINED' , true ) ;
			// AKToolBarHelper::modal( 'COM_FBIMPORTER_IMPORT_AS_COMBINED', 'saveAsCombinedModal' ) ;
			$this->addSaveAsCombinedButton('COM_FBIMPORTER_IMPORT_AS_COMBINED', 'saveAsCombinedModal' );
			JToolBarHelper::divider();
			JToolBarHelper::custom( 'items.refresh' , 'refresh' , 'refresh' , 'COM_FBIMPORTER_REFRESH' , false);
		}
		
		if ($canDo->get('core.admin')) {
			AKToolBarHelper::preferences('com_fbimporter');
		}
	}
	
	
	/*
	 * function addSaveAsCombinedButton
	 * @param 
	 */
	
	public function addSaveAsCombinedButton()
	{
		AKHelper::_('ui.modal', 'saveAsCombinedModal') ;
		$bar 	= JToolbar::getInstance('toolbar');
		$title  = JText::_($title);
		
		$option = array(
			'class' => 'btn btn-small btn-success' ,
			'icon' 	=> 'icon-new icon-white'
		);
		
		$dhtml	= AKHelper::_('ui.modalLink', JText::_('COM_FBIMPORTER_IMPORT_AS_COMBINED'), 'saveAsCombinedModal', $option) ;
		$bar->appendButton('Custom', $dhtml, 'batch');	
	}
}
