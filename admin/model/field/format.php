<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldFormat extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var	string
	 */
	public $type = 'Format';

	/**
	 * Property value.
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * Property name.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * getOptions
	 *
	 * @return  array
	 */
	protected function getOptions()
	{
		// Initialise variables.
        $options = array();
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$q->select('*')
			->from('#__fbimporter_formats')
			->where('published >= 1')
			;
		
		$db->setQuery($q);

		$formats = $db->loadObjectList();
		$formats = $formats ? $formats : array() ;
		
		foreach($formats as $format)
		{
			$options[] = JHtml::_('select.option', $format->id, $format->title );
		}
		
		return $options;
	}
}