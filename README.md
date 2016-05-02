# zServices

Pacote para buscar informações nos serviços federais e estaduais do Brasil

É feito uma requisição no serviço, retornando `cookie` e `captcha` do serviço. Após usuário informar
o captcha é feito outra requisição, retornando informações do CNPJ.

Este pacote deverá ser usado com responsabilidade, o autor e contribuidores não devem responder pelas implementações/ações feita com este pacote.

### Atenção

Este pacote foi desenvolvido com o intuito de facilidade consultas através de ERP ou serviços que necessitam de consistência de dados. Não foi criado com o intuito de ser utilizado como `bot`

Toda implementação será de sua responsabilidade.

### Version Stable
1.0.0

### Instalação

```sh
$ composer require zservices/query 1.*
```
### Exemplos
#### Receita Federal

```php
use zServices\ReceitaFederal\Search as ReceitaFederal;
$search = (new ReceitaFederal)->service()->request(); // initialize

$captchaBase64Image = $search->captcha(); // captura base64_decode da imagem
$cookieRequest = $search->cookie(); // captura o cookie do request iniciado

```

Dados após o form
```php
// Requisitar dados
use zServices\ReceitaFederal\Search as ReceitaFederal;

$search = (new ReceitaFederal)->service();
$crawler = $search->data($cnpj, $cookie, $captcha, []);
$arrayData = $crawler->scraping(); // array com as informações da entidade
```
Para consultar receita federal basta pegar o cookie e a imagem do captcha, após resolver o captcha é preciso
retornar o cookie e a string resolvida para o serviço, ele deverá retornar um array associado com as informações
do CNPJ informado.
#### Sintegra SP

Dados para form

```php
use zServices\Sintegra\Search as Sintegra;
$search = (new Sintegra)->service('SP')->request(); // initialize

$captchaBase64Image = $search->captcha(); // captura base64_decode da imagem
$cookieRequest = $search->cookie(); // captura o cookie do request iniciado
$params = $search->params(); // captura o valor dos inputs
$paramBot = $params['parambot']; // captura parambot

```

Dados após o form
```php
// Requisitar dados
use zServices\Sintegra\Search as Sintegra;

$search = (new Sintegra)->service('SP');
$crawler = $search->data($cnpj, $cookie, $captcha, $paramBot);
$arrayData = $crawler->scraping(); // array com as informações da entidade

```
O portal do sintega de SP além do captcha possui um valor no formulário com nome de `paramBot`. Este valor é único por requisição, não por cookie. Então para que a requisição funcione corretamente é preciso pegar e devolver ele nas requisições posteriores.

O método `$search->params()` devolve um array com os inputs que são necessários devolver, que no caso do sintegra de sp é apenas `paramBot`. Este valor deverá ser inserido em seu formulário e devolvido como array associado na requisição das informações da entidade.

### Retornos
#### Receita Federal
Em breve
#### Sintegra SP
![Retorno](https://uploaddeimagens.com.br/images/000/612/350/original/Screenshot_from_2016-05-01_16-51-52.png?1462132324)


### Desenvolvimento
Deseja contribuir com desenvolvimento? pull request :)

### To-do

License
----
MIT

**Free Software, Hell Yeah!**

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

