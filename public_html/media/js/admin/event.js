function eventDelete(id) {
	if (confirm('Delete Event?')) {
		$.ajax({
			url: '/adminevent/delete/' + id
		}).done(function() {
			$('#event_' + id).remove();
		});
	}
}

function eventAddHeadliner(event_id, artist_id) {
	$.ajax({
		url: '/adminevent/add_headliner/' + event_id + '/' + artist_id
	}).done(function() {
		$('#event_artist_' + artist_id).addClass('headliner');
	});
}

function eventRemoveHeadliner(event_id, artist_id) {
	$.ajax({
		url: '/adminevent/remove_headliner/' + event_id + '/' + artist_id
	}).done(function() {
		$('#event_artist_' + artist_id).removeClass('headliner');
	});
}

function eventRemoveArtist(id) {
	$('#event_artist_' + id).fadeOut('slow', function() { 
		$('#event_artist_' + id).remove();
	});
}

function deleteEventImage(id) {
	if (confirm('Delete Image?')) {
		$.ajax({
			url: '/adminevent/delete_image/' + id
		}).done(function() {
			$('#event_image_' + id).remove();
			$('#event_image_delete').remove();
		});
	}
}

$(document).ready(function() {

	$('#event_added_artists ul').sortable();
	$('#event_added_artists ul').disableSelection();

	$('#add_event_artist').click(function(event) {		
		// take the artist from the drop down and add them to the event
		$('#event_artists option:selected').each(function () {
			var element = $(this);

			var artistName = element.data('artistName');
			var artistId = element.data('artistId');
			var eventId = element.data('eventId');

			$.ajax({
				url: '/adminevent/add_artist/' + eventId + '/' + artistId
			}).done(function() {
				element = '<li id="event_artist_' + artistId + '"><input type="hidden" name="event_artists[]" value="' + artistId + '"/><p>' + artistName + '</p><span><a href="#" onclick="eventAddHeadliner(' + eventId + ', ' + artistId + '); return false;">make headliner</a> | <a href="#" onclick="eventRemoveHeadliner(' + eventId + ', ' + artistId + '); return false;">remove headliner</a> | <a href="#" onclick="eventRemoveArtist(' + artistId + '); return false;">remove</a></span></li>';
				$('#event_added_artists ul').append(element);
			})
		})
	});

	// initalize the date pickers
	$('#event_date').datetimepicker({
		language: 'en', pickTime: false
	});
	$('#event_door_time').datetimepicker({
		language: 'en', pickDate: false, pickSeconds: false
	});
	$('#event_show_time').datetimepicker({
		language: 'en', pickDate: false, pickSeconds: false
	});
	$('#event_announce_date').datetimepicker({
		language: 'en'
	});
	$('#event_ticket_onsale_date').datetimepicker({
		language: 'en'
	});
});