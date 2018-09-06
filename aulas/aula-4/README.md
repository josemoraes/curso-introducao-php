# Vamos praticar - Manipulação de Strings em PHP

Acesse o diretório `./xampp/htdocs` e crie uma pasta com o nome `aula_5`.
Nessa aula abordaremos as funções de string:

- [explode](#explode);
- [strtoupper e strtolower](#strtoupper-e-strtolower);
- [substr](#substr);
- [strlen](#strlen);
- [str_replace](#str_replace).


## explode

Na pasta `aula_5`, crie um arquivo chamado `explode.php`; copie e cole o código abaixo:

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

echo "<pre>";
var_dump($texto);
var_export($textoEmArray);
echo "</pre>";

/*
* var_dump: Esta função mostrará uma representação estruturada sobre uma ou mais expressões, 
* incluindo o tipo e o valor. Arrays e objetos são explorados recursivamente com valores identados na estrutura mostrada.
* 
* var_export: obtém informação estruturada sobre uma dada variável. Ela é similar a var_dump() com uma exceção: 
* a representação retornada é um código PHP válido;
*/

``` 

Salve o arquivo; inicialize o Apache pelo Xampp; acesse a URL `http://localhost/aula_5/explode.php` e veja se o resultado é semelhante ao da Figura 1.

| ![Figura 1 - Explode](/aulas/aula-5/img/figura_1.png) | 
|:--:| 
| **Figura 1 - Explode** |

Para mais detalhes sobre a função, consulte: [Manual do PHP - Explode](http://php.net/manual/pt_BR/function.explode.php)


## strtoupper e strtolower

Na pasta `aula_5`, crie um arquivo chamado `strtoupper-strtolower.php`; copie e cole o código abaixo:

``` php

<?php 

/*
-----------------------------------------------------------------------
strtoupper: Converte string em maiúsculas. Retorna a string convertida.
-----------------------------------------------------------------------

-----------------------------------------------------------------------
strtolower: Converte string em minúsculas. Retorna a string convertida.
-----------------------------------------------------------------------
*/

$textoMinusculo = 'lorem ipsum dolor sit amet, consectetur adipisicing';
$textoMisturado = 'LoRem Ipsum DOLOR sit amet, conSECTetur ADIPISICING';
$textoMaiusculo = 'LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING';

/* Impressão dos textos em maiúsculo */
echo strtoupper($textoMinusculo);
echo '<br>';
echo strtoupper($textoMisturado);

echo '<br><br>';

/* Impressão dos textos em minúsculo */

echo strtolower($textoMaiusculo);
echo '<br>';
echo strtolower($textoMisturado);

```

Salve o arquivo; inicialize o Apache pelo Xampp; acesse a URL `http://localhost/aula_5/strtoupper-strtolower.php` e veja se o resultado é semelhante ao da Figura 2.

| ![Figura 2 - strtoupper e strtolower](/aulas/aula-5/img/figura_2.png) | 
|:--:| 
| **Figura 2 - strtoupper e strtolower** |

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - strtoupper](http://php.net/manual/pt_BR/function.strtoupper.php)
- [Manual do PHP - strtolower](http://php.net/manual/pt_BR/function.strtolower.php)


## substr

Na pasta `aula_5`, crie um arquivo chamado `substr.php`; copie e cole o código abaixo:

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

Salve o arquivo; inicialize o Apache pelo Xampp; acesse a URL `http://localhost/aula_5/substr.php` e veja se o resultado é semelhante ao da Figura 3.

| ![Figura 3 - substr](/aulas/aula-5/img/figura_3.png) | 
|:--:| 
| **Figura 3 - substr** |

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - substr](http://php.net/manual/pt_BR/function.substr.php)


## strlen

Na pasta `aula_5`, crie um arquivo chamado `strlen.php`; copie e cole o código abaixo:

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

Salve o arquivo; inicialize o Apache pelo Xampp; acesse a URL `http://localhost/aula_5/strlen.php` e veja se o resultado é semelhante ao da Figura 4.

| ![Figura 4 - strlen](/aulas/aula-5/img/figura_4.png) | 
|:--:| 
| **Figura 4 - strlen** |

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - strlen](http://php.net/manual/pt_BR/function.strlen.php)


## str_replace

Na pasta `aula_5`, crie um arquivo chamado `str_replace.php`; copie e cole o código abaixo:

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

Salve o arquivo; inicialize o Apache pelo Xampp; acesse a URL `http://localhost/aula_5/str_replace.php` e veja se o resultado é semelhante ao da Figura 5.

| ![Figura 5 - str_replace](/aulas/aula-5/img/figura_5.png) | 
|:--:| 
| **Figura 5 - str_replace** |

Para mais detalhes sobre a função, consulte: 
- [Manual do PHP - str_replace](http://php.net/manual/pt_BR/function.str-replace.php)

