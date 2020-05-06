$('document').ready(function() {
	$('form[name=account-settings]').submit(function(evt) {
		evt.preventDefault();
		
		var name = $('input[name=name]').val();
		var email = $('input[name=email]').val();
		
		// Validate email
		if(email != undefined) {
			var rgpx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		}
		
		// Empty Inputs
		if(name != undefined && name == '') {
			alert('Please insert a name');
			return false;
		}
		if(email != undefined && email == '') {
			alert('Please insert an email');
			return false;
		}
		if(email != undefined && rgpx.test(email) == false) {
			alert('Please insert a valid email');
			return false;
		}
		
		if(name == undefined)
			name = 'false';
		if(email == undefined)
			email = 'false';
		
		$.post('settings.php', {
			'act':'1',
			'name':name,
			'email':email
		},function(data) {
			if(data == '1') {
				alert('Cambios realizados exitosamente');
				location.href = 'settings.php';
			}else if(data == '2') {
				alert('Por favor ingrese un correo válido');
				return false;
			}else{
				alert('Algo va mal. Por favor vuelva a intentar');
				return false;
			}
		});
	});
	
	
	$('form[name=change-password]').submit(function(evt) {
		evt.preventDefault();
		
		var pass1 = $('input[name=new-password]').val();
		var pass2 = $('input[name=rnew-password]').val();
		
		if(pass1 == '') {
			alert('Por favor ingrese una clave');
			return false;
		}else if(pass2 == '') {
			alert('Por favor ingrese una confirmación de clave');
			return false;
		}else if(pass1 != pass2) {
			alert('Claves no coinciden');
			return false;
		}else if(pass1.length < 6){
			alert('La clave debe tener mínimo 6 caracteres');
			return false;
		}
		
		$.post('settings.php', {
			'act':'2',
			'password1':pass1,
			'password2':pass2
		},function(data) {
			if(data == '1') {
				alert('Clave cambiada exitosamente');
				location.href = 'settings.php';
			}else if(data == '2') {
				alert('Claves no coinciden');
				return false;
			}else{
				alert('Algo va mal. Por favor vuelva a intentar');
				return false;
			}
		});
	});
	
	
	$('form[name=invento-settings]').submit(function(evt) {
		evt.preventDefault();
		
		var ch1 = $('input[name=allow-namechange]').prop('checked');
		var ch2 = $('input[name=allow-emailchange]').prop('checked');

		ch1 = (ch1 == true) ? 'y' : 'n';
		ch2 = (ch2 == true) ? 'y' : 'n';
		
		$.post('settings.php', {
			'act':'3',
			'namechange':ch1,
			'emailchange':ch2
		},function(data) {
			if(data == '1') {
				alert('Configuraciones cambiadas exitosamente');
				location.href = 'settings.php';
			}else{
				alert('Algo va mal. Por favor vuelva a intentar');
				return false;
			}
		});
	});
});