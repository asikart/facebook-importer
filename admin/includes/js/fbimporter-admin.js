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
			var selects = $$('#saveAsCombinedModal select') ;
			
			selects.each( function(e, i){
				var id = e.get('id') ;
				var input = $$('#adminForm input[name=' + id + ']') ;
				
				input.set('value', e.get('value')) ;
			});
			
			Joomla.submitform('item.saveASCombined') ;
		}
		
		
	}
})();

