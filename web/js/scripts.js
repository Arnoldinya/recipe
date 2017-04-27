$(document).ready(function() {
	//добавить ингредиент
	$('.add-ingredient').click(function(){
		var index = $('.ingredient-row').size();
		index++;

		$.post('/dish/add-ingredient', {
			'index' : index,
		}, function(data) {
			$('.ingredient-group').append(data);
		});
	});

	//удалить ингредиент
	$(document).on('click', '.delete-ingredient', function(e){
		e.preventDefault;
		$(this).closest('.ingredient-row').remove();
	});
});