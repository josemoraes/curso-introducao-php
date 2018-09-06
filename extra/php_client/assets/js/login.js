/*
* Aqui, é utilizado o evento `onload` do BOM (Browser Object Model) `window`.
* Isto significa que todas as operações encapsuladas por esse evento, acontecerão
* quando a janela do navegador terminar de ser carregada.
*/
window.onload = function(){

	/*
	* Este é o bloco de declarações de variáveis.
	* Utilizamos o querySelector para selecionar os elementos desejados
	* de forma similar ao CSS.
	*/	
	var btnExibeCadastro 	= document.querySelector('a#show-cadastro');
	var btnExibeLogin 	  	= document.querySelector('a#show-login');
	var formCadastro  		= document.querySelector('#form-cadastro');
	var formLogin  	  		= document.querySelector('#form-login');

	/*
	* Nesse trecho, é adicionado um listener no evento de click
	* do botão que exibe o cadastro. Ele tem a função de realizar
	* a operação encapsulada na função atribuída à ele toda vez
	* que o evento de clique do botão acontecer.
	*/
	btnExibeCadastro.onclick = function(evento){
		/* Previne que o evento padrão do elemento <a> ocorra. Nesse caso, o link não mudaria a página. */
		evento.preventDefault();
		/* Aqui, são alteradas as propriedades CSS, display, de cada um dos elementos. */
		formLogin.style.display 	= 'none';
		formCadastro.style.display 	= 'block';
	}

	btnExibeLogin.onclick = function(evento){
		evento.preventDefault();
		formCadastro.style.display 	= 'none';
		formLogin.style.display 	= 'block';
	}


	/* Código em Jquery */

	jQuery('.toast .close').on('click', function(){ jQuery(this).parent().removeClass('show'); });
}