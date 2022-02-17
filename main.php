<?php
/*
* Главный класс фермы
*/
class Farm
{
    /*
    *@array Массив животных объектов
    */
    public $animals = [];

    /*
    *@array Массив продуктов по типам животных
    */
    public $products = [];

    /*
    * Создаем животных из массива
    */
    public function createAnimals(array $animals)
    {
        foreach ($animals as $type => $value){
            $animalType = $type;
            $animalCount = $value;
            for ($i = 1; $i <= $animalCount; $i++){
                $this->animals[$animalType][] = new $animalType();
            }
        }
    }

    /*
    * Добавляем животных в массив
    */
    public function addAnimals(array $animals)
    {
        foreach ($animals as $type => $value){
            $animalType = $type;
            $animalCount = $value;
            for ($i = 1; $i <= $animalCount; $i++){
                $this->animals[$animalType][] = new $animalType();
            }
        }
    }
    /*
    * Собираем продукты за неделю
    */
    public function collectionProducts()
    {
        foreach($this->animals as $key => $value){
            $product = 0;
            if(is_array($value) || is_object($value)){
                foreach ($value as $k => $animal){
                    $product += $animal->getProducts();
                }
            }
            $this->products[$key] = $product * 7;
        }
    }

    /*
    * Вывод в консоль
    */
    public function toPrintProduct()
    {
        echo 'Собрано молока за неделю '. $this->products["Cow"] . ' л.'. PHP_EOL;
        echo 'Собрано яиц за неделю '. $this->products["Chicken"] . ' шт.'. PHP_EOL;
    }

    public function toPrintAnimal(){
        echo 'Всего коров ' . count($this->animals["Cow"]) . ' шт.'. PHP_EOL;
        echo 'Всего кур ' . count($this->animals["Chicken"]) . ' шт.'. PHP_EOL;
    }
}

/*
* Класс хлев
*
*/
class Barn extends Farm
{
}

/*
* Класс животного
*
*/
abstract class Animal
{
    /**
     *@var string Идентификатор животному
     */
    public $uid;

    /*
    * Присваиваем уникальный идентификатор животному
    */
    public function __construct()
    {
        $this->uid = hash('ripemd160', random_int(0,100));
    }

    /*
    *Возвращает случайное количество продуктов
    *@return int
    */
    abstract public function getProducts();

}

/**
 * Класс коров
 */
class Cow extends Animal
{
    /**
     *@var int Минимальное кличество генерируемого продукта
     */
    const MIN_PRODUCT_COUNT = 8;

    /**
     *@var int Максимальное количество генерируемого продукта
     */
    const MAX_PRODUCT_COUNT = 12;

    /**
     *Получаем случайное количество продукта min <= N <= max
     *@return int
     */
    public function getProducts()
    {
        return random_int(self::MIN_PRODUCT_COUNT, self::MAX_PRODUCT_COUNT);
    }

}

/**
 * Класс куриц
 */
class Chicken extends Animal
{
    /**
     *@var int Минимальное кличество генерируемого продукта
     */
    const MIN_PRODUCT_COUNT = 0;

    /**
     *@var int Максимальное количество генерируемого продукта
     */
    const MAX_PRODUCT_COUNT = 1;

    /**
     *Получаем случайное количество продукта min <= N <= max
     *@return int
     */
    public function getProducts()
    {
        return random_int(self::MIN_PRODUCT_COUNT, self::MAX_PRODUCT_COUNT);
    }

}


$factory = new Barn();
$factory->createAnimals([
    'Cow' => 10,
    'Chicken' => 20,
]);
$factory->toPrintAnimal();
$factory->collectionProducts();
$factory->toPrintProduct();

$factory->addAnimals([
    'Cow' => 1,
    'Chicken' => 5,
]);
echo 'прикупили животных на рынке "Рога и копыта"' . PHP_EOL;
$factory->toPrintAnimal();
$factory->collectionProducts();
$factory->toPrintProduct();
