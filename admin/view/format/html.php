<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\DI\Container;
use Windwalker\Model\Model;
use Windwalker\View\Engine\PhpEngine;
use Windwalker\View\Html\EditView;
use Windwalker\Xul\XulEngine;

// No direct access
defined('_JEXEC') or die;

/**
 * Fbimporter Formats view
 *
 * @since 1.0
 */
class FbimporterViewFormatHtml extends EditView
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
	protected $name = 'format';

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
		parent::prepareData();
	}
}
