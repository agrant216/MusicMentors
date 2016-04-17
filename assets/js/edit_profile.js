$(document).on('click', '.removeItem', function() {
	$(this).parent().remove();
});
$(document).on('click', '#addInstrument', function() {
	$.ajax({url: '././includes/ajax/add_item_js.function.php',
	data: 'option=instrument',
	success: function(data) {
			$("#instrumentDiv").append(data);
			$("#instrumentDiv").children().last().after($("#addInstrument"));

		}
	});
});
$(document).on('click', '#addGenre', function() {
	$.ajax({url: '././includes/ajax/add_item_js.function.php',
	data: 'option=genre',
	success: function(data) {
			$("#genreDiv").append(data);
			$("#genreDiv").children().last().after($("#addGenre"));

		}
	});
});

$("#imageFile").change(function(event) {

	var file= document.getElementById("imageFile");
	var max_size = document.getElementById("max_file_size").value;

	$("#fileError").remove();
	if (file.files && file.files.length == 1)
	{
		if (file.files[0].size > max_size)
		{
			$("#imageFile").after('<p id="fileError">The image must be less than ' + (max_size/1024) + 'KB</p>');
			$("#imageUpload").trigger("reset");
			event.preventDefault();
		}
		else
		{
			var temp_path = URL.createObjectURL(event.target.files[0]);
			$("#uPicture").attr("src", temp_path);
		}
	}
});