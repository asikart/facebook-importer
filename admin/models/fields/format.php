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
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'Format';
	
	protected function getOptions()
	{
		// Initialise variables.
        $options = array();
        $name = (string) $this->element['name'];
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$q->select('*')
			->from('#__fbimporter_formats')
			->where('published >= 1')
			;
		
		$db->setQuery($q);
		$formats = $db->loadObjectList();
		
		foreach( $formats as $format ):
			$options[] = JHtml::_('select.option', $format->id, $format->title );
		endforeach;
		
		return $options;
	}
	
}