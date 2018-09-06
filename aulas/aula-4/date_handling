# Manipulação de Datas em PHP


Abra o arquivo `index.php` do diretório `./xampp/htdocs/php_server/login`.

Altere a linha de código de dentro do case `POST` para `$result = request_post();`.

Após o comando `echo($result);`, crie o método `function request_post(){}`. Quando este arquivo receber uma requisição POST, essa função será executada.

Dentro dessa função, testaremos alguns recursos do PHP para manipular strings, tais como:

- [explode](#explode);
- [strtoupper, strtolower, lcfirst e ucwords](#strtoupper-e-strtolower);
- [substr](#substr);
- [strlen](#strlen);
- [str_replace](#str_replace).


## explode

O código abaixo demonstra um dexemplo do uso do método `explode()`:

``` php

<?php 

/*
* Explode é uma função que permite que uma string seja divida em N partes, por meio de um caractere divisor; Retorna um array.
* A estrutura da função é: (array) explode([divisor], [string], [numero_divisões])
* O parâmetro formal, "numero_divisões" é opcional e indica quantas vezes a string deve ser dividida. Caso não seja informada
* a função irá percorrer todo a string e dividirá por quantas vezes identificar o caractere informado no primeiro parâmetro.
*/

$texto = 'Nescau é melhor do que Toddy';

/* Aqui estamos indicando que o texto deve ser dividido toda vez que for encontrado o caractere espaço */
$textoEmArray = explode(' ', $texto);

var_dump($texto);
var_export($textoEmArray);

/*
* var_dump: Esta função mostrará uma representação estruturada sobre uma ou mais expressões, 
* incluindo o tipo e o valor. Arrays e objetos são explorados recursivamente com valores identados na estrutura mostrada.
* 
* var_export: obtém informação estruturada sobre uma dada variável. Ela é similar a var_dump() com uma exceção: 
* a representação retornada é um código PHP válido;
*/

``` 

Copie o exemplo dentro da função "request_post", salve e execute o arquivo para teste.

Note que foi retornado um erro. Isso realmente era para acontecer, pois não alteramos o tipo de retorno para a requisição. Havíamos programado anteriormente para retornar um documento JSON, porém nosso código atual utiliza os comandos `var_dump` e `var_export` para "escrever na saída" o valor das variáveis e alguns detalhes a mais.

Comente a linha em que configuramos o tipo de retorno no header, utilizando `//`.

``` php
//header('Content-Type: application/json');
```

Também é possível fazer comentários em blocos utilizando `/* ... */`. 

Salve e teste novamente.

Agora temos a seguinte saída:

```
string(29) "Nescau é melhor do que Toddy"
array (
  0 => 'Nescau',
  1 => 'é',
  2 => 'melhor',
  3 => 'do',
  4 => 'que',
  5 => 'Toddy',
)
``` 

Para mais detalhes sobre a função, consulte: [Manual do PHP - Explode](http://php.net/manual/pt_BR/function.explode.php)


## strtoupper, strtolower, lcfirst e ucwords

Apague todo o conteúdo dentro da função `request_post`.

Agora vamos entender como as funções `strtoupper()`, `strtolower`, `lcfirst` e `ucwords` operam. Um exemplo é demonstrado logo abaixo:

``` php

<?php 

/*
-----------------------------------------------------------------------
strtoupper: Converte string em maiúsculas. Retorna a string convertida.
strtolower: Converte string em minúsculas. Retorna a string convertida.
lcfirst: Converte o primeiro caractere de uma string para minúscula
ucwords: Converte o primeiro caractere de cada palavra em uma string para minúscula.
-----------------------------------------------------------------------
*/

$textoMinusculo = 'lorem ipsum dolor sit amet, consectetur adipisicing';
$textoMisturado = 'LoRem Ipsum DOLOR sit amet, conSECTetur ADIPISICING';
$textoMaiusculo = 'LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING';

echo '<br>';
echo 'Minúsculo: '.$textoMinusculo;
echo '<br>';
echo 'Misto: '.$textoMisturado;
echo '<br>';
echo 'Maiúsculo: '.$textoMaiusculo;
echo '<br><br>';

/* Impressão dos textos em maiúsculo */
echo "strtoupper em Minúsculo: ".strtoupper($textoMinusculo);
echo '<br>';
echo "strtoupper em Misto: ".strtoupper($textoMisturado);
echo '<br><br>';

/* Impressão dos textos em minúsculo */
echo '<br>';
echo "strtolower em Maiúsculo: ".strtolower($textoMaiusculo);
echo '<br>';
echo "strtolower em Misto: ".strtolower($textoMisturado);
echo '<br>';
		
/* Primeiro caractere minúsculo */
echo '<br>';
echo "lcfirst em Maiúsculo: ".lcfirst($textoMaiusculo);
echo '<br>';
echo "ucwords em Minúsculo: ".ucwords($textoMinusculo);

```

Note que utilizamos o caractere `.` para concatenar valores de string. Salve e teste o script. A saída será semelhante ao código abaixo:

```
<br>Minúsculo: lorem ipsum dolor sit amet, consectetur adipisicing
<br>Misto: LoRem Ipsum DOLOR sit amet, conSECTetur ADIPISICING
<br>Maiúsculo: LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING
<br>
<br>strtoupper em Minúsculo: LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING
<br>strtoupper em Misto: LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING
<br>
<br>
<br>strtolower em Maiúsculo: lorem ipsum dolor sit amet, consectetur adipisicing
<br>strtolower em Misto: lorem ipsum dolor sit amet, consectetur adipisicing
<br>
<br>lcfirst em Maiúsculo: lOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING
<br>ucwords em Minúsculo: Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing
```

Para mais detalhes sobre essas funções, consulte: 
- [Manual do PHP - strtoupper](http://php.net/manual/pt_BR/function.strtoupper.php)
- [Manual do PHP - strtolower](http://php.net/manual/pt_BR/function.strtolower.php)
- [Manual do PHP - lcfirst](http://php.net/manual/pt_BR/function.lcfirst.php)
- [Manual do PHP - ucwords](http://php.net/manual/pt_BR/function.ucwords.php)


## substr

Apague todo o conteúdo dentro da função `request_post`.

Agora vamos entender como a função `substr()` opera. Um exemplo é demonstrado logo abaixo: 

``` php

<?php

/*
-----------------------------------------------------------------------

substr: Retorna a parte de string especificada pelo parâmetro start e length.
		Se a string for mais curta que o parâmetro start, FALSE será retornado.

declaração: string substr ( string $string , int $start [, int $length ] )

-----------------------------------------------------------------------

*/

/* Uso básico da função */

echo substr('abcdef', 1);     // retorna "bcdef"
echo '<br>';
echo substr('abcdef', 1, 3);  // retorna "bcd"
echo '<br>';
echo substr('abcdef', 0, 4);  // retorna "abcd"
echo '<br>';
echo substr('abcdef', 0, 8);  // retorna "abcdef"
echo '<br>';
echo substr('abcdef', -1, 1); // retorna "f"
echo '<br>';


/* Se start for negativo, a string retornada irá começar no caractere start a partir do fim de string*/

echo substr("abcdef", -1);    // retorna "f"
echo '<br>';
echo substr("abcdef", -2);    // retorna "ef"
echo '<br>';
echo substr("abcdef", -3, 1); // retorna "d"
echo '<br>';

```

Salve e teste o script. Agora temos a seguinte saída:

```
bcdef
<br>bcd
<br>abcd
<br>abcdef
<br>f
<br>f
<br>ef
<br>d
<br>
```

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - substr](http://php.net/manual/pt_BR/function.substr.php)


## strlen

Uma string pode ser considerar um array de caracteres, portanto, várias de suas operações se assemelham a de vetores.

Apague todo o conteúdo dentro da função `request_post`.

Agora vamos entender como a função `strlen()` opera. Copie a função do exemplo abaixo antes da função `request_post`.

Copie o restante do código dentro da função `request_post`.


``` php

<?php

/*
-----------------------------------------------------------------------
strlen: Retorna o tamanho de uma string
declaração: int strlen ( string $string )
-----------------------------------------------------------------------
*/

echo strlen('Boa noite'); // Retorna 9
echo "<br>";
echo strlen('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos perferendis'); // Retorna 81

/* Vamos supor que Eu precise validar o tamanho de um campo. */
$textoMaior = 'Lorem ipsum dolor sit';
$textoMenor = 'Oi';

echo "<br>";

echo verificaTamanho($textoMaior);

echo "<br>";

echo verificaTamanho($textoMenor);

/* Função que verifica o tamanho da string */
function verificaTamanho($str = ''){
	return (strlen($str) > 20) 
			? "Erro. Esse campo aceita apenas 20 caracteres. Foram passados ".strlen($str)." caracteres"
			: 'Texto com tamanho correto. Foram passados '.strlen($str)." caracteres";
}

```

Salve e execute o script. Vamos obter a seguinte saída:

```
9
<br>81
<br>Erro. Esse campo aceita apenas 20 caracteres. Foram passados 21 caracteres
<br>Texto com tamanho correto. Foram passados 2 caracteres
```

Apague a função copiada e o bloco de código de dentro da função `request_post`.

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - strlen](http://php.net/manual/pt_BR/function.strlen.php)


## str_replace

Agora vamos entender como a função `str_replace()` opera. Um exemplo de seu uso é ilustrado abaixo:


``` php

<?php

/*
-----------------------------------------------------------------------

str_replace: Esta função retorna uma string ou um array com todas as ocorrências de search em subject substituídas com o valor dado para replace.

declaração: mixed str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )

-----------------------------------------------------------------------
*/

$palavra_substituida  	= 'Batata';
$palavra_vai_substituir = 'Queijo';
$frase = 'Pão de Batata';
echo str_replace($palavra_substituida, $palavra_vai_substituir, $frase);
echo "<br>";

// Fornece: Hll Wrld f PHP
$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
$onlyconsonants = str_replace($vowels, "", "Hello World of PHP");
echo $onlyconsonants;
echo '<br>';

// Fornece: você comeria pizza, cerveja e sorvete todos os dias
$frase  = "você comeria frutas, vegetais, e fibra todos os dias.";
$saudavel = array("frutas", "vegetais", "fibra");
$saboroso   = array("pizza", "cerveja", "sorvete");

$novafrase = str_replace($saudavel, $saboroso, $frase);
echo $novafrase;

```

Copie o código para a função `request_post()`. Salve e execute o arquivo.

Vamos obter uma saída semelhante a essa:

```
Pão de Queijo
<br>Hll Wrld f PHP
<br>você comeria pizza, cerveja, e sorvete todos os dias.
```

Apague o conteúdo do método ``request_post`` e salve o arquivo.

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - str_replace](http://php.net/manual/pt_BR/function.str-replace.php)

