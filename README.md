# zServices
[![Laravel 5](https://img.shields.io/badge/Laravel-5-green.svg)](https://laravel.com)
[![Latest Stable Version](https://poser.pugx.org/zservices/query/v/stable)](https://packagist.org/packages/zservices/query) [![Total Downloads](https://poser.pugx.org/zservices/query/downloads)](https://packagist.org/packages/zservices/query) [![Latest Unstable Version](https://poser.pugx.org/zservices/query/v/unstable)](https://packagist.org/packages/zservices/query) [![License](https://poser.pugx.org/zservices/query/license)](https://packagist.org/packages/zservices/query)
[![Build Status](https://api.travis-ci.org/juniorb2ss/zServices.svg?branch=master)](https://travis-ci.org/juniorb2ss/zServices)
[![Dependency Status](https://gemnasium.com/badges/github.com/juniorb2ss/zServices.svg)](https://gemnasium.com/github.com/juniorb2ss/zServices)
[![Issues Status](https://img.shields.io/github/issues/juniorb2ss/zServices.svg)](https://github.com/juniorb2ss/zServices/issues)
[![Stars Status](https://img.shields.io/github/stars/juniorb2ss/zServices.svg)](https://github.com/juniorb2ss/zServices/stargazers)
[![Code Climate](https://codeclimate.com/github/juniorb2ss/zServices/badges/gpa.svg)](https://codeclimate.com/github/juniorb2ss/zServices)
[![Issue Count](https://codeclimate.com/github/juniorb2ss/zServices/badges/issue_count.svg)](https://codeclimate.com/github/juniorb2ss/zServices)
[![Test Coverage](https://codeclimate.com/github/juniorb2ss/zServices/badges/coverage.svg)](https://codeclimate.com/github/juniorb2ss/zServices/coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/juniorb2ss/zServices/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/juniorb2ss/zServices/?branch=master)

Pacote para buscar informações nos serviços federais e estaduais do Brasil

É feito uma requisição no serviço, retornando `cookie` e `captcha` do serviço. Após usuário informar
o captcha é feito outra requisição, retornando informações do CNPJ.

Este pacote deverá ser usado com responsabilidade, o autor e contribuidores não devem responder pelas implementações/ações feita com este pacote.

### Atenção

Este pacote foi desenvolvido com o intuito de facilidade consultas através de ERP ou serviços que necessitam de consistência de dados. Não foi criado com o intuito de ser utilizado como `bot`

Toda implementação será de sua responsabilidade.

### Version Stable
1.0.7

### Instalação

```sh
$ composer require zservices/query 1.*
```
### Laravel 5
Configure os providers e aliases em `config/app.php`
```php
'providers' => [
    // ....
      zServices\Laravel\ServicesProvider::class,
    //...
];

'aliases' => [
    //...
    'Sintegra' => zServices\Laravel\SintegraFacade::class,
    'ReceitaFederal' => zServices\Laravel\ReceitaFederalFacade::class,
    //...
];
```
```php
use ReceitaFederal;
$service = ReceitaFederal::service()->request();

return view('receitafederal.query.example',[
    'cookie' => $service->cookie(),
    'image'  => $service->captcha()
]);
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
Imagem de exemplo com as informações de retorno do serviço.
#### Receita Federal
![Retorno](https://camo.githubusercontent.com/50a04fb56500e16b07deb7afceeccb16bfc3809a/687474703a2f2f7333322e706f7374696d672e6f72672f7236306775726467352f53637265656e73686f745f66726f6d5f323031365f30345f32385f31385f34335f31332e706e67)
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

