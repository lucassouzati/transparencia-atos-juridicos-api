<h1 align="center">
    Transparência de Atos Jurídicos API
</h1>

## Sobre o projeto

Para fins de demonstração e aprendizado, resolvi reconstruir um sistema meu antigo, utilizando as melhores práticas e tecnologias atuais referente ao cenário backend PHP e Laravel. Nesse repositório, encontra-se uma API que servirá de apoio a outro sistema frontend. 

O objetivo do sistema é servir dados referente a transparência de atos jurídicos de um determinado órgão público. Entenda-se ato jurídico como qualquer documento público que está sujeito a legislações vigentes de transparência pública, como avisos de licitações, contratos públicos, etc.

Nos tópicos deste documento, exemplificarei as escolhas adotadas no desenvolvimento do sistema, a fim de demonstrar possíveis abordagens com Laravel.

Caso encontre algum erro, ou abordagem que poderia ser melhorada, não hesite em entrar em contato ou abrir uma PR. Eu também me considero um eterno aprendiz, e sei que ainda tenho muito a melhorar. Acredito que a força da comunidade que nos torna fortes. 

## Features

### CRUD

Deve ser possível adicionar, visualizat, editar e remover registros referente a Atos Jurídicos (Legal Acts).

Todo Ato Jurídico pertence a um Tipo (Type), através do relacionamento belongsTo na model LegalAct

```php
class LegalAct extends Model {

    public function type()
        {
            return $this->belongsTo(Type::class);
        }
}
```
Para ser possível manipular esses models, foi criado dois controllers com os métodos resources
```php
class LegalActController extends Controller
{
    public function index(FilterLegalActsRequest $request) { ... }
    public function store(LegalActRequest $request) { ... }
    public function show($id) { ... }
    public function update(LegalActUpdateRequest $request, $id) { ... }
    public function destroy($id) { ... }
}

```
```php
class TypeController extends Controller
{
    public function index() { ... }
    public function store(TypeRequest $request) { ... }
    public function show($id) { ... }
    public function update(TypeRequest $request, $id) { ... }
    public function destroy($id) { ... }
}

```
### Proteção de rotas
As rotas de listagem e visualização de Atos Jurídicos são públicas.
```php
Route::apiResource('legalacts', LegalActController::class)->only([
    'index', 'show'
]);
```
As rotas para manipulação de registros são protegidas via autenticação por token, e também por política de autorização.
```php
Route::middleware(['auth:sanctum', 'can:manage_records'])->group(function () {
    Route::apiResource('legalacts', LegalActController::class)->only([
        'store', 'update', 'destroy'
    ]);
});
```
### Documentação de API
Consumir uma API pode ser trabalhoso quando não se tem nenhuma referência de como ela funciona. Pensando nisso, utilizei um pacote terceiro chamado Laravel Request Doc, que se trata de uma alternativa ao Swagger e se baseia nos design patterns do Laravel para gerar uma documentação com todos endpoints e seus parâmetros. 
(img)
Além disso é possível fazer chamadas na própria documentação, verificando os retornos de cada endpoint. 
(img)

### Filtro de Atos Jurídicos
No end point index de atos jurídicos (api/legalacts) é possível passar parâmetros para filtrar os registros. Através do FormRequest FilterLegalActRequest, o pacote Laravel Request Doc documenta automaticamente os possívels parâmetros da pesquisa.
(img)

### Validação de políticas de autorização
Como regra de negócio, foi definido a existência de dois perfis de acesso, sendo o perfil "Administrador" e perfil "Cidadão". O perfil Cidadão se refere ao usuário que poderá se cadastrar no sistema para receber notificações de novos atos jurídicos publicados. Porém não atos jurídicos não publicados não devem aparecer para ele. Dessa forma, foi aplicado uma diretiva de acesso em um escopo global de consulta do model LegalAct.
```php
class LegalAct extends Model
{
    ...
    protected static function booted()
        {
                static::addGlobalScope('published', function (Builder $builder) {
                        if (!auth('sanctum')->check())
                        {
                            $builder->where('published', true);

                        }
                        else if (auth('sanctum')->user()->cannot('see_published_legalacts'))
                        {
                            $builder->where('published', true);
                        }
                });
        }
     ...
 } 
```
```php
class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ...
        Gate::define('see_published_legalacts', function (User $user) {
            return $user->isAdmin;
        });
        ...
    }

}
```
O atributo isAdmin foi implementado através de um acessor que verifica o perfil de cadastro do Usuário.
```php
class User extends Authenticatable
{
    ...
    protected function isAdmin() : Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['profile'] == "admin"
        );
    }
    ...
}
```
## Boas práticas em Laravel

### Form Requests

### Custom Validation Rules

### Testes automatizados

## Melhorias futuras

## Como rodar esse projeto

Em construção ... 🔨

