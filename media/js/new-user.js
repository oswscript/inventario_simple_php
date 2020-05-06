$('document').ready(function() {
	$('form[name=new-user]').submit(function(evt) {
		evt.preventDefault();
		
		var name = $('input[name=nuser-name]').val();
		var username = $('input[name=nuser-user]').val();
		var password = $('input[name=nuser-pass]').val();
		var password2 = $('input[name=nuser-passr]').val();
		var email = $('input[name=nuser-email]').val();
		var dni = $('input[name=nuser-dni]').val();
		var role = $('select[name=nuser-role]').val();
		
		// Validate email
		var rgpx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		// Empty Inputs
		if(name == '') {
			alert('Por favor ingrese un nombre');
			return false;
		}else if(username == '') {
			alert('Por favor ingrese un nombre de usuario');
			return false;
		}else if(dni == ''){
			alert('Por favor ingrese una cédula');
			return false;
		}else if(password == '') {
			alert('Por favor ingrese una clave');
			return false;
		}else if(password2 == '') {
			alert('Por favor ingrese la confirmación de la clave');
			return false;
		}else if(email == '') {
			alert('Por favor ingrese un correo');
			return false;
		}else if(password != password2) {
			alert('Las claves no coinciden');
			return false;
		}else if(rgpx.test(email) == false) {
			alert('Por favor ingrese un correo válido');
			return false;
		}else if(password.length < 6){
			alert('La contraseña debe contener 6 caracteres como mínimo');
			return false;
		}
		
		
		$.post('new-user.php', {
			'act':'1',
			'name':name,
			'dni':dni,
			'username':username,
			'password1':password,
			'password2':password2,
			'email':email,
			'role':role
		}, function(data) {
			console.log(data);
			if(data == '1') {
				alert('Usuario creado exitosamente!');
				location.href = 'users.php';
			}else if(data == '2') {
				alert('Claves no coinciden');
				return false;
			}else if(data == '3') {
				alert('Por favor ingrese un correo válido');
				return false;
			}else if(data == '4') {
				alert('La clave debe contener 6 caracteres mínimo');
				return false;
			}else if(data == '5') {
				alert('Nombre de usuario ya existe, intente otro.');
				return false;
			}else if(data == '6') {
				alert('La cédula ya existe, intente otra.');
				return false;
			}else{
				alert('Algo va mal. Por favor vuelva a intentar');
				return false;
			}
		});
	});
});