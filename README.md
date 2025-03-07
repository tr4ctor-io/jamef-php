<p align="center"><img src ="https://marketing-jamef-prd.s3.us-east-2.amazonaws.com/site/assets/logotipos/nova-logo-jamef.svg" /></p>

##
# Jamef - SDK PHP

[![Licença do Software][badge-license]](LICENSE)
[![Última Versão no Packagist][badge-version]][link-packagist]
[![Status de Build][badge-travis]][link-travis]
[![Status de Coverage][badge-scrutinizer]][link-scrutinizer]
[![Nota de Qualidade][badge-code-quality]][link-code-quality]
[![Downloads no Total][badge-downloads]][link-downloads]

# Descrição
Este pacote consiste em um SDK em PHP para a [API de Recorrência][link-introducao-api] da [Jamef][link-jamef].

# Requisitos
- PHP versão **7.2.x** ou superior.
- cURL habilitado para o PHP.
- Certificado SSL.
- Conta ativa na [Jamef](https://developers.jamef.com.br/ "Jamef").

# Instalação

Via Composer

```bash
composer require tr4ctor-io/jamef-php
```

# Métodos de Autenticação

## Variável de ambiente

> Esse método de autenticação utiliza-se de inserção de variáveis de ambiente.

```php

require __DIR__.'/vendor/autoload.php';

// Coloca o usuário (JAMEF_API_USERNAME) na variável de ambiente do PHP.
putenv('JAMEF_API_USERNAME=seu@email.com.br');

// Coloca o usuário (JAMEF_API_PASSWORD) na variável de ambiente do PHP.
putenv('JAMEF_API_PASSWORD=suasenha');

// Coloca a chave da Jamef (JAMEF_API_URI) na variável de ambiente do PHP.
putenv('JAMEF_API_URI=https://api-qa.jamef.com.br/');

// Instancia o serviço de Auth (Login)
$auth = new \Tr4ctor\Jamef\Auth;

// Você deve armazenar o access_token em cache por 3600 segundos conforme exemplo abaixo
$accessToken = null;
// Definir o tempo de expiração do cache (em segundos)
$cache_time = 3600;
// Verificar se há cache disponível
$cache_file = 'cache/.access_token';
if (file_exists($cache_file) && time() - $cache_time < filemtime($cache_file)) {
    // Ler os dados do cache
    $accessToken = file_get_contents($cache_file);
} else {
    $login = $auth->login();
    if (!empty($login->dado)) {
        $token = current($login->dado);
        if (!empty($token->accessToken)) {
            // Salvar os dados no cache
            file_put_contents($cache_file, $token->accessToken);
            $accessToken = $token->accessToken;
        }
    }
}

echo "Access Token de acesso para utilização nas demais consultas<br/>";
echo $accessToken;
```

## Argumento de instância

> Esse método de autenticação utiliza-se de inserção de um *array* como argumento na primeira instância de uma classe *filha* de Resource, **sendo ignorada uma nova tentativa de inserir o argumento em uma outra instância.**

```php

require __DIR__.'/vendor/autoload.php';

// Declara em um array os valores de JAMEF_API_TOKEN e JAMEF_API_URI, aqui estamos passando o accessToken necessário para autenticação.
$arguments = array(
    'JAMEF_API_TOKEN' => $accessToken,
    'JAMEF_API_URI' => 'https://api-qa.jamef.com.br/'
);

// Instancia o serviço de Calculo de Frete (Cotação) com o array contendo JAMEF_API_TOKEN e JAMEF_API_URI
$calculoFrete = new \Tr4ctor\Jamef\CalculoFrete($arguments);

```

## Exemplo de implementação

> Exemplo de código após autenticação (uma das duas formas existentes descritas acima), seguindo a sequência de instanciação de CalculoFrete.

```php

// Recupera nova cotação de frete:
$id = null;
$cotacao = $calculoFrete->cotacao(
    [
        "tipoTransporte" => "1",
        "documentoDevedor" => "12345678000195",
        "cepOrigem" => "00000000",
        "cepDestino" => "000000000",
        "quantidadeVolume" => 10,
        "pesoMercadoria" => 50,
        "valorNotaFiscal" => 1500,
        "metragemCubica" => 0.42,
        "documentoRemetente" => "23456789000195",
        "documentoDestino" => "34567890000123",
        "filialOrigem" => "01",
        "dataColeta" => "25/12/2024"
    ]
);

echo print_r($cotacao, true);
```

Para mais detalhes sobre quais serviços existem, quais campos enviar e demais informações,
[verifique nossa página interativa de uso da API][link-api].

**Response:**
Caso precise de mais detalhes sobre a resposta de cada request, utilize o método `getLastResponse`. Se nenhum request foi efetuado anteriormente, este método retornará `NULL`.

```php
// Retorna os dados da última resposta recebida dos servidores da Jamef
$lastResponse = $calculoFrete->getLastResponse();

// Retorna o corpo da requisição
$body = (string) $calculoFrete->getLastResponse()->getBody();
// Retorna o HTTP Status Code
$lastResponse->getStatusCode();
// Retorna o todos os headers
$lastResponse->getHeaders();
// Retorna um único header
$lastResponse->getHeader('Header-Name');
```

## Dúvidas
Caso necessite de informações sobre a plataforma ou API, por favor acesse o [Ajuda Jamef](https://developers.jamef.com.br/ajuda).

## Contribuindo
Por favor, leia o arquivo [CONTRIBUTING.md](CONTRIBUTING.md).
Caso tenha alguma sugestão ou bug para reportar, por favor nos comunique através das [issues](./issues).

## Segurança
Se você descobrir qualquer questão relacionada a segurança, por favor, envie um e-mail para seguranca@tr4ctor.io ao invés de utilizar os issues.

## Changelog
Todas as informações sobre cada release podem ser consultadas em [CHANGELOG.md](CHANGELOG.md).

## Créditos
- [Jamef][link-author]
- [Todos os Contribuidores][link-contributors]

## Licença
GNU GPLv3. Por favor, veja o [Arquivo de Licença](license.txt) para mais informações.

[badge-version]: https://img.shields.io/packagist/v/tr4ctor-io/jamef-php.svg
[badge-license]: https://img.shields.io/badge/license-GPLv3-blue.svg
[badge-travis]: https://img.shields.io/travis/tr4ctor-io/jamef-php/master.svg
[badge-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/tr4ctor-io/jamef-php.svg
[badge-code-quality]: https://img.shields.io/scrutinizer/g/tr4ctor-io/jamef-php.svg
[badge-downloads]: https://img.shields.io/packagist/dt/tr4ctor-io/jamef-php.svg

[link-packagist]: https://packagist.org/packages/tr4ctor-io/jamef-php
[link-travis]: https://travis-ci.org/tr4ctor-io/jamef-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/tr4ctor-io/jamef-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/tr4ctor-io/jamef-php
[link-downloads]: https://packagist.org/packages/tr4ctor-io/jamef-php
[link-author]: https://github.com/tr4ctor-io
[link-contributors]: ../../contributors
[link-jamef]: https://www.jamef.com.br
[link-introducao-api]: https://developers.jamef.com.br/documentacao/4db4f35c-47b5-4dd0-8a7f-2273709a1043/introducao-api
[link-api]: https://developers.jamef.com.br/
