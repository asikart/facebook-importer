<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Data\Data;

// No direct access
defined('_JEXEC') or die;

// Prepare script
JHtmlBehavior::multiselect('adminForm');

/**
 * Prepare data for this template.
 *
 * @var $container Windwalker\DI\Container
 * @var $data      Windwalker\Data\Data
 * @var $asset     Windwalker\Helper\AssetHelper
 * @var $grid      Windwalker\View\Helper\GridHelper
 * @var $date      \JDate
 */
$container = $this->getContainer();
$asset     = $container->get('helper.asset');
$grid      = $data->grid;
$date      = $container->get('date');

$app = $container->get('app');
$params = $data->params;

$asset->addJs('fbimporter.js');
?>

<fieldset id="filter-bar">
	<div class="filter-search fltlft pull-left">
		<label class="import-num-lbl pull-left" for="import_num"><?php echo JText::_('COM_FBIMPORTER_CACHE_NUM') ; ?></label>
		<?php echo JHtml::_('select.integerlist', 50, 1000, 50 , 'import_num', array('onchange'=>"Joomla.submitbutton('items.refresh');", 'class' => 'pull-left'), $data->state->get('import_num') ); ?>

		<?php
		$filterOptions = array();
		$filterOptions[] = JHtml::_('select.option', '', JText::_('JALL')) ;
		$filterOptions[] = JHtml::_('select.option', 'status', 'Status') ;
		$filterOptions[] = JHtml::_('select.option', 'link', 'Link') ;
		$filterOptions[] = JHtml::_('select.option', 'photo', 'Photo') ;
		$filterOptions[] = JHtml::_('select.option', 'video', 'Video') ;

		$post_type = $app->getUserStateFromRequest('com_fbimporter.filter.post_type', 'post_type') ;
		echo JHtml::_(
			'select.genericlist', $filterOptions, "post_type", 'id="post_type" class="inputbox" onchange="this.form.submit();"', 'value', 'text',
			$post_type
		);
		?>
	</div>
</fieldset>
<div class="clr"> </div>

