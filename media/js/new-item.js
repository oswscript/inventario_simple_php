$('document').ready(function() {
	$('form[name=new-item]').submit(function(evt) {
		evt.preventDefault();
		
		var name = $('input[name=item-name]').val();
		var code = $('input[name=item-code]').val();
		var desc = $('textarea[name=item-descrp]').val();
		var cat = $('select[name=item-category]').val();
		var qty = $('input[name=item-qty]').val();
		var price = $('input[name=item-price]').val();
		
		if(name == '') {
			alert('Por favor ingrese un nombre');
			return false;
		}
		if(code == '') {
			alert('Por favor ingrese un código');
			return false;
		}
		if(cat == 'no') {
			alert('Necesita crear una categoría');
			location.href='new-category.php';
			return false;
		}
		if(price == '') {
			alert('Por favor ingrese un precio');
			return false;
		}

		
		$.post('new-item.php', {
			'act':'1',
			'name':name,
			'code':code,
			'descrp':desc,
			'cat':cat,
			'qty':qty,
			'price':price
		}, function(data) {
			if(data == 'code') {
				alert('Este código ya ha sido registrado, intente otro.!');
				return false;
			}
			if(data == '1') {
				alert('Producto creado exitosamente!');
				location.href = 'items.php';
			}else{
				alert('Algo va mal, intente otra vez.');
				return false;
			}
		});
	});
	
	$('textarea[name=item-descrp]').keyup(function(evt) {
		var count = $(this).val().length;
		var limit = 400;
		var val = $(this).val();
		var t = $(this);
		
		if(count > limit){
			t.val(val.substr(0,400));
			var dif = 0;
		}else
			var dif = limit-count;
		$('span.item-desc-left').html('Descripción ('+dif+' caracteres restantes):');
	});
	
	$('input[name=item-qty]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d+$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});
	
	$('input[name=item-price]').keyup(function(evt) {
		var val = $(this).val();
		var re = /^\d*\.{0,1}\d{0,2}$/;
		var t = $(this);
		
		if((re.test(val)) == false)
			t.val(val.substr(0, val.length - 1));
		return;
	});
});