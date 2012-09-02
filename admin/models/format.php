<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Fbimporter model.
 */
class FbimporterModelformat extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_FBIMPORTER';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Format', $prefix = 'FbimporterTable', $config = array())
	{
		return parent::getTable( $type , $prefix , $config );
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_fbimporter.format', 'format', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_fbimporter.edit.format.data', array());

		if (empty($data)) 
		{
			$data = $this->getItem();
		}else{
			$data = new JObject($data);
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {

			//Do any procesing on fields here if needed
			$item->text = $item->introtext . '<hr id="system-readmore" />' . $item->fulltext ;
		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');
		
		$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$user 	= JFactory::getUser() ;
		$db 	= JFactory::getDbo();
		
		$jform = $_REQUEST['jform'];
		$text = explode( '<hr id="system-readmore" />', $jform['text']) ;
		
		$table->introtext = $text[0] ;
		$table->fulltext  = $text[1] ;
		
		// ordering
		if (!$table->id) {
			// Set ordering to the last item if not set
			if (!$table->ordering) {
				$db->setQuery('SELECT MAX(ordering) FROM #__fbimporter_formats');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}

}