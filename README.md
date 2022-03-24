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
