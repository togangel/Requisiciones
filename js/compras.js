var val=0;
function Articulos(id){
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","includes/Articulos.php",true);
	xmlhttp.send();
}

function Servicios(id){
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","includes/servicios.php",true);
	xmlhttp.send();
}

$(function(){
	
	$('#btnAgregar').on('click',function(){
		var $tipo=$('#tipo');
	if($.trim($tipo.val())==="9"){
		var $ulLista;
		if(!$('#divLista').find('ul').length) $('#divLista').append('<ul/>');
		$ulLista=$('#divLista').find('ul');
		val++;
		var inputs='<label for="detunidad'+val+'"> Unidad </label><input onBlur="if(this.value!=\'\')BuscaUnidad(this.value, this.id);" type="text" style="width:55px;" name="detunidad'+val+'" id="detunidad'+val+'" required="required">';
		inputs+='<label for="articulo'+val+'"> Articulo </label><select name="articulo'+val+'" id="articulo'+val+'"></select>';
		inputs+='<label for="noparte'+val+'"> No. de Parte </label><input type="text" style="width:55px;" name="noparte'+val+'" id="noparte'+val+'" required="required">';
		inputs+='<label for="cantidad'+val+'"> Cantidad </label><input type="number" style="width:55px;" min="1" name="cantidad'+val+'" id="cantidad'+val+'" required="required">';
		inputs+='<label for="prioridad'+val+'"> Prioridad </label><input type="number" style="width:55px;" min="1" max="5" name="prioridad'+val+'" id="prioridad'+val+'" required="required">';
		var $liNuevoNombre=$('<li/>').html('<a class="clsEliminarElemento">X</a>'+$.trim(inputs));
		$ulLista.append($liNuevoNombre);
		Articulos('articulo'+val);
	}
	else if($.trim($tipo.val())==="10"){
		var $subtipo=$('#subtipoval');
		if($.trim($subtipo.val())==="1"){
		var $ulLista;
		if(!$('#divLista').find('ul').length) $('#divLista').append('<ul/>');
		$ulLista=$('#divLista').find('ul');
		val++;
		var inputs='<label for="servicio'+val+'"> Servicio </label><select name="servicio'+val+'" id="servicio'+val+'"></select>';
		var $liNuevoNombre=$('<li/>').html('<a class="clsEliminarElemento">X</a>'+$.trim(inputs));
		$ulLista.prepend($liNuevoNombre);
		Servicios('servicio'+val);
	}
	else{
		var $ulLista;
		if(!$('#divLista').find('ul').length) $('#divLista').append('<ul/>');
		$ulLista=$('#divLista').find('ul');
		val++;
		var inputs='<label for="articulo'+val+'"> Articulo </label><select name="articulo'+val+'" id="articulo'+val+'"></select>';
		inputs+='<label for="noparte'+val+'"> No. de Parte </label><input type="text" style="width:55px;" name="noparte'+val+'" id="noparte'+val+'" required="required">';
		inputs+='<label for="cantidad'+val+'"> Cantidad </label><input type="number" min="1" style="width:55px;" name="cantidad'+val+'" id="cantidad'+val+'" required="required">';
		var $liNuevoNombre=$('<li/>').html('<a class="clsEliminarElemento">X</a>'+$.trim(inputs));
		$ulLista.append($liNuevoNombre);
		Articulos('articulo'+val);
	}
	}
		
	});

	$('.clsEliminarElemento').live('click',function(){
		var $ulLista=$('#divLista').find('ul');
		var $liPadre=$($(this).parents().get(0));
		$liPadre.remove();
		if($ulLista.find('li').length==0) $ulLista.remove();
	});
	
	$('#btnEliminarTodo').on('click', eliminalista());
	$('#articulo1').keypress(function(){
        var service = $(this).val();
        var dataString = 'articulo1='+service;
        $.ajax({
            type: "POST",
            url: "includes/Articulos.php",
            data: dataString,
            success: function(data){
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.suggest-element').live('click', function(){
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#articulo1').val($('#'+id).attr('data'));
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestions').fadeOut(1000);
                });              
            }
        });
    });
});

function eliminalista(){
		$('#divLista ul').remove();
	}