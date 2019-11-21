$(document).ready(function() {
    "use strict";
	
    // Focus input
    $('.input').each(function(){
		$(this).on('blur', function(){
            if ($(this).val().trim() != "") {
                $(this).addClass('has-val');
            } else {
                $(this).removeClass('has-val');
            }
        })    
    });
  
  
    // Validate
    var input = $('.validate-input .input');

    function validateForm(input) {
        var check = true;

        for (var i=0; i<input.length; i++) {
            if (validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    }


    $('.validate-form .input').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate(input) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else {
            if ($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
	// Submit Singup
	$("#singupForm").on("submit", function(event) {
		event.preventDefault();
		
		if (validateForm(input)) {
			var identificador = $("#username").val();
			var nome = $("#name").val();
			var senha = $("#password").val();
			
			$.ajax({
				url: "http://localhost/TCC/Waiter/server/php/usuarios.php?method=salvar",
				data: {
					"id" : "",
					"identificador" : identificador,
					"nome" : nome,
					"senha" : senha
				},
				type: "POST",
				success: function(result){
					logar(identificador,senha);
				},
				error: function(xhr,status,error){
					var mensagem = "Dados inválidos! Seu identificador pode estar sendo utilizado por outra pessoa.";
					
					$.alert(mensagem);
				}
			});
		}
	});
});