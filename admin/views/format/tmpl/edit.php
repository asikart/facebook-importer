<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'format.cancel' || document.formvalidator.isValid(document.id('format-form'))) {
			Joomla.submitform(task, document.getElementById('format-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div class="<?php echo JVERSION >= 3 ? 'joomla30' : 'joomla25'; ?>">

<form action="<?php echo JRoute::_( JFactory::getURI()->toString() ); ?>" method="post" name="adminForm" id="format-form" class="form-validate">
	<div class="row-fluid">
		<div class="<?php echo JVERSION < 3 ? 'width-60 fltlft' : 'span8'; ?>">
			<fieldset class="adminform">
				<legend><?php echo JText::_('COM_FBIMPORTER_BASIC_CONTENT'); ?></legend>
				
				<?php foreach($this->form->getFieldset('information') as $field ): ?>
					<div class="control-group">
						<?php echo $field->label; ?>
						<div class="controls">
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</fieldset>
		</div>
		
		<div class="<?php echo JVERSION < 3 ? 'width-40 fltlft' : 'span4'; ?>">
			<fieldset class="adminform">
				<legend><?php echo JText::_('COM_FBIMPORTER_OTHER_SETTING'); ?></legend>
				
				<?php foreach($this->form->getFieldset('created') as $field ): ?>
					<div class="control-group">
						<?php echo $field->label; ?>
						<div class="controls">
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</fieldset>
		</div>
		
		<div class="<?php echo JVERSION < 3 ? 'width-40 fltlft' : 'span4'; ?>">
			<fieldset class="adminform form-horizontal">
				<legend><?php echo JText::_('COM_FBIMPORTER_CAN_BE_INSERTED_PARAMS'); ?></legend>
				<p></p>
				<p><?php echo JText::_('COM_FBIMPORTER_CLICK_AND_INSERT'); ?></p>

					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{TITLE}', 'jform_basic_text')">{TITLE}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_ARTICLE_TITLE'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{VIDEO}', 'jform_basic_text')">{VIDEO}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_VIDEO_NEED_ALLVIDEOS'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{INTRO_MESSAGE}', 'jform_basic_text')">{INTRO_MESSAGE}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_ARTICLE_INTROTEXT'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{FULL_MESSAGE}', 'jform_basic_text')">{FULL_MESSAGE}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_ARTICLE_CONTENT'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{IMAGE}', 'jform_basic_text')">{IMAGE}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_IMAGE'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{READMORE_LINK}', 'jform_basic_text')">{READMORE_LINK}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_FB_ORIGIN_LINK'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{LINK_URL}', 'jform_basic_text')">{LINK_URL}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_LINK_URL'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{LINK_NAME}', 'jform_basic_text')">{LINK_NAME}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_LINK_TITLE'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{LIKES}', 'jform_basic_text')">{LIKES}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_FB_LIKE_COUNT'); ?></span>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" style="cursor: pointer;" onclick="jInsertEditorText('{CREATED_TIME}', 'jform_basic_text')">{CREATED_TIME}</label>
						<div class="controls">
							<span><?php echo JText::_('COM_FBIMPORTER_FB_PUBLISH_UP_TIME'); ?></span>
						</div>
					</div>
					
			</fieldset>
		</div>	
	</div>
	
	<input type="hidden" name="option" value="com_fbimporter" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>

</div>