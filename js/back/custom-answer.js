var CustomAnswer;

(function ($) {

	var $customAnswerSet = $('#custom-answer-set');
	var $customAnswerSetLayer = $('#custom-answer-set-layer');
	var $customAnswer = $('#custom_answer');
	var $addButton = $('#add-custom-answer-item');

	var AnswerSet = {
		add: function (text, fgColor, bgColor) {
			var customAnswerSet = JSON.parse(
				$customAnswerSet.val()
			);

			customAnswerSet[text] = {fgColor, bgColor};
			$customAnswerSet.val(
				JSON.stringify(customAnswerSet)
			);
		},
		delete: function (text) {
			var customAnswerSet = JSON.parse(
				$customAnswerSet.val()
			);

			delete customAnswerSet[text];
			$customAnswerSet.val(
				JSON.stringify(customAnswerSet)
			);
		},
		display: function () {
			var customAnswerSet = JSON.parse(
				$customAnswerSet.val()
			);

			$customAnswerSetLayer.html('');

			for (let answer of Object.keys(customAnswerSet)) {
				let $spanText = $('<span style="padding: 5px 0 5px 10px; margin: 5px"></span>');
				let $spanDelete = $('<span class="delete-item" style="background-color: #000; color: #fff; margin-left: 10px; padding: 5px">x</span>');

				$spanText.text(answer).css({
					color: customAnswerSet[answer].fgColor,
					backgroundColor: customAnswerSet[answer].bgColor
				}).data('text', answer).append($spanDelete);

				$customAnswerSetLayer.append($spanText);
			}
		}
	};

	CustomAnswer =  {
		init: function () {
			AnswerSet.display();
		},
		watchAdding: function () {
			function addAnswerCallback() {
				if ($customAnswer.val() != '') {
					let $customAnswerFgColor = $('#custom_answer_fg_color');
					let $customAnswerBgColor = $('#custom_answer_bg_color');
					let $customAnswerButtonPreview = $('#custom_answer_button_preview');

					AnswerSet.add(
						$customAnswer.val(),
						$customAnswerFgColor.val(),
						$customAnswerBgColor.val()
					);

					$customAnswer.val('');
					$customAnswerButtonPreview.text('');
					AnswerSet.display();
				}
			}

			$addButton.on('click', addAnswerCallback);
			$customAnswer.on('keydown', function (e) {
				if (e.keyCode == 13) {
					addAnswerCallback();
					e.preventDefault();
					return false;
				}
			});
		},
		watchDeleting: function () {
			$customAnswerSetLayer.on('click', function (e) {
				var $target = $(e.target);
				if ($target.hasClass('delete-item')) {
					AnswerSet.delete(
						$target.parent().data('text')
					);
					AnswerSet.display();
				}
			});
		}
	};
	
})(jQuery);
