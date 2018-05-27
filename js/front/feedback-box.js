(function ($) {
	
	var $feedbackBox = $('#itph-feedback-box');

	$feedbackBox.on('click', async function (e) {
		var $target = $(e.target);
		if ($target.hasClass('answer-button') || $target.hasClass('star-button')) {
			var value = $target.data('answer-type') || ($target.data('star-num') || $target.text().trim());

			try {
				var res = await $.ajax(itph_plugin_params.ajax_url, {
					type: 'post',
					data: {
						post_id: itph_plugin_params.post_id,
						action: 'itph_post_feedback',
						value: value
					}
				});
				$feedbackBox.text(itph_plugin_params.response_message);
			} catch (e) {
				$feedbackBox.text('Something went wrong :/');
			}
		}
	});

})(jQuery);
