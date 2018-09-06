# Manipulação de Datas em PHP

Neste tópico ainda utilizaremos o arquivo `index.php` do diretório `./xampp/htdocs/php_server/login` para testes. Desta forma vamos conseguir um teste simplificado sem precisar de mais arquivos.

Aqui serão abordados os seguintes tópicos:

- [timezones](#timezones);
- [date e DateTime](#date-datetime);
- [timestamp](#timestamp);

Abra o arquivo `index.php` e caso houver algum código dentro da função `request_post`, apague-o.


## timezones

Sabemos que cada País possui seu fuso horário, portanto, devemos considerar esse fato quando programamos datas em um servidor. Imagine que o servidor que processará nosso código PHP esteja na inglaterra, há grandes chances desse computador estar configurado com o horário local de lá, dito isso, sabemos que a configuração do computador e/ou header de requisição deve ser considerado para esse tipo de informação.

Portanto, devemos antes de tudo configurar o "Timezone" (zona de tempo) que desejamos programar. Um exemplo é demonstrado no código abaixo:

``` php
	// Fuso Estados Unidos
	date_default_timezone_set('America/Los_Angeles');
	echo date("Y-m-d H:i:s", time());
	echo "<br>";
	// Fuso Brasileiro
	date_default_timezone_set('America/Sao_Paulo');
	echo date("Y-m-d H:i:s", time());
	echo "<br>";
	// Meridiano de Greenwich
	date_default_timezone_set('UTC');
	echo date("Y-m-d H:i:s", time());
```

Note que estamos utilizando a função ``date_default_timezone_set()`` para informar o horário e a ``date()`` para instanciar a data para manipulação. Veremos mais sobre essa função nos próximos itens deste tópico.

Copie o código e teste-o na função ``request_post``. Observe que temos três horários na saída, um como fuso dos Estados Unidos, outro do Brasil e o último do Meridiano de Greenwich.

```
2018-09-06 14:06:38
<br>2018-09-06 18:06:38
<br>2018-09-06 21:06:38
```

Utilizamos a sigla UTC (Coordinated Universal Time) para informar o "horário universal".

Altere o código como o bloco abaixo:

``` php
	// Fuso Brasileiro
	date_default_timezone_set('America/Sao_Paulo');
	echo date("Y-m-d H:i:s", time());
	echo "<br>";
```

Salve o script.


Para mais detalhes sobre esta função, consulte: [Manual do PHP - Funções de Data/Hora](http://php.net/manual/pt_BR/function.date-default-timezone-set.php)



##date-datetime



