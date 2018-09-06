# Manipulação de Datas em PHP

Neste tópico ainda utilizaremos o arquivo `index.php` do diretório `./xampp/htdocs/php_server/login` para testes. Desta forma vamos conseguir um teste simplificado sem precisar de mais arquivos.

Aqui serão abordados os seguintes tópicos:

- [timezones](#timezones);
- [timestamp](#timestamp);
- [date e DateTime](#date-datetime);

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

## timestamp

As datas são operadas com o tipo ``string`` (como o usuário verá) ou ``long`` (milliseconds). Chamamos de ``timestamp`` (Unix timestamp) o padrão formatado para o tipo ``long``. Podemos obter esse valor com a função ``time()``.

Geralmente o padrão timestamp é utilizado para a comunicação de diferentes softwares ou de módulos de um software.

Pode-se observar que, na função que estamos editando, o método ``date()`` recebe como segundo parâmetro o timestamp para convertê-lo em um formato string.

Também podemos adquirir esse formato através dos métodos ``mktime()`` e ``strtotime()``. Adicione o seguinte bloco de código:

```php
  // time — Retorna o timestamp Unix atual
  echo time(), "\n";
  
  /**
   * int mktime ([ int $hora [, int $minuto [, int $second [, int $mes [, int $dia [, int $ano [, int $is_dst ]]]]]]] )
   * Obtém um timestamp Unix de uma data
   */
  echo date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997)), "\n";
  
  /**
   * int strtotime ( string $time [, int $now ] )
   * Interpreta qualquer descrição de data/hora em texto em inglês em timestamp Unix
   */
  echo strtotime("now"), "\n";
  echo strtotime("10 September 2000"), "\n";
  echo strtotime("+1 day"), "\n";
  echo strtotime("+1 week"), "\n";
  echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
  echo strtotime("next Thursday"), "\n";
  echo strtotime("last Monday"), "\n";
  
  echo "\n" . $tomorrow  = mktime (0, 0, 0, date("m")  , date("d")+1, date("Y"));
  echo "\n" . $lastmonth = mktime (0, 0, 0, date("m")-1, date("d"),  date("Y"));
  echo "\n" . $nextyear  = mktime (0, 0, 0, date("m"),  date("d"),  date("Y")+1);
```

Salve e teste nosso código.

Saída esperada:
```
2018-09-06 18:43:01
<br>1536270181
Jan-01-1998
1536270181
968554800
1536356581
1536874981
1537062183
1536807600
1535943600
1536289200
1533524400
1567738800
```

Para mais detalhes sobre a função time, consulte: [Manual do PHP - time](http://www.php.net/manual/pt_BR/function.time.php)

Para mais detalhes sobre a função time, consulte: [Manual do PHP - mktime](http://www.php.net/manual/pt_BR/function.mktime.php)

Para mais detalhes sobre a função time, consulte: [Manual do PHP - strtotime](http://www.php.net/manual/pt_BR/function.strtotime.php)

## date-datetime

O formato da data para a leitura do usuário é informado no primeiro parâmetro. Nesta seção serão demontrados alguns dos diversos formatos de parâmetros que a função ``date()`` pode receber. A implementação desses formatos são demonstrados no código abaixo:

``` php
/**
 * string date ( string $format [, int $timestamp ] )
 * Retorna uma string de acordo com a string de formato informada usando o inteiro timestamp informado, 
 * ou a hora atual local se nenhum timestamp for informado. Em outras palavras, o parâmetro timestamp é 
 * opcional e padronizado para o valor de time().
 * @return string da data formatada.
 */
 
 // Fuso Brasileiro
 date_default_timezone_set('America/Sao_Paulo');
 echo date("Y-m-d H:i:s", time());
 echo "<br>";

 // Exibe alguma coisa como: Monday
 echo date("l");
 echo "\n";

 // Exibe alguma coisa como: Monday 8th of August 2005 03:12:46 PM
 echo date('l jS \of F Y h:i:s A');
 echo "<br>";

 // Exibe: July 1, 2000 is on a Saturday
 echo "July 1, 2000 is on a " . date("l", mktime(0, 0, 0, 7, 1, 2000));
 echo "<br>";
		
 // exibe algo como: Wednesday the 15th
 echo date("l \\t\h\e jS");
 
 echo "<br>" . date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
 echo "<br>" . date("m.d.y");                         // 03.10.01
 echo "<br>" . date("j, n, Y");                       // 10, 3, 2001
 echo "<br>" . date("Ymd");                           // 20010310
 echo "<br>" . date('h-i-s, j-m-y, it is w Day');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
 echo "<br>" . date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
 echo "<br>" . date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 MST 2001
 echo "<br>" . date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
 echo "<br>" . date("H:i:s");                         // 17:16:18
 echo "<br>" . date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)
 echo "\n";
 // getdate — Recupera informações de data/hora
 $today = getdate();
 echo($today["month"]);
 ```

Substitua o código atual pelo exemplo e teste-o. 

Saída esperada:

```
2018-09-06 18:51:14
<br>Thursday
Thursday 6th of September 2018 06:51:14 PM
<br>July 1, 2000 is on a Saturday
<br>Thursday th 6th
<br>September 6, 2018, 6:51 pm
<br>09.06.18
<br>6, 9, 2018
<br>20180906
<br>06-51-14, 6-09-18, 5130 5114 4 Thupm18
<br>it is the 6th day.
<br>Thu Sep 6 18:51:14 -03 2018
<br>18:09:14 m is month
<br>18:51:14
<br>2018-09-06 18:51:14
September
```
Todos esses formatos também podem ser manipulados através da classe ``DateTime`` (PHP 5 >= 5.2.0, PHP 7). Substitua o código atual pelo exemplo apresentado abaixo:

```php
/**
 * Construtor: public __construct ([ string $time = "now" [, DateTimeZone $timezone = NULL ]] )
 *
 *  A classe também nos facilita com constantes representando os diversos formatos
 *	const string ATOM = "Y-m-d\TH:i:sP" ;
 *	const string COOKIE = "l, d-M-Y H:i:s T" ;
 *	const string ISO8601 = "Y-m-d\TH:i:sO" ;
 *	const string RFC822 = "D, d M y H:i:s O" ;
 *	const string RFC850 = "l, d-M-y H:i:s T" ;
 *	const string RFC1036 = "D, d M y H:i:s O" ;
 *	const string RFC1123 = "D, d M Y H:i:s O" ;
 *	const string RFC2822 = "D, d M Y H:i:s O" ;
 *	const string RFC3339 = "Y-m-d\TH:i:sP" ;
 *	const string RSS = "D, d M Y H:i:s O" ;
 *	const string W3C = "Y-m-d\TH:i:sP" ;
*/
$date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
@$date->setTimestamp(1536270181);
echo $date->format('Y-m-d H:i:s');
```

Salve e teste o código.

Para mais detalhes sobre a função date, consulte: [Manual do PHP - date](http://www.php.net/manual/pt_BR/function.date.php)

Para mais detalhes sobre a classe DateTime, consulte: [Manual do PHP - DateTime](http://php.net/manual/pt_BR/class.datetime.php)



