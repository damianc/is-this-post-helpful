var BoxPreview;

(function ($) {

	BoxPreview = (function () {
		var $contentBox = $('#content-line-box');
		var $fgColorPicker = $('#question_text_fg_color');
		var $bgColorPicker = $('#question_text_bg_color');
		var $borderColorPicker = $('#question_text_border_color');

		function style() {
			$contentBox.css({
				'color': $fgColorPicker.val(),
				'background-color': $bgColorPicker.val(),
				'border-color': $borderColorPicker.val()
			});
		}

		function watch() {
			$('.box-styling').on('change', function () {
				var $this = $(this);
				var mapIdToStyle = {
					question_text_fg_color: 'color',
					question_text_bg_color: 'background-color',
					question_text_border_color: 'border-color'
				};

				$contentBox.css(
					mapIdToStyle[$this.attr('id')],
					$this.val()
				);
			});
		}

		return {
			init: function () {
				style();
				watch();
			}
		};
	})();
	
})(jQuery);
