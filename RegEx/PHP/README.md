# Expressões Regulares em PHP

Um método de correspondência de padrões ou padrões dentro de uma sequência

## Início de string ^
preg_match('/^rato/', $string)

## Final de string $
preg_match('/rato$/', $string

## Uma expressão OU outra: |
preg_match('/rato|gato/')

Segue algumas possibilidades a serem usadas dentro dos colchetes:
```php
    .: qualquer caractere, exceto quebra de linha
    0-9: qualquer dígito
    \d: qualquer dígito
    a-z: qualquer letra minúscula
    A-Z: qualquer letra maiúscula
    a-c: qualquer letra minúscula entre "a" e "c"
    [:lower:]: qualquer letra minúscula
    [:upper:]: qualquer letra maiúscula
    [:alpha:]: qualquer letra
    [:alnum:]: qualquer letra ou dígito
    [:digit:]: qualquer dígito
    \w: qualquer caractere para montar palavras
    \s: qualquer caractere de espaço ou quebra de linha
```

## Não use mais POSIX, use PCRE

No PHP 5.3.0 (ano 2009) foram aposentadas (deprecated) todas as funções POSIX. Então daqui pra frente só use as equivalentes PCRE, e procure converter código antigo pra elas também.
```php
POSIX 	        PCRE
ereg_replace() 	preg_replace()
ereg() 	        preg_match()
eregi_replace() preg_replace()
eregi() 	    preg_match()
split() 	    preg_split()
spliti() 	    preg_split()
sql_regcase() 	—

Funções PCRE 	Objetivo
preg_filter 	Busca e substitui, retornando as opções do array que casarem com a expressão.
preg_grep 	Retorna as opções de um array que casarem com a expressão.
preg_last_error 	Retorna o código de erro da última expressão executada.
preg_match_all 	Retorna as ocorrências de uma string que casarem com a expressão.
preg_match 	Verifica se uma string casa com a expressão.
preg_quote 	Adiciona escape em caracteres da expressão.
preg_replace_callback 	Busca e executa um callback nas opções que casarem com a expressão.
preg_replace 	Busca e substitui, retornando todas as opções.
preg_split 	Divide uma string utilizando uma expressão.

Operadores Comuns da Regex
Operador	Propósito
. (ponto)	Corresponder a qualquer caractere único
^ (circunflexo)	Corresponder à string vazia que ocorre no início de uma linha ou string
$ (símbolo do dólar)	Corresponder à string vazia que ocorre no final de uma linha
A	Corresponder a uma letra maiúscula A
a	Corresponder a uma letra minúscula a
\d	Corresponder a qualquer dígito único
\D	Corresponder a qualquer caractere não dígito
\w	Corresponder a qualquer caractere alfanumérico; um sinônimo é [:alnum:]
[A-E]	Corresponder a qualquer letra maiúscula A, B, C, D ou E
[^A-E]	Corresponder a qualquer caractere, exceto à letra maiúscula A, B, C, D ou E
X?	Corresponder a nenhuma ou a uma letra maiúscula X
X*	Corresponder a zero ou mais letras maiúsculas X
X+	Corresponder a uma ou mais letras maiúsculas X
X{n}	Corresponder exatamente a n letras maiúsculas X
X{n,m}	Corresponder a pelo menos n e não mais do que m letras maiúsculas X ; se você omitir m, a expressão tenta corresponder pelo menos nX
(abc|def)+	Corresponder uma sequência de pelo menos um abc e def;abc e def corresponderiam 

<?php
$cpf = '12106836368';
$cpf = preg_replace("/[^0-9]/", "", $cpf);
echo $cpf;

para validar o nome do usuário quando é enviado a seu aplicativo: 
^[A-Za-z][A-Za-z0-9_]{2,9}$.


<?php
// Retorna true se "abc" existir em qualquer lugar de $string.
ereg ("abc", $string);

// Retorna true se "abc" existir no início de $string.
ereg ("^abc", $string);

// Retorna true se "abc" existir no final de $string.
ereg ("abc$", $string);

// Retorna true se o navegador do cliente  for Netscape 2, 3 ou MSIE 3.
eregi ("(ozilla.[23]|MSIE.3)", $_SERVER["HTTP_USER_AGENT"]);

// Adiciona três palavras separadas por espaço em $regs[1], $regs[2] e $regs[3].
ereg ("([[:alnum:]]+) ([[:alnum:]]+) ([[:alnum:]]+)", $string,$regs);

// Acrescenta a tag <br /> no início de $string.
$string = ereg_replace ("^", "<br />", $string);

// Acrescenta a tag <br />; no final de $string.
$string = ereg_replace ("$", "<br />", $string);

// Remove todos caracteres de nova linha (newline) em $string.
$string = ereg_replace ("\n", "", $string);


<?php
$cep = '22710-045';
$names = array('Diogo', 'Renato', 'Gomes', 'Thiago', 'Leonardo');
$text = 'Lorem ipsum dolor sit amet, consectetuer adipiscing.';
 
// Validação de CEP
$er = '/^(\d){5}-(\d){3}$/';
if(preg_match($er, $cep)) {
    echo "O cep casou com a expressão.";
}
// Resultado: O cep casou com a expressão.
 
// Busca e substitui nomes que tenham "go", case-insensitive
$er = '/go/i';
$pregReplace = preg_replace($er, 'GO', $names);
print_r($pregReplace);
// Resultado: DioGO, Renato, GOmes, ThiaGO, Leonardo
 
// Busca e substitui nomes que terminam com "go"
$er = '/go$/';
$pregFilter = preg_filter($er, 'GO', $names);
print_r($pregFilter);
// Resultado: DioGO, ThiaGO
 
// Resgatar nomes que começam com "go", case-insensitive
$er = '/^go/i';
$pregGrep = preg_grep($er, $names);
print_r($pregGrep);
// Resultado: Gomes
 
// Divide o texto por pontos e espaços, que podem ser seguidos por espaços
$er = '/[[:punct:]\s]\s*/';
$pregSplit = preg_split($er, $text);
print_r($pregSplit);
// Resultado: Array de palavras
 
// callback, retorna em letras maiúsculas
$callback = function($matches) {
    return strtoupper($matches[0]);
};
 
// Busca e substitui de acordo com o callback
$er = '/(.*)go$/';
$pregCallback = preg_replace_callback($er, $callback, $names);
print_r($pregCallback);
// Resultado: DIOGO, Renato, Gomes, THIAGO, Leonardo


Checar se uma string segue determinado padrão

// Exemplo
$string = 'ABC-1234';

// Checar se a string segue o padrao de uma placa de carro
if (preg_match('/^[A-Z]{3}\-[0-9]{4}$/', $string)) {
    // A string eh uma placa de carro valida
} else {
    // A string nao eh uma placa de carro valida
}

Capturar pedaços de uma string

// Exemplo
$cpf = '123.456.789-01';

// Capturar o digito verificador do CPF
if (preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-([0-9]{2})$/', $cpf, $partes)) {
    $digito_verificador = $partes[1];
}

Substituir pedaços de uma string por outra sequência de caracteres

// Exemplo 1: substituir vogais por "x":
$string = 'abcdefgh123';
$string2 = preg_replace('/[aeiou]/', 'x', $string);

// Exemplo 2: remover numeros de uma string
$string = 'abc123';
$string2 = preg_replace('/[0-9]/', '', $string);

// Exemplo 3: transformar um CPF com numeros em um CPF formatado
$string = '12345678901';
$string2 = preg_replace('/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/', '$1.$2.$3-$4', $string);

// Exemplo 4: transformar uma data no formato YYYY-MM-DD em DD/MM/YYYY
$string = '2015-02-01';
$string2 = preg_replace('/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/', '$3/$2/$1', $string);

// Exemplo 5: Converter as vogais de uma string para maiuscula
$string = 'abcdefgh123';
$string2 = preg_replace_callback(
    '/[aeiou]/',
    function($partes) {
        return strtoupper($partes[0]);
    },
    $string
);

Quebrar uma string em um array utilizando uma expressão regular

// Exemplo: quebrar a string quando encontrar ponto ou virgula
$string = 'abc, def. ghi';
$array = preg_split('/[,\.]/', $string);

// Capturar o prefixo de uma placa de carro (3 letras) e o sufixo (4 numeros)
$string = 'ABC-1234';
if (preg_match('/^([A-Z][A-Z][A-Z])-([0-9][0-9][0-9][0-9])$/', $string, $partes)) {
    echo $partes[0]; // ABC-1234
    echo $partes[1]; // ABC
    echo $partes[2]; // 1234
}

// Capturar o prefixo de uma placa de carro (3 letras)
$string = 'ABC-1234';
if (preg_match('/^([A-Z][A-Z][A-Z])-(?:[0-9][0-9][0-9][0-9])$/', $string, $partes)) {
    echo $partes[0];         // ABC-1234
    echo $partes[1];         // ABC
}


<?php
$meuPost = nl2br($_POST["msg"]);
$pattern = array(
	"/\[b](.*?)\[\/b]/",
	"/\[i](.*?)\[\/i]/",
	"/\[img](.*?)\[\/img]/"
); //sim! pode definir arrays de coisas pra achar e/ou substituir!
$replace = array(
	"<b>$1</b>",
	"<i>$1</i>",
	"<img src=\"$1\" />"
)
echo preg_replace($pattern, $replace, $meuPost);

Testador online
https://regex101.com/
```

Na caixa de texto acima digite:

/Bar8/

Na textarea abaixo ele somente reconhecerá quando você digitar
Bar8

Digite acima:

/[BLC]ar8/
```php
Abaixo:
Bar8
Lar8
Car8
LCar8
BCar8
BLCar8
```
Ou em outra ordem as 3 primeiras

Digite acima: ar são obrigatórias, BLC opcionais, apenas uma obrigatória. 854 opcionais, apenas uma obrigatória
/[BLC]ar[854]/
```php
Abaixo:
Bar8

Faixa A-Z

Digite acima
/[A-Z]ar8/

Abaixo uma:
Bar8

Acima:
/[A-Z-a-z]ar8/

Abaixo:
bar8

Acima
/[A-Z]ar[0-9]/

/[^CL]ar8/  (Não pode começar com C nem L)

/.ar8/  (O ponto diz que primeiro dígito pode letra, número ou símbolo, qualquer coisa)

/[A-Z][a-z][a-z][0-9]/  (Quatro dígitos)

/[A-Z][a-z]*[0-9]/

Mam7    (O terceiro dígito, *, pode ser qualquer dígito e este pode se repetir
Mamdmdmdmdmd4

/[0-9]{3}/      (De 0 a 9 sendo 3 dígitos)
000
123
...

/[0-9]{2,3}/

121-068-363-11

/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}-?[0-9]{2}/

121.069.343-56

/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}-?([0-9]{2})/

/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}-?([0-9]{2})?/

String
\w

Bar8

Dígito
\d

https://bar8.com.br/regex-expressoes-regulares-sap-abap-cdcb3271dd67


<?php
// Um variável qualquer
$texto = 'Eu sou lindo!';

// Expressão regular
$expressao = '/lindo/';

// Retorna true se a expressão existir no texto
$verifica = preg_match( $expressao,  $texto);

// Verifica se existe
if ( $verifica ) {
	echo "A expressão $expressao existe no texto.";
} else {
	echo "A expressão $expressao não existe no texto.";
}

<?php
// Um texto que tem uma data
$texto = 'Eu nasci em 20/04/1987. Fiz 27 anos em 2014.';

// Expressao regular
$expressao = '/[0-9]{2}/[0-9]{2}/[0-9]{4}/';

// Verifica se existe
if ( preg_match( $expressao, $texto, $encontrado ) ) {
	// Retorna: A data 20/04/1987 foi encontrada no texto.
	echo "A data $encontrado[0] foi encontrada no texto.";
}

<?php
// Poema de Cecília Meireles - Prelúdio
$preludio = 'Que tempo seria,
ó sangue, ó flor
em que se amaria
de amor!

Pérolas de espuma,
de espuma e sal.
Nunca mais nenhuma
igual.';

// Expressao regular
$expressao = "/s/";

// Altera o texto original
$preludio = preg_replace(
	$expressao, 
	'',
	$preludio
);

// Exibe o texto
echo $preludio;
```

https://www.youtube.com/watch?v=OUF7Vpp5EQo&list=PLhUp81I0jET71gMTWy50cpAYHrWnVnYlA&index=21

Expressões regulares são expressões que definem um padrão de busca (procurar, encontrar ou validar)

Funções que comecem com preg_

Funções iniciadas com ereg_ estão defasadas


