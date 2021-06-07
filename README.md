<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Medical Care (API REST)

Este projeto foi desenvolvido com [Laravel Framework](https://laravel.com) versão 8.34.0 e [MySQL Server](https://www.mysql.com/) versão 8.0.

## Development server

Após clonar o projeto do [API Medical Care](https://github.com/flailton/api-medical-care) do GitHub, na pasta do projeto, execute os comandos `composer install`, para instalar as dependências do projeto. 

Após finalizado, deve ser criado um Schema com as seguintes características no Banco de Dados:
- Nome: `medical_care` (DB_DATABASE)
- Username = `root` (DB_USERNAME)
- Password = `root` (DB_PASSWORD)
*Caso queira alterar essas informações, será necessário ajustar o arquivo .env (na raíz do projeto).

Após realizada a configuração do banco de dados, deverão ser executados os comandos `php artisan migrate` e `php artisan db:seed`, nessa ordem.

Em seguida execute o comando `php artisan serve` para iniciar o ambiente de desenvolvimento. 

O ambiente ficará acessível através do endereço `http://localhost:8000/`, ou através de uma porta diferente (informada no terminal), caso esta já esteja ocupada.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
