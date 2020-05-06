$('document').ready(function() {
	$('form[name=edit-user]').submit(function(evt) {
		evt.preventDefault();
		
		var userid = $(this).data('id');
		var name = $('input[name=euser-name]').val();
		var email = $('input[name=euser-email]').val();
		var role = $('select[name=euser-role]').val();
		
		// Validate email
		var rgpx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		// Empty Inputs
		if(name == '') {
			alert('Por favor ingrese un nombre');
			return false;
		}else if(email == '') {
			alert('Por favor ingrese un correo');
			return false;
		}else if(rgpx.test(email) == false) {
			alert('Por favor ingrese un correo válido');
			return false;
		}
		
		
		$.post('edit-user.php', {
			'act':'1',
			'userid':userid,
			'name':name,
			'email':email,
			'role':role
		}, function(data) {
			//alert(data);
			if(data == '1') {
				alert('El usuario ha sido actualizado exitosamente');
				location.href = 'users.php';
			}else if(data == '2') {
				alert('Usuario no existe');
				return false;
			}else if(data == '3') {
				alert('Ingrese un correo válido');
				return false;
			}else{
				alert('Algo va mal. Por favor vuelva a intentar');
				return false;
			}
		});
	});
});