<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once JPATH_LIBRARIES . '/windwalker/src/init.php';
JForm::addFieldPath(WINDWALKER_SOURCE . '/Form/Fields');
JFormHelper::loadFieldClass('itemlist');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldFormat_List extends JFormFieldItemlist
{
	/**
	 * The form field type.
	 *
	 * @var string
	 */
	public $type = 'Format_List';

	/**
	 * List name.
	 *
	 * @var string
	 */
	protected $view_list = 'formats';

	/**
	 * Item name.
	 *
	 * @var string
	 */
	protected $view_item = 'format';

	/**
	 * Extension name, eg: com_content.
	 *
	 * @var string
	 */
	protected $extension = 'com_fbimporter';

	/**
	 * Set the published column name in table.
	 *
	 * @var string
	 */
	protected $published_field = 'state';

	/**
	 * Set the ordering column name in table.
	 *
	 * @var string
	 */
	protected $ordering_field = null;
}
