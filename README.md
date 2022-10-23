# BasicChat
  Este sistema foi criado exclusivamente para **fins demonstrativos**, o mesmo deixa muito a desejar para um sistema de chat.<br/>
  O objetivo desse sistema é exemplificar o uso de '**websockets**' com laravel, mostrar o uso de canais públicos e privados.

## Funcionalidades

- [x] Cadastro de usuário
- [x] Login de usuário
- [x] Envio de mensagens privadas
- [x] Envio de mensagens públicas, para grupo!
- [x] Verficação de usuário online
- [x] Verficação de mensagens lidas, canais privados

## Tecnologias Utilizadas
~~~Front-End
* HTML 5
* CSS 3
* BOOTSTRAP 5.1
* BLADE
* JQUERY - (Ajax)
~~~

~~~Back-End
* PHP 7.4.9
* LARAVEL 8
~~~

~~~Banco
* MySql 5.7
~~~
## Inicialização
1. Certifique-se de ter instalado na sua máquina o php 7.3 - 8.1
2. Faça o ˋgit cloneˋ
3. Duplique o arquivo ˋ.env.exampleˋ e retire o ˋ.env`
4. Configure as variaveis de conexao com o banco de dados
5. Execute ˋcomposer installˋ
6. Execute ˋphp artisan key:generateˋ
7. Execute ˋphp artisan migrateˋ
8. Execute ˋphp artisan serve`  ou  ˋphp artisan serve --host='0.0.0.0'`
9. Abra um nova guia no seu cmd
10. Execute ˋphp artisan websockets:serve`


