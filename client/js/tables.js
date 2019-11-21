function carregarEventosTabelaDados(dataTableId, $dataTable) {
	var $table = $("#" + dataTableId);
	var $tableAdd = $table.parents().find(".table-add");
	
	$($table.children().find("td").get(0)).attr("contenteditable","true");
	$($table.children().find("td").get(1)).attr("contenteditable","true");
	
	$tableAdd.unbind();
	
	$tableAdd.click(function () {
		$dataTable.row.add({
			"id" : "",
			"nome" : "",
			"valor" : "",
			"excluir" : "<span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'>Excluir</button></span>"
		}).draw();
		
		$table.children().find("td").attr("contenteditable","true");
		$table.children().find("td").attr("contenteditable","true");

		carregarEventoDeleteTabelaDados(dataTableId, $dataTable);
	});
	
	carregarEventoDeleteTabelaDados(dataTableId, $dataTable);
}

function carregarEventoDeleteTabelaDados(dataTableId, $dataTable) {
	$("#" + dataTableId + " .table-remove").unbind();
	
	$("#" + dataTableId + " tbody tr").focusout(function() {
		var linha = $(this);
		var colunas = linha.find("td");
		var nome = ($(colunas.get(0)).text());
		var valor = ($(colunas.get(1)).text());
		
		var linhaTabela = $dataTable.row(this).data();
		var id = linhaTabela.id;
		linhaTabela.nome = nome;
		linhaTabela.valor = valor;
		
		$.ajax({
			url: "http://localhost/TCC/Waiter/server/php/dadosPessoais.php?method=salvar",
			data: {
				"idUsuario" : getCookie("idUsuario"),
				"id" : id,
				"nome" : nome,
				"valor" : valor
			},
			success: function(result){
				id = $(result).find("id").text();
				linhaTabela.id = id;
			},
			error: function(xhr,status,error){
				$.alert("<h6>Houve um erro ao tentar salvar os dados.</h6>");
			}
		});
	});
	
	$("#" + dataTableId + " .table-remove").click(function () {
		var linha = $dataTable.row($(this).parents("tr")).data();
		var id = linha.id;
		
		if (id.length > 0) {
			$.confirm({
				title: '',
				content: '<h6>Confirma exclusão do dado?</h6>',
				buttons: {
					confirma: {
						btnClass: "btn-red",
						action: function () {
							$.ajax({
								url: "http://localhost/TCC/Waiter/server/php/dadosPessoais.php?method=excluir",
								data: {
									"idUsuario" : getCookie("idUsuario"),
									"id" : id
								},
								success: function(result){
									carregarTabelaDados(dataTableId);
								},
								error: function(xhr,status,error){
									$.alert(error);
								}
							});
						}
					},
					cancela: {}
				}
			});
		}
	});
}

function carregarTabelaDados(dataTableId) {
	$table = $("#" + dataTableId).DataTable({
		"columns": [{
			"data" : "id",
			"visible" : false,
			"defaultContent" : ""
		},{
			"data" : "nome",
			"defaultContent" : ""
		},{
			"data" : "valor",
			"defaultContent" : ""
		},{
			"data" : "excluir",
			"defaultContent" : ""
		}],
		"retrieve" : true,
		"paging": false,
		"bInfo": false,
		"language": {
			"search": "Procurar:"
		}
	});
	
	$table.rows().remove();
	$table.rows().draw();
	
	carregarEventosTabelaDados(dataTableId, $table);
	
	$.ajax({
		url: "http://localhost/TCC/Waiter/server/php/dadosPessoais.php?method=obterCamposUsuario",
		data: {
			"identificadorUsuario" : getCookie("identificadorUsuario"),
			"senha" : getCookie("senha")
		},
		success: function(result){
			$(result).find("obterCamposUsuario").each(function(){
				$(this).children().each(function() {
					var tagName = $(this).get(0).tagName;
					
					if ((tagName != "status")&&(tagName != "response")) {
						var id = $(this).find("id").text();
						var nome = $(this).find("nome").text();
						var valor = $(this).find("valor").text();
						
						$table.row.add({
							"id" : id,
							"nome" : nome,
							"valor" : valor,
							"excluir" : "<span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'>Excluir</button></span>"
						}).draw();
						
						carregarEventosTabelaDados(dataTableId, $table);
					}
				});
			});
		},
		error: function(xhr,status,error){
			console.log(error);
		}
	});
}

function carregarEventosTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId) {
	carregarEventoAcceptTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId);
	carregarEventoDeleteTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId);
	carregarEventoDetailTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId);
}

function carregarEventoDetailTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId) {
	$('.data-item').unbind();
	
	// Modal popup
	$('.data-item').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#solicitationsTableList',
		modal: true
	});
	
	$('.data-item').on("click", function() {
		var linha = $solicitationsTable.row($(this).parents("tr")).data();
		var campos = linha.campos;
		
		carregarTabelaDetalhaSolicitacao(solicitationsDetailTableId,campos);
	});
	
	$(document).on('click', '.data-modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});
}

function carregarEventoAcceptTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId) {
	$("#" + solicitationsTableId + " .table-accept").unbind();
	
	$("#" + solicitationsTableId + " .table-accept").click(function () {
		var linha = $solicitationsTable.row($(this).parents("tr")).data();
		var id = linha.id;
		
		if (id.length > 0) {
			$.confirm({
				title: '',
				content: '<h6>Confirma autorização de acesso?</h6>',
				buttons: {
					confirma: {
						btnClass: "btn-green",
						action: function () {
							$.ajax({
								url: "http://localhost/TCC/Waiter/server/php/solicitacaoAcesso.php?method=autorizar",
								data: {
									"identificadorUsuario" : getCookie("identificadorUsuario"),
									"senha" : getCookie("senha"),
									"idSolicitacao" : id
								},
								success: function(result){
									carregarTabelaSolicitacoes(solicitationsTableId,solicitationsDetailTableId);
								},
								error: function(xhr,status,error){
									$.alert(error);
								}
							});
						}
					},
					cancela: {}
				}
			});
		}
	});
}

function carregarEventoDeleteTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId) {
	$("#" + solicitationsTableId + " .table-remove").unbind();
	
	$("#" + solicitationsTableId + " .table-remove").click(function () {
		var linha = $solicitationsTable.row($(this).parents("tr")).data();
		var id = linha.id;
		
		if (id.length > 0) {
			$.confirm({
				title: '',
				content: '<h6>Confirma exclusão da solicitação?</h6>',
				buttons: {
					confirma: {
						btnClass: "btn-red",
						action: function () {
							$.ajax({
								url: "http://localhost/TCC/Waiter/server/php/solicitacaoAcesso.php?method=excluir",
								data: {
									"id" : id
								},
								success: function(result){
									carregarTabelaSolicitacoes(solicitationsTableId,solicitationsDetailTableId);
								},
								error: function(xhr,status,error){
									$.alert(error);
								}
							});
						}
					},
					cancela: {}
				}
			});
		}
	});
}

function carregarTabelaSolicitacoes(solicitationsTableId, solicitationsDetailTableId) {
	$solicitationsTable = $("#" + solicitationsTableId).DataTable({
		"columns": [{
			"data" : "id",
			"visible" : false,
			"defaultContent" : ""
		},{
			"data" : "campos",
			"visible" : false,
			"defaultContent" : ""
		},{
			"data" : "solicitacoes",
			"defaultContent" : ""
		},{
			"data" : "detalhar",
			"defaultContent" : ""
		},{
			"data" : "aceitar",
			"defaultContent" : ""
		},{
			"data" : "recusar",
			"defaultContent" : ""
		}],
		"retrieve" : true,
		"paging": false,
		"searching": false,
		"bInfo": false
	});
	
	$solicitationsTable.rows().remove();
	$solicitationsTable.rows().draw();
	
	carregarEventosTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId);
	
	$.ajax({
		url: "http://localhost/TCC/Waiter/server/php/solicitacaoAcesso.php?method=obterSolicitacoesUsuario",
		data: {
			"identificadorUsuario" : getCookie("identificadorUsuario")
		},
		success: function(result){
			$(result).find("obterSolicitacoesUsuario").each(function(){
				$(this).children().each(function() {
					var tagName = $(this).get(0).tagName;
					
					if ((tagName != "status")&&(tagName != "response")) {
						var id = $(this).find("id").text();
						var aceita = $(this).find("aceita").text();
						var nomeEntidade = $(this).find("nomeEntidade").text();
						var campos = $(this).find("dadosPessoais").children()
						var quantidadeCampos = campos.length;
						
						var solicitacoes = nomeEntidade + " ( " + quantidadeCampos;
						
						if (quantidadeCampos > 1) {
							solicitacoes += " Campos )";
						} else {
							solicitacoes += " Campo )";
						}
						
						var stringCampos = [];
						campos.each(function() {
							stringCampos[stringCampos.length] = $(this).text();
						});
						
						var aceitar = "<span class='table-accept'><button type='button' class='btn btn-success btn-rounded btn-sm my-0'>Aceitar</button></span>"
						
						if (aceita == 1) {
							aceitar = "<h6>Autorizada</h6>"
						}
						
						$solicitationsTable.row.add({
							"id" : id,
							"campos" : stringCampos,
							"solicitacoes" : solicitacoes,
							"detalhar" : "<span class='table-detail'><a class='data-item d-block mx-auto' href='#data-modal'><button type='button' class='btn btn-info btn-rounded btn-sm my-0'>Detalhar</button></a></span>",
							"aceitar" : aceitar,
							"recusar" : "<span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'>Recusar</button></span>"
						}).draw();
						
						carregarEventosTabelaSolicitacoes(solicitationsTableId, $solicitationsTable, solicitationsDetailTableId);
					}
				});
			});
		},
		error: function(xhr,status,error){
			console.log(error);
		}
	});
}

function carregarTabelaDetalhaSolicitacao(solicitationsDetailTableId, campos) {
	var tbody = $("#" + solicitationsDetailTableId).find("tbody");
	
	tbody.find("tr").detach();
	
	for (i in campos) {
		var campo = campos[i];
		var html = "<tr";
		
		if ((i % 2) != 0) {
			html += " style='background-color: #FFFFFF;'";
		}
		
		html += "><td>" + campo + "</td><tr>";
		
		tbody.append(html);
	};
}