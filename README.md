## Endpoints de Usuarios

| Method | Endpoint       | Descripção                 |
| ------ | -------------- | -------------------------- |
| Post   | /api/user      | Cria um novo usuario       |
| Get    | /api/user      | Retornas todos os usuarios |
| Get    | /api/user/{id} | Retorna usuario pelo id    |
| Patch  | /api/user/{id} | Atualiza dados do usuario  |
| Delete | /api/user/{id} | Deleta um usuario pelo id  |

1 Endpoint **/api/user** precisa enviar json com estas propriedades

```
{
	"name":"danieldo", obrigatorio
	"email":"a3232dfsadasda8sf@gmail.com", obrigatorio
	"city":"asdasdasd",
	"phone":"49998218294",
	"birth_date": "22/08/2000",
	"companies":[{"company_id":4}]
}
```

**Obs:** o endpoint possui validações de data e email, então precisa ser enviado no formato apresenato encima;


## Endpoints de empresas

| Method | Endpoint          | Descripção                 | 
| ------ | ----------------- | -------------------------- |
| Post   | /api/company      | Cria uma empresa nova      |
| Get    | /api/companies    | Retornas todas as empresas |
| Get    | /api/company/{id} | Retorna empresa pelo id    |
| Patch  | /api/company/{id} | Atualiza dados da empresa  |
| Delete | /api/company/{id} | Deleta uma empresa         |

1 Endpoint **/api/company** precisa enviar json com estas propriedades

```
{
	"name":"alfana", obrigatorio
	"cnpj":"14.731.030/4381-01", obrigatorio
	"street":"ruas asdas",
	"city":"cidade ",
	"state":"state",
	"users":[{"user_id":1}]
}
```

**Obs:** o endpoint possui validações de cnpj, então precisa ser enviado no formato apresenato encima;

## Instalação

1 Clone o repositorio
~~~
git clone https://github.com/VictorD19/back-end-php-teste.git
~~~
2 Entre na pasta criada
~~~
cd back-end-php-teste
~~~
3 para que o projeto funcione Digite o seguiente 
~~~
composer install
~~~
4 agora crie um arquivo **.env** utilizando o arquivo **.env.exemplo** como exemplo
dentro no arquivo precisa configura o banco de dados 
~~~
DB_CONNECTION=mysql -> seu banco, utilizei postgres (pgsql)
DB_HOST=127.0.0.1 -> 
DB_PORT=3306 -> port do banco
DB_DATABASE= ' '  -> nome de seu banco
DB_USERNAME= ' '  -> usuario de seu banco
DB_PASSWORD= ' '  -> senhade seu banco
~~~
5 inicie as migrations (tabelas)
~~~
php artisan migrate
~~~
se ocurrer tudo certo teras esta resposta
~~~
Migrating: 2019_12_14_000001_create_personal_access_tokens_table
Migrated:  2019_12_14_000001_create_personal_access_tokens_table (71.25ms)
Migrating: 2022_03_19_174451_user
Migrated:  2022_03_19_174451_user (24.47ms)
Migrating: 2022_03_19_174600_company
Migrated:  2022_03_19_174600_company (21.44ms)
Migrating: 2022_03_19_174620_address
Migrated:  2022_03_19_174620_address (28.35ms)
Migrating: 2022_03_19_175314_user_company
Migrated:  2022_03_19_175314_user_company (21.34ms)
~~~

6 Agora é so iniciar o servidor 
~~~
php artisan serve
~~~ 