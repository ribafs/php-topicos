# Restringindo o acesso por usuários ou grupos

## Criação de usuários

Agora vem uma parte muito interessante. As vezes não temos como restringir apenas por IPs, seja porque o usuário que tem que acessar possa etar em qualquer lugar, ou ter IP dinâmico, etc. Para resolver esse caso, podemos utilizar o método de usuário e senha. Antes de mais nada você terá que ter o utilitário “htpasswd”, que serve para criar um arquivo de senhas criptografadas. Neste tutorial, criaremos 3 usuários exemplo:
```bash
$ mkdir /etc/apache2/auth
$ cd /etc/apache2/auth
sudo htpasswd -c acesso ribafs
New password:
Re-type new password:
```
O resultado que temos é o arquivo /etc/apache2/auth/acesso com o seguinte conteúdo:

cat /etc/apache2/auth/acesso - ribafs:$apr1$OqXU6lqV$3ztof5RUrfPYmJ0nsdeP5/

Agora que o arquivo de usuários e senhas está criado, vamos criar o .htaccess que irá verificar este arquivo. Veja o exemplo do .htaccess:
```bash
AuthName "Acesso Restrito"
AuthType Basic
AuthUserFile /etc/apache2/auth/acesso
require valid-user
```
Salve o .htaccess contendo as 4 linhas acima numa pasta em que deseja restringir o acesso para somente quem tem a senha e login. Quando a pasta for acessada via web será solicitado login e senha.

## Criação de Grupos

Mas se por acaso você tiver muitos usuários, e quer dividí-los em grupos, você pode muito bem fazer isso! 

- Primeiro teremos que criar o arquivo com os grupos. Use o seu editor preferido, e vamos criar por exemplo, o arquivo "/etc/apache2/auth/grupos":
```bash
admin:ribafs paulo
visitante: joao
empresa: hugo ribafs paulo
```
Salve o arquivo e então criamos três grupos. Para usar estes grupos, teremos que modificar o arquivo .htaccess anterior para ficar desta maneira:
```bash
AuthName "Acesso Restrito"
AuthType Basic
AuthUserFile /etc/apache2/auth/acesso
AuthGroupFile /etc/apache2/auth/grupos
require group admin

```
