jQuery.noConflict();

(function ($) {
	$(function () {
		var pollId = $('#poll_id').val();
		var answerId = $('input:radio[name=answers]:checked').val();

		if ($.cookie('__poll') == pollId) {
			$('.polls-answers').hide();
			$('#polls_results').show();
		}
		else {
			$('#polls_answers').show();
		};

		$('input:radio[name=answers]').each(function () {
			if ($(this).is(':checked')) {
				$('.polls-vote').removeClass('disabled');
			};
		})

		$('input:radio[name=answers]').click(function () {
			$('.polls-vote').removeClass('disabled');
		})

		$('.polls-vote').click(function () {
			if ($('input:radio[name=answers]:checked').length > 0) {
				$.ajax({
					type: 'GET',
					url: 'index.php?option=com_polls&task=polls.poll&format=json&tmpl=component',
					data: {
						poll: pollId,
						answer: answerId
					},
					dataType: 'json',
					success: function (json) {
						var options = '';
						$.each(json, function (key, value) {
							options += '<label>' + value.name + '</label>';
							options += '<div class="progress">';
							options += '<div class="bar" style="width: ' +  (value.votes / value.total * 100) + '%; background-color: ' + value.color + '; background-image: none;"></div>';
							options += '</div>';
						});
						$('#result-list').html(options);

						$('.polls-answers').hide();
						$('.polls-results').trigger('click');
					}
				});

				$.cookie('__poll', pollId, {expires: 1});

				return false;
			}
			else {
				return false;
			};
		})

		$('.polls-results').click(function () {
			$('#polls_answers').hide('slow', function () {
				$('#polls_results').show('slow');
			});

			return false;
		})

		$('.polls-answers a').click(function () {
			$('#polls_results').hide('slow', function () {
				$('#polls_answers').show('slow');
			});

			return false;
		})
	});
})(jQuery);