<?php
/**
 * Part of joomla3304 project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$params = $data->params;
?>
<div id="saveAsCombinedModal" class="modal hide fade <?php echo JVERSION >= 3 ? 'joomla30' : 'joomla25'; ?>">

		<div class="modal-header">
			<button type="button" role="presentation" class="close" data-dismiss="modal">x</button>
			<h3><?php echo JText::_('COM_FBIMPORTER_IMPORT_AS_COMBINED');?></h3>
		</div>

		<div class="modal-body form-horizontal">

			<div class="combined-sample control-group">
				<label class="combined-sample-lbl control-label" for="combined_sample"><?php echo JText::_('COM_FBIMPORTER_COMBINED_SAMPLE') ; ?></label>
				<?php
				$options = array();

				$options = JHtmlSelect::options($data->formats, 'id', 'title', $params->get('combined_sample', 2)) ;
				?>
				<div class="controls">
					<select name="combined_sample" id="combined_sample" class="">
						<?php echo $options; ?>
					</select>
				</div>
			</div>


			<div class="combined-catid control-group">
				<label for="combined_catid" class="combined-catid-lbl control-label"><?php echo JText::_('JCATEGORY') ; ?></label>
				<div class="controls">
					<?php
					$catOptions = JHtml::_('category.options', 'com_content') ;
					array_unshift($catOptions, JHtml::_('select.option', '', JText::_('COM_FBIMPORTER_CAGORY_TYPE_BE_DEFAULT'))) ;
					echo JHtml::_(
						'select.genericlist', $catOptions, "combined_catid", 'id="combined_catid" class="inputbox"', 'value', 'text',
						$params->get('combined_catid')
					);
					?>
				</div>
			</div>

			<hr />

			<div class="combined-sort control-group">
				<label for="combined_sort" class="combined-sort-lbl control-label"><?php echo JText::_('JGRID_HEADING_ORDERING') ; ?></label>
				<div class="controls">
					<?php
					$sortOptions = array() ;
					$sortOptions[] = JHtml::_('select.option', 'created', JText::_('COM_FBIMPORTER_COMBINED_SORT_PUBLISHED'));
					//$sortOptions[] = JHtml::_('select.option', 'imported', 'COM_FBIMPORTER_COMBINED_SORT_IMPORTED');
					$sortOptions[] = JHtml::_('select.option', 'likes', JText::_('COM_FBIMPORTER_COMBINED_SORT_LIKED'));

					echo JHtml::_(
						'select.genericlist', $sortOptions, "combined_sort", 'id="combined_sort" class="inputbox"', 'value', 'text',
						$params->get('combined_sort')
					);
					?>
				</div>
			</div>


			<div class="combined-dir control-group">
				<label for="combined_dir" class="combined-dir-lbl control-label"><?php echo JText::_('JFIELD_ORDERING_DESC') ; ?></label>
				<div class="controls">
					<?php
					$dirOptions = array() ;
					$dirOptions[] = JHtml::_('select.option', 'desc', JText::_('JGLOBAL_ORDER_DESCENDING'));
					$dirOptions[] = JHtml::_('select.option', 'asc', JText::_('JGLOBAL_ORDER_ASCENDING'));

					echo JHtml::_(
						'select.genericlist', $dirOptions, "combined_dir", 'id="combined_dir" class="inputbox"', 'value', 'text',
						$params->get('combined_dir')
					);
					?>
				</div>
			</div>

		</div>


		<div class="modal-footer">
			<button class="btn" type="button" data-dismiss="modal">
				<?php echo JText::_('JCANCEL'); ?>
			</button>

			<button class="btn btn-primary fltrt modal-submit-import" type="submit" onclick="Fbimporter.importCombined('adminForm', 'saveAsCombinedModal');">
				<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
			</button>
		</div>

</div>