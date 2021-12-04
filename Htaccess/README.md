# Alguns Recursos do .htaccess

O .htaccess é um verdadeiro canivete suiço dos programadores. É mais fácil descobrir o que ele não faz do que o que ele faz. A lista é grande:

- redirecionamento de páginas
- conceder acesso a diretórios
- negar acesso a diretórios
- Bloquear IP
- Acesso a usuários e grupos
- Conceder acesso a IP ou rede
- E bem mais. Confira.

Crétidos

A maior parte deste material é fruto de pesquisa via internet e colhendo trechos de código de alguns aplicativos.

O .htaccess é, basicamente, um arquivo de configuração utilizado em servidores web, como oApache, por exemplo (seu nome vem de “hypertext access“). O arquivo funciona a nível de diretórios e permite que administradores gerenciem e manipulem configurações e acessos de forma descentralizada.

Inserido em modo oculto (com a devida adição do “.” à frente do nome) nos diretórios (como por exemplo a pasta raiz “public_html” de cada website), o .htaccess força o servidor a interpretar suas instruções prioritariamente, desconsiderando, portanto, nestes casos, quaisquer configurações globais.

As configurações presentes no arquivo, vale lembrar, são aplicadas ao diretório no qual ele se encontra e também a todos os seus subdiretórios, caso existam. Vale também lembrar que a presença de um outro .htaccess em um subdiretório anula a ação do que se encontra um nível acima. Ou seja, o .htaccess do subdiretório passa a valer para o mesmo e também para todas as suas subpastas. E assim por diante. É sempre bom ficarmos atentos a estes detalhes.

Servidores

Usando arquivos .htaccess, podemos, por exemplo, proteger diretórios com senhas, prevenir hotlinks (utilização de imagens hospedadas no seu servidor em outros locais, indevidamente e gastando a sua banda), configurar URLs amigáveis, etc. Trata-se de um arquivo bastante útil, e neste artigo vamos dar a você uma série de exemplos de utilização. 20 exemplos, para ser mais preciso.
Criando um arquivo .htaccess

Criar um arquivo .htaccess, aliás, é bastante simples. Tudo o que você precisa é de um editor de texto qualquer. Pode ser o PSPad, o Notepad++ ou até mesmo o Bloco de Notas padrão do Windows. Crie um novo arquivo e então salve-o como “.htaccess” (sem aspas, obviamente, e com o ponto antes do nome).

## Verificar versão do seu apache para pesquisar adequadamente

Apache 2.2 tem sintaxe bem diferente do Apache 2.4.
Sempre antes de tirar alguma dúvida verifique a versão do seu apache:

apache2 -v (num linux)

## Conceder acesso à listagem de diretório
```php
Options +Indexes
DirectoryIndex index.html index.php /index.php
```
## Negar acesso à listagem de diretório
```php
Options -Indexes
DirectoryIndex index.html index.php /index.php
```
## Bloquear alguns exploits comuns
```php
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ ///.*\ HTTP/ [NC,OR]
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\?\=?(http|ftp|ssl|https):/.*\ HTTP/ [NC,OR]
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\?\?.*\ HTTP/ [NC,OR]
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\.(asp|ini|dll).*\ HTTP/ [NC,OR]
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\.(htpasswd|htaccess|aahtpasswd).*\ HTTP/ [NC]
RewriteRule .? - [F,NS,L]
```
## Limitar o acesso apenas a uma determinada faixa de IPs/Rede:
```php
order deny,allow
deny from all
allow from 192.168.0.1/24
```
## Banir certo IP
```php
order allow,deny
deny from 74.184.25.218
allow from all
```
## Para que o site possa ser acessado também com ribafs.org e não somente com www.ribafs.org
Adicionar ao .htaccess do raiz do site:

```php
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www\.ribafs\.org$ [NC]
RewriteRule ^(.*)$ http://ribafs.org/$1 [R=301,L]
```
Crédito: https://julianoaugusto.com/noticias/33-programe-seu-site-para-nao-usar-www

## Redirecionando URLs com www para URLs sem www:
```php
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www.(.*) [NC]
RewriteRule ^(.*) http://%1/$1 [R=301,L]
```
## Removendo extensões de arquivos das URLs

Você pode também remover as extensões dos arquivos das URLs com um arquivo .htaccess. Por exemplo, ao invés de seu visitante visualizar algo como contato.php na barra de endereços do navegador, ele pode visualizar simplesmente “contato”.

Use o código abaixo em um arquivo .htaccess:
```php
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}\.html -f
RewriteRule ^(.*)$ $1.html
```
No exemplo acima, a extensão .html será removida/escondida. Você pode também usar o mesmo snippet para esconder outras extensões de arquivos, como por exemplo .php . Basta realizar as devidas substituições.

## Forçando redirecionamento de http para https (SSL)
```php
RewriteEngine On
RewriteCond %{HTTPS} !on
RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI}
```
## Exemplos de redirecionamento para o index.php
```php
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l

RewriteRule ^(.+)$ index.php?path=$1 [QSA,L]
-------
Options -MultiViews -Indexes

RewriteEngine On

#RewriteCond %{HTTPS} off
#RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule (.*) index.php?uri=$1 [L,QSA]

----------
<IfModule mod_rewrite.c>
    Options -Multiviews
    RewriteEngine On
    RewriteBase /mvcframework/public
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule  ^(.+)$ index.php?url=$1 [QSA,L]
</IfModule>
```
## Exemplos de redirecionamento para public
```php
Options -Indexes -MultiViews

RewriteEngine On
RewriteRule (.*) /public/$1 [L,QSA]

-----------
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule ^$ public/ [L]
    RewriteRule (.*) public/$1 [L]
</IfModule>
-----------
Options -Indexes -MultiViews

RewriteEngine On

RewriteRule ^$ public/ [L]
RewriteRule ^(.*)$ public/$1 [L,QSA]
----------
# Disable server signature
ServerSignature Off

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule  ^$ public/    [L]
    RewriteRule  (.*) public/$1 [L]
</IfModule>
-------
```

## Acesso restrito por usuário ou grupo

[senhas.md](senhas.md)

