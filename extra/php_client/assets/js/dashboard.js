jQuery(function(){
	/* Fecha o Toast */
	jQuery('.toast .close').on('click', function(){ 
		/* Esconde o TOAST */
		jQuery(this).parent().removeClass('show');
		/* Atualiza a URL para o endereço ./dashboard.js, caso vocês esteja em uma URL no formato http://localhost/<nome_site>,
		* você deve alterar o comando abaixo alterando o terceiro parâmetro para: 'localhost/<nome_site>/dashboard.php'.
		*/ 
		window.history.pushState({}, document.title, "/dashboard.php"); 
	});


	/* Abre o modal de cadastro de tarefas */
	jQuery('#new-task').on('click', function(){
		var modal = jQuery('.modal[data-ref="'+jQuery(this).attr('data-ref')+'"]');
		modal.show();
	});
	/* Fecha o modal de cadastro de tarefas */
	jQuery('.modal .close').on('click', function(){
		jQuery(this).parent().hide();
	});

	/* Aplica a máscara em inputs da classe 'date_time' */
	jQuery('.date_time').mask('00-00-0000 00:00');

	/* #### Exclusão de tarefa ####
	* Aqui é interrompido o comportamento padrão do clique no botão
	* e apenas é realizada a submissão do formulário, se o usuário
	* clicar em 'OK' no popup de confirmação.
	*/
	jQuery('form.delete-task .btn.delete').click(function(evento){
		evento.preventDefault();
		var form = jQuery(this).parent();
		if(confirm('Você confirma a exclusão dessa tarefa?')){
			form.submit();
		}
	});
});