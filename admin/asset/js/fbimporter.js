/**
 * @package     Joomla.Administrator
 * @subpackage  com_fbimporter
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

;(function($)
{
	window.Fbimporter = {
		importCombined: function(form, modal)
		{
			var selects;

			if ($('#sbox-window'))
			{
				selects = $('#sbox-content').find('select');
			}
			else
			{
				selects = $('#saveAsCombinedModal').find('select');
			}

			selects.each(function(i)
			{
				var self = $(this);
				var name = self.attr('name');
				var input = $('#adminForm').find('input[name=' + name + ']');

				input.val(self.attr('value'));
			});

			Joomla.submitform('item.savecombine');
		}
	};
})(jQuery);
