/*!
 * Windwalker JS
 *
 * Copyright 2013 Asikart.com
 * License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 *
 * Generator: AKHelper
 * Author: Asika
 */


var Fbimporter = (function(){
	return {
		
		importCombined : function(form, modal){
			if ($('fbimporter-items').getElementById('sbox-content')) {
				var selects = $$('#sbox-content select') ;
			}
			else {
				var selects = $$('#saveAsCombinedModal select') ;
			}
			
			selects.each( function(e, i){
				var name = e.get('name') ;
				var input = $$('#adminForm input[name=' + name + ']') ;
				
				input.set('value', e.get('value')) ;
			});
			
			Joomla.submitform('item.saveASCombined') ;
		}
		
	};
})();

