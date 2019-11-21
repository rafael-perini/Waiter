// Cookies Treatment
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function logar(identificador, senha) {
	$.ajax({
		url: "http://localhost/TCC/Waiter/server/php/usuarios.php?method=autenticar",
		data: {
			"identificador" : identificador,
			"senha" : senha
		},
		type: "POST",
		success: function(result){
			console.log($(result));
			var id = $(result).find("response").text();
			
			setCookie("idUsuario", id);
			setCookie("identificadorUsuario", identificador);
			setCookie("senha", senha);
			
			location.href = "index.php";
		},
		error: function(xhr,status,error){
			var mensagem = $(xhr.responseText).find("message").text();
			
			$.alert(mensagem);
		}
	});
}