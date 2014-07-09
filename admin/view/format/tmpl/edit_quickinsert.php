<?php
/**
 * Part of joomla3304 project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

?>
<style>
	.quickinsert button
	{
		float: left;
		font-family: 'Source Code Pro', Monaco, Consolas, "Lucida Console", monospace;
	}

	.quickinsert div.control-group:nth-child(even)
	{
		background-color: #f8f8f8;
	}

	.quickinsert div.control-group
	{
		margin: 0;
		padding: 10px 20px;
		border-bottom: 1px solid #eee;
	}
</style>
<div>
	<fieldset class="quickinsert adminform form-horizontal">
		<legend><?php echo JText::_('COM_FBIMPORTER_CAN_BE_INSERTED_PARAMS'); ?></legend>
		<p></p>
		<p><?php echo JText::_('COM_FBIMPORTER_CLICK_AND_INSERT'); ?></p>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{TITLE}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {TITLE}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_ARTICLE_TITLE'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{VIDEO}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {VIDEO}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_VIDEO_NEED_ALLVIDEOS'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{INTRO_MESSAGE}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {INTRO_MESSAGE}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_ARTICLE_INTROTEXT'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{FULL_MESSAGE}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {FULL_MESSAGE}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_ARTICLE_CONTENT'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{IMAGE}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {IMAGE}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_IMAGE'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{READMORE_LINK}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {READMORE_LINK}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_FB_ORIGIN_LINK'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{LINK_URL}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {LINK_URL}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_LINK_URL'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{LINK_NAME}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {LINK_NAME}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_LINK_TITLE'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{LIKES}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {LIKES}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_FB_LIKE_COUNT'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<button type="button" class="btn btn-small" style="cursor: pointer;" onclick="jInsertEditorText('{CREATED_TIME}', 'jform_basic_text')"><i class="icon-arrow-left-3"></i> {CREATED_TIME}</button>
			<div class="controls">
				<span><?php echo JText::_('COM_FBIMPORTER_FB_PUBLISH_UP_TIME'); ?></span>
			</div>
		</div>

	</fieldset>
</div>