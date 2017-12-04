$(function() {
    
    $('#pause').click(function() {
        // combo
        var heures = $('#h').text();
        var minutes = $('#m').text();
        var secondes = $('#s').text();
        var task_id = $('#task_id').val();
       
        $.post(url + "/task/enregistreChrono", { heures: heures, minutes: minutes , secondes : secondes , task_id : task_id })
            .done(function(result) {

            })
            .fail(function() {
                // this will be executed if the ajax-call had failed
            })
            .always(function() {
                // this will ALWAYS be executed, regardless if the ajax-call was success or not
            });

    });

	$('#start').click(function() {
		
		var task_id = $('#task_id').val();
        $.post(url + "/task/setToEnCours", { task_id : task_id })
            .done(function(result) {
				
            })
            .fail(function() {
               
            })
            .always(function() {
               
            });

    });
    
 	$('#change').click(function() {
		
		var task_id = $('#task_id').val();
        $.post(url + "/task/setToEnCours", { task_id : task_id })
            .done(function(result) {
				window.location.reload();
            })
            .fail(function() {
               
            })
            .always(function() {
               
            });

    });
    
	$('#stop').click(function() {
        var heures = $('#h').text();
        var minutes = $('#m').text();
        var secondes = $('#s').text();
		var task_id = $('#task_id').val();
        $.post(url + "/task/setToFinish", { heures: heures, minutes: minutes , secondes : secondes , task_id : task_id })
            .done(function(result) {
                
				window.location.reload();
            })
            .fail(function() {
               
            })
            .always(function() {
               
            });

    });


});