<!-- LIST TABLE -->
<table class="adminlist table table table-striped">
	<thead>
	<tr>
		<th width="1%">
			<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
		</th>
		<th width="3%"><?php echo JText::_('COM_FBIMPORTER_IMAGE'); ?></th>
		<th width="10%"><?php echo JText::_('COM_FBIMPORTER_TIME'); ?></th>
		<th width="14%"><?php echo JText::_('COM_FBIMPORTER_CATEGORY'); ?></th>
		<th width="20%"><?php echo JText::_('COM_FBIMPORTER_TITLE'); ?></th>
		<th><?php echo JText::_('COM_FBIMPORTER_FULLTEXT'); ?></th>
	</tr>
	</thead>

	<tbody>
	<?php
	$db = JFactory::getDbo();
	$q = $db->getQuery(true);

	$i = 0;

	$format_form = $data->format_form;

	foreach ($data->items as $item) :

		if ($item->continue)
		{
			continue;
		}

		if ($post_type && $item->type != $post_type)
		{
			continue;
		}

		$likes = isset($item->likes->summary->total_count) ? $item->likes->summary->total_count : 0;
		?>
		<tr class="row<?php echo $i % 2; ?>">

			<!--CHECKBOX-->
			<td class="center" style="padding: 0;">
				<input style="width:100%; height:100%; <?php //echo $item->exists ? 'visibility: hidden ;' : null; ?>" type="checkbox" id="cb<?php echo $i; ?>" <?php //echo $item->exists ? 'disabled="true"' : null; ?>
					name="cid[]" value="<?php echo $item->id; ?>" onclick="Joomla.isChecked(this.checked);" title="<?php echo JText::sprintf('COM_FBIMPORTER_ROW %s COM_FBIMPORTER_CHECKBOX', $i + 1); ?>" />
			</td>

			<!--IMAGE-->
			<td class="center" style="vertical-align: middle;">
				<a target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>">
					<img class="img-polaroid" src="<?php echo $item->get('picture', 'components/com_fbimporter/images/facebook-default.png'); ?>" style="max-width:150px;max-height: 150px;" onerror="this.src='components/com_fbimporter/images/facebook-default.png';" alt="<?php echo $item->get('title'); ?>" />
				</a>
			</td>

			<!--TIME-->
			<td class="center">
				<p>
					<?php echo $item->date->format('Y-m-d', true); ?>
					<br />
					<?php echo $item->date->format('H:i:s', true); ?>
					(<?php echo $item->date->format('D', true); ?>)
				</p>
				<p>
					<?php echo JText::_('COM_FBIMPORTER_FB_LIKE'); ?>：<span style="color: blue;"><?php echo $likes; ?></span>
					<br />
					<?php echo JText::_('COM_FBIMPORTER_TYPE'); ?>：<span style="color: red;"><?php echo $item->get('type'); ?></span>
				</p>
				<p>
					<?php if (JVERSION >= 3): ?>
						<a class="btn btn-info" target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>"><?php echo JText::_('COM_FBIMPORTER_ORIGIN_LINK'); ?></a>
					<?php else: ?>
						<a target="_blank" href="http://www.facebook.com/<?php echo $params->get('fb_uid'); ?>/posts/<?php echo $item->id; ?>">[<?php echo JText::_('COM_FBIMPORTER_ORIGIN_LINK'); ?>]</a>
					<?php endif; ?>
				</p>
			</td>

			<!--CAREGORY & FORMAT-->
			<td align="">
				<?php if (!$item->exists): ?>

					<!--CATEGORY-->
					<?php if ($item->catid && !$params->get('select_category_when_exists', 1)): ?>
						<?php echo $item->cat_name; ?>
						<input type="hidden" name="item[<?php echo $item->id; ?>][catid]" value="<?php echo $item->catid; ?>" />
					<?php else: ?>
						<?php
						if (!$item->catid)
						{
							$item->catid = $params->get('catid');
						}

						$options = JHtml::_('category.options', 'com_content');
						array_unshift($options, JHtml::_('select.option', '', JText::_('JOPTION_SELECT_CATEGORY')));

						echo JHtml::_(
							'select.genericlist', $options, "item[{$item->id}][catid]", 'class="inputbox"', 'value', 'text',
							$item->catid
						);
						?>

						<?php if ($item->cat_matched): ?>
								<span class="label label-info"><?php echo JText::_('COM_FBIMPORTER_CATEGORY_AUTO_MATCHED'); ?></span>
						<?php endif; ?>
					<?php endif; ?>

					<!--FORMAT-->
					<?php if ($params->get('can_select_format', 1) && $format_form): ?>
						<br />
						<br />
						<?php echo JText::_('COM_FBIMPORTER_CHOOSE_FORMAT'); ?>：
						<?php
						$format_form->name = "item[{$item->id}][format]";
						echo $format_form->input;
						?>
					<?php endif; ?>
				<?php else: ?>
					<div align="center" style="color:#C00;">(<?php echo JText::_('COM_FBIMPORTER_HAVE_IMPORTED'); ?>)</div>
				<?php endif; ?>
			</td>

			<!--TITLE-->
			<td>
				<textarea type="text" name="item[<?php echo $item->id; ?>][title]" style="width:100%;height:100px;"><?php echo $item->get('title'); ?></textarea>
			</td>

			<!--TEXT-->
			<td>

				<textarea name="item[<?php echo $item->id; ?>][message]" style="width:100%;height:100px;"><?php
					$item->message = str_replace('<br />', '', $item->message);
					//$item->message = str_replace( "\t" , '1' , $item->message ) ;
					echo trim($item->message);
					?></textarea>

			</td>
		</tr>
		<?php $i++; ?>
	<?php endforeach; ?>
	</tbody>
</table>
