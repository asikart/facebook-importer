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

jimport('joomla.application.component.view');

/**
 * View class for a list of Fbimporter.
 */
class FbimporterViewItems extends JView
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

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
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

		JToolBarHelper::title(JText::_('COM_FBIMPORTER_TITLE_ITEMS'), 'article.png');

        //Check if the form exists before showing the add/edit buttons
       

		if ($canDo->get('core.create')) {
			JToolBarHelper::custom( 'item.saveAll' , 'new' , 'new' , '匯入' , true ) ;
			//JToolBarHelper::custom( 'fb.saveAsWeekly' , 'publish' , 'publish' , '匯入至一週精選' , true ) ;
			JToolBarHelper::divider();
			JToolBarHelper::custom( 'items.refresh' , 'refresh' , 'refresh' , '刷新' , false);
		}
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_fbimporter');
		}
	}
}
