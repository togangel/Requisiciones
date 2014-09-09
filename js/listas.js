var val=0;
$(function(){
	$('#btnAgregar').on('click',function(){
		//variable para contener la lista html
		var $ulLista;
		//si la lista html no existe entonces la agregamos al dom
		if(!$('#divLista').find('ul').length) $('#divLista').append('<ul/>');
		//obtenemos una instancia de la lista
		$ulLista=$('#divLista').find('ul');
		//verificamos el limite de elementos
		var $selTipoServicio=$('#selTipoServicio');
		if($.trim($selTipoServicio.val())==1){
			val++;
			var inputs='';
			var $liNuevoNombre=$('<li/>').html('<a class="clsEliminarElemento">X</a>'+$.trim('Servicio: <label for="SDescripcion'+val+'">Descripcion </label><input type="text" name="SDescripcion'+val+'" id="SDescripcion'+val+'" required="required">'));
			//verificamos la posicion en la que debemos agregar el nuevo elemento (inicio o final de la lista)
			$ulLista.prepend($liNuevoNombre);
		}
		else{
			val++;
			var inputs='Refaccion: <label for="Descripcion'+val+'">Descripcion </label><input type="text" name="Descripcion'+val+'" id="Descripcion'+val+'" required="required">';
			inputs+='<label for="NoParte'+val+'"> No. de Parte </label><input type="text" class="num" name="NoParte'+val+'" id="NoParte'+val+'" required="required">';
			inputs+='<label for="Cantidad'+val+'"> Cantidad </label><input type="text" class="num" name="Cantidad'+val+'" id="Cantidad'+val+'" required="required">';
			inputs+='<label for="UnidMedida'+val+'"> Unid. de Medida </label><input type="text" class="num" name="UnidMedida'+val+'" id="UnidMedida'+val+'" required="required">';
			var $liNuevoNombre=$('<li/>').html('<a class="clsEliminarElemento">X</a>'+$.trim(inputs));
			//verificamos la posicion en la que debemos agregar el nuevo elemento (inicio o final de la lista)
			$ulLista.append($liNuevoNombre);
		}
		
	});

	$('.clsEliminarElemento').live('click',function(){
		//buscamos la lista
		var $ulLista=$('#divLista').find('ul');
		//buscamos el padre del boton (el tag li en el que se encuentra)
		var $liPadre=$($(this).parents().get(0));
		
		//eliminamos el elemento
		$liPadre.remove();
		//si la listaesta vacia entonces la eliminamos del dom
		if($ulLista.find('li').length==0) $ulLista.remove();
	});
	
	//eliminamos la lista del dom
	$('#btnEliminarTodo').on('click',function(){
		$('#divLista ul').remove();
	});
});
