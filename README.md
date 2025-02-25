# Lucky Game
## Правила игры:
Если случайное число четное выводить пользователь выиграл. В противном случае пользователь проиграл.


## Расчет приза
✔️ Если случайное число более 900, сумма выигрыша должна составлять 70% от случайного числа.

✔️ Если случайное число более 600, сумма выигрыша должна составлять 50% от случайного числа.

✔️ Если случайное число более 300, сумма выигрыша должна составлять 30% от случайного числа.

✔️ Если случайное число меньше или равно 300, сумма выигрыша должна составлять 10% от случайного числа.

## Настройка и запуск

Установка зависимостей: 
```bash 
composer install
```

Создание конфигурации
```bash
 cp .env.example .env
 ```

Генерация уникального ключа
```bash
php artisan key:generate
```
Накатить миграции
```bash
 php artisan migrate
 ```

Запуск приложения
```bash
 php artisan serve
 ```

## Запуск unit-тестов.
```bash
 php artisan test
 ```



## Пояснения по коду

Вся логика игры сосредоточена в сервисах Game.
- GamService отвечает за логику игры. В данном случае, она максимально простая. 
Генерирует случайное число, при помощи стратегии RandomNumberGenerator которую в дальнейшем можно будет объявить как интерфейс и передавать в GameService как инъекцию.
- PrizeCalculator - считает сумму приза исходя из того, какое число выпало.  
- RandomNumberGenerator - реализация предполагаемой стратегии. Если нужно будет добавлять новую стратегию генерации случайных чисел
потребуется рефакторинг. Определить общий интерфейс, в GameService принимать данный интерфейс. А передавать конкретную стратегию.

> Так как задача подразумевает соблюдение принципов KISS, YAGNI, то это не было сделано сразу. Чтобы не усложнять код избыточными стратегиями.

> С другой стороны так как реализация механики игры была основана на TDD были соблюдены некоторые принципы SOLID.


История игр является дополнительной опцией. Которой в принципе могло и не быть. Поэтому она никак не связана напрямую 
с логикой игры и поэтому не была включена в реализацию метода play. 

Тоже касается и приза. Приз может быть, а может не быть. Поэтому игра не должна ничего знать о призе, или пользователе. Механика игры может быть
одна, а вот приз в одном случае может подразумеваться в другом нет. Поэтому сервис расчета призов не знает о существовании сервиса игры
и наоборот, сервис игр не знает, что есть сервис, который может рассчитать приз.  

Вместо этого мой экшен в контроллере является координатором. Но на данном этапе это оправданно да и читаемость кода более понятна.

```php
public function play()
{
    $userId = Auth::user()->id;

    $gameResult = $this->gameService->play();
    if($gameResult->getStatus() === 'Win'){
        $amountPrize = $this->prizeCalculator->calculate($gameResult);
    }else{
        $amountPrize = 0.00;
    }

    $data = [
        'status' => $gameResult->getStatus(),
        'number' => $gameResult->getNumber(),
        'prize' => $amountPrize,
    ];
    event(new GamePlayed($userId, $gameResult, $amountPrize));

    return response()->json($data);
}
```

С одной стороны, можно было бы всю эту логику запихнуть в метод play у GameService и таким образом сделать его фасадным.
Но это сложнее поддается тестированию. И так как данный код выполняется единожды в одном месте, на данный момент не вижу 
в этом смысла. Но в то же время, если механика игры будет дублирована и например нужно будет её реализовать из консоли.
Имеет смысл сделать еще один сервис, уровнем выше, который будет фасадом.
Еще один кейс при котором это имело бы смысл, если бы, логика игры зависела от типа пользователя. Например "вип", "лудоман"
И в метод play имеет смысл передавать еще и User. В это случае можно было бы реализовать некий декоратор. 
Таким образом не изменяя старый, код можно реализовать дополнительное поведение и например для "вип" расчитывать приз 
по другому тарифу, а "лудоманам" ограничивать доступ к азартным играм, как того требует законодательство Украины. 
```php
class UserAwareGameServiceDecorator implements GameServiceInterface
{
    private GameServiceInterface $innerService;
    private int $userId;

    public function __construct(GameServiceInterface $innerService, int $userId)
    {
        $this->innerService = $innerService;
        $this->userId = $userId;
    }

    public function play(): GameResult
    {
        $result = $this->innerService->play();
        
        
        $user = User::find($this->userId);
        if ($user && $user->id % 2 === 0) {
            $number = $result->getNumber();
            $status = $number > 400 ? 'Win' : 'Lose'; //пример особого условия
            return new GameResult($number, $status);
        }

        return $result;
    }
}
```
В целом тоже самое можно было бы сделать и для того, чтобы сохранить результат игры сразу в историю, но я решил это будет
избыточным и ограничился просто вызовом события:  
```php
event(new GamePlayed($userId, $gameResult, $amountPrize));
```

## Хранение данных

Для хранения используется SQLite. История игр хранит только статус (текстовый) сумму выигрыша, выпавшее число.   
Не ясно следует историю игры подвязывать к конкретной ссылке или нет, ТЗ умалчивает. Сделал на свое усмотрение.
Уникальная ссылка формируется из генерируемого уникального токена. С точки зрения моего понимания это лишь способ авторизации.

> Статус оставил в текстовом виде, просто как пример. В реальности скорее всего использовал бы числовую константу. 1 -выигрыш, 0 проигрыш. 


Вероятно масштабируя это приложение я бы добавил отдельный раздел по менеджменту этих ссылок. То есть авторизовавшись
по ссылке можно на ряду с историей зайти в раздел "Мои ссылки" и там произвести менеджмент (удалить, деактивировать, обновить).
В этом случае можно было бы хранить информацию о количестве входов по этой ссылке, количество сыгранных игр по ней. 
