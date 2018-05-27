var ButtonPreview;

(function ($) {

	ButtonPreview = (function () {
		function change(buttonSubject) {
			var $buttonPreview = $(`#${buttonSubject}_button_preview`);
			var $buttonText = $(`#${buttonSubject}`);
			var $buttonFgColor = $(`#${buttonSubject}_fg_color`);
			var $buttonBgColor = $(`#${buttonSubject}_bg_color`);

			$buttonPreview.text($buttonText.val()).css({
				color: $buttonFgColor.val(),
				backgroundColor: $buttonBgColor.val()
			});
		}

		function watch(buttonSubject) {
			var buttonPreviewFn = change.bind(null, buttonSubject);
			buttonPreviewFn();
			$(`#${buttonSubject}`).on('keyup', buttonPreviewFn);
			$(`#${buttonSubject}_fg_color, #${buttonSubject}_bg_color`).on('change', buttonPreviewFn);
		}

		return {
			init: function () {
				['positive_answer', 'negative_answer', 'custom_answer'].forEach(function (answer) {
					watch(answer);
				});
			}
		};
	})();
	
})(jQuery);
