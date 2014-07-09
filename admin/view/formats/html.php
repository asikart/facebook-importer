<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\DI\Container;
use Windwalker\Model\Model;
use Windwalker\View\Engine\PhpEngine;
use Windwalker\View\Html\GridView;
use Windwalker\Xul\XulEngine;

// No direct access
defined('_JEXEC') or die;

/**
 * Fbimporter Formats View
 *
 * @since 1.0
 */
class FbimporterViewFormatsHtml extends GridView
{
	/**
	 * The component prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'fbimporter';

	/**
	 * The component option name.
	 *
	 * @var string
	 */
	protected $option = 'com_fbimporter';

	/**
	 * The text prefix for translate.
	 *
	 * @var  string
	 */
	protected $textPrefix = 'COM_FBIMPORTER';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $name = 'formats';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'format';

	/**
	 * The list name.
	 *
	 * @var  string
	 */
	protected $viewList = 'formats';

	/**
	 * Method to instantiate the view.
	 *
	 * @param Model            $model     The model object.
	 * @param Container        $container DI Container.
	 * @param array            $config    View config.
	 * @param SplPriorityQueue $paths     Paths queue.
	 */
	public function __construct(Model $model = null, Container $container = null, $config = array(), \SplPriorityQueue $paths = null)
	{
		$config['grid'] = array(
			// Some basic setting
			'option'    => 'com_fbimporter',
			'view_name' => 'format',
			'view_item' => 'format',
			'view_list' => 'formats',

			// Column which we allow to drag sort
			'order_column'   => 'format.catid, format.ordering',

			// Table id
			'order_table_id' => 'formatList',

			// Ignore user access, allow all.
			'ignore_access'  => false
		);

		// Directly use php engine
		$this->engine = new PhpEngine;

		parent::__construct($model, $container, $config, $paths);
	}

	/**
	 * Prepare data hook.
	 *
	 * @return  void
	 */
	protected function prepareData()
	{
	}

	/**
	 * Configure the toolbar button set.
	 *
	 * @param   array   $buttonSet Customize button set.
	 * @param   object  $canDo     Access object.
	 *
	 * @return  array
	 */
	protected function configureToolbar($buttonSet = array(), $canDo = null)
	{
		// Get default button set.
		$buttonSet = parent::configureToolbar($buttonSet, $canDo);

		// In debug mode, we remove trash button but use delete button instead.
		if (JDEBUG)
		{
			$buttonSet['trash']['access']  = false;
			$buttonSet['delete']['access'] = true;
		}

		return $buttonSet;
	}
}
