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
class FbimporterControllerItemSavecombine extends \Windwalker\Controller\Admin\AbstractRedirectController
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

		$state = $model->getState();

		$state->set('combined.sample', $this->input->get('combined_sample'));
		$state->set('combined.catid', $this->input->get('combined_catid'));
		$state->set('combined.sort', $this->input->get('combined_sort'));
		$state->set('combined.dir', $this->input->get('combined_dir'));

		try
		{
			$model->saveAsCombined($items, $cid);
		}
		catch (\Exception $e)
		{
			if (JDEBUG)
			{
				throw $e;
			}
		}

		$this->redirect( 'index.php?option=com_content&task=article.edit&id=' . $model->getState()->get('content.id'));
	}
}
 