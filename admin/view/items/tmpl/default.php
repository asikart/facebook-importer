<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\View\Layout\FileLayout;

// No direct access
defined('_JEXEC') or die;

// Prepare script
JHtmlBootstrap::tooltip();
JHtmlFormbehavior::chosen('select');
JHtmlDropdown::init();

/**
 * Prepare data for this template.
 *
 * @var Windwalker\DI\Container $container
 */
$container = $this->getContainer();
?>

<div id="fbimporter" class="windwalker items tablelist row-fluid">
	<form action="<?php echo JURI::getInstance(); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

		<?php if (!empty($this->data->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<h4 class="page-header"><?php echo JText::_('JOPTION_MENUS'); ?></h4>
			<?php echo $this->data->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
		<?php else: ?>
		<div id="j-main-container">
		<?php endif;?>

			<?php echo $this->loadTemplate('table'); ?>

			<!-- Hidden Inputs -->
			<div id="hidden-inputs">

				<input type="hidden" name="combined_sample" value="" />
				<input type="hidden" name="combined_catid" value="" />
				<input type="hidden" name="combined_sort" value="" />
				<input type="hidden" name="combined_dir" value="" />

				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<?php echo JHtml::_('form.token'); ?>
			</div>

			<p></p>
			<p align="center"><?php echo JText::_('COM_FBIMPORTER_COPY_RIGHT'); ?></p>

			<?php echo $this->loadTemplate('import_modal'); ?>

		</div>
	</form>
</div>
