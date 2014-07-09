<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtmlBootstrap::tooltip();
JHtmlFormbehavior::chosen('select');
JHtmlBehavior::formvalidation();

/**
 * Prepare data for this template.
 *
 * @var $container Windwalker\DI\Container
 * @var $data      Windwalker\Data\Data
 * @var $item      \stdClass
 */
$container = $this->getContainer();
$form      = $data->form;
$item      = $data->item;

$fieldsets = $data->form->getFieldsets();
?>
<!-- Validate Script -->
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'format.edit.cancel' || document.formvalidator.isValid(document.id('adminForm')))
		{
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}
</script>

<div id="fbimporter" class="windwalker format edit-form row-fluid">
	<form action="<?php echo JURI::getInstance(); ?>"  method="post" name="adminForm" id="adminForm"
		class="form-validate" enctype="multipart/form-data">

		<div class="row-fluid">
			<div class="span8">
				<?php echo $this->loadTemplate('fieldset', array('fieldset' => $fieldsets['information'], 'class' => 'form-horizontal')); ?>
			</div>

			<div class="span4">
				<?php echo $this->loadTemplate('fieldset', array('fieldset' => $fieldsets['publish'], 'class' => 'form-horizontal')); ?>

				<?php echo $this->loadTemplate('quickinsert'); ?>
			</div>
		</div>

		<!-- Hidden Inputs -->
		<div id="hidden-inputs">
			<input type="hidden" name="option" value="com_fbimporter" />
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>

