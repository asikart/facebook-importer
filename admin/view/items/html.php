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
 * Fbimporter Items View
 *
 * @since 1.0
 */
class FbimporterViewItemsHtml extends GridView
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
	protected $name = 'items';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'item';

	/**
	 * The list name.
	 *
	 * @var  string
	 */
	protected $viewList = 'items';

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
			'view_name' => 'item',
			'view_item' => 'item',
			'view_list' => 'items',

			// Column which we allow to drag sort
			'order_column'   => 'item.catid, item.ordering',

			// Table id
			'order_table_id' => 'itemList',

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
		$data = $this->data;

		$data->formats = $this->get('Formats');
		$data->format_form = $this->get('FormatForm');
		$data->params = \Windwalker\System\ExtensionHelper::getParams('com_fbimporter');
	}

	/**
	 * setTitle
	 *
	 * @param string $title
	 * @param string $icons
	 *
	 * @return  void
	 */
	protected function setTitle($title = null, $icons = 'stack article')
	{
		parent::setTitle(JText::_('COM_FBIMPORTER'), $icons);
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
		$buttonSet = array();

		$buttonSet['import_per_item'] = array(
			'handler' => function()
				{
					JToolBarHelper::custom( 'item.saveall' , 'new' , 'new' , 'COM_FBIMPORTER_IMPORT' , true );
				},
			'access' => 'core.create',
			'priority' => 1000
		);

		$buttonSet['import_as_one_article'] = array(
			'handler' => function()
				{
					\Windwalker\Helper\ModalHelper::modal('saveAsCombinedModal');

					$bar = JToolbar::getInstance('toolbar');

					$option = array(
						'class' => 'btn btn-small btn-success toolbar' ,
						'icon' 	=> 'icon-new icon-white'
					);

					$title = JText::_('COM_FBIMPORTER_IMPORT_AS_COMBINED') ;

					$dhtml = \Windwalker\Helper\ModalHelper::modalLink($title, 'saveAsCombinedModal', $option);

					$bar->appendButton('Custom', $dhtml, 'new');
				},
			'access' => 'core.create',
			'priority' => 800
		);

		$buttonSet['refresh'] = array(
			'handler' => function()
				{
					JToolBarHelper::custom( 'items.refresh' , 'refresh' , 'refresh' , 'COM_FBIMPORTER_REFRESH' , false);
				},
			'priority' => 600
		);

		$buttonSet['option'] = array(
			'handler' => 'preferences',
			'access'   => 'core.edit',
			'priority' => 100
		);

		return $buttonSet;
	}
}
