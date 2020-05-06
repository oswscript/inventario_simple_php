$('document').ready(function() {
	$('form[name=edit-cat]').submit(function(evt) {
		evt.preventDefault();
		
		var catid = $(this).data('id');
		var name = $('input[name=ncat-name]').val();
		var place = $('input[name=ncat-place]').val();
		var desc = $('textarea[name=ncat-descrp]').val();
		
		if(name == '') {
			alert('Por favor ingrese el nombre de la categoría');
			return false;
		}
		
		$.post('edit-category.php', {
			'act':'1',
			'catid':catid,
			'name':name,
			'place':place,
			'desc':desc
		}, function(data) {
			console.log(data);
			if(data == '2') {
				alert('Esta categoría ya existe, no puede asignarla a esta.');
				return false;
			}
			else if(data == '1') {
				alert('Categoría actualizada exitosamente!');
				location.href = 'categories.php';
			}else{
				alert('Algo va mal. Por favor vuelva a intentar');
				return false;
			}
		});
	});
	
	$('textarea[name=ncat-descrp]').keyup(function(evt) {
		var count = $(this).val().length;
		var limit = 400;
		var val = $(this).val();
		var t = $(this);
		
		if(count > limit){
			t.val(val.substr(0,400));
			var dif = 0;
		}else
			var dif = limit-count;
		$('span.ncat-desc-left').html('Descripción ('+dif+' caracteres restantes):');
	});
});