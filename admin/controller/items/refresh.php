<?php
/**
 * Part of joomla3304 project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class FbimporterControllerItemsRefresh
 *
 * @since 1.0
 */
class FbimporterControllerItemsRefresh extends \Windwalker\Controller\Admin\AbstractRedirectController
{
	/**
	 * Method to run this controller.
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$this->getModel()->refresh();

		$this->redirect('index.php?option=com_fbimporter');
	}
}
 