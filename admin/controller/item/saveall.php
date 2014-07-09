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
class FbimporterControllerItemSaveall extends \Windwalker\Controller\Admin\AbstractRedirectController
{
	/**
	 * Method to run this controller.
	 *
	 * @throws  Exception
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$model = $this->getModel();

		$items = $this->input->getVar('item', array());
		$cid = $this->input->getVar('cid', array());

		try
		{
			$model->saveAll($items, $cid);

			$msg = '匯入成功';
		}
		catch (\Exception $e)
		{
			$msg = $e->getMessage();

			if (JDEBUG)
			{
				throw $e;
			}
		}

		$this->redirect('index.php?option=com_fbimporter', $msg);
	}
}
 