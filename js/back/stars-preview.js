var StarsPreview;

(function ($) {

	StarsPreview = (function () {
		var $fullStarColor = $('#full_star_color');
		var $emptyStarColor = $('#empty_star_color');
		var $starsPreview = $('#stars-preview');
		var $fullStars = $('#stars-preview').find('.full-star');
		var $emptyStars = $('#stars-preview').find('.empty-star');

		return {
			init: function () {
				$fullStarColor.on('change', function () {
					$fullStars.css('color', $(this).val());
				});
				$emptyStarColor.on('change', function () {
					$emptyStars.css('color', $(this).val());
				});
			}
		};
	})();
	
})(jQuery);
