
#  [ссылка: Инструкция по Google cloud](https://docs.google.com/document/d/144eI2NVO05XxZ2xTOvmInJeOlf5XHTP8Zyuvw5gIDD8/edit?usp=sharing)

#   AWS 
###Настройка Ubuntu18.04

    //Установка Docker : 
    https://docs.docker.com/install/linux/docker-ce/ubuntu/
    //Установка Docker-Compose:
     https://docs.docker.com/compose/install/

     // Клонируем проект:
     https://github.com/splaa/paradam.splx.site.git paradam.me
     // Переходим в папку проекта
     cd paradam.me



# Скачуем docker image 

    docker pull yiisoftware/yii-php:7.4-apache

// Запускаем:  в случае ошибок — они будут указаны

        docker-compose up 
        docker-compose down

//  или запуск в фоне

        docker-compose up -d 

// Посмотреть список запущенных контейнеров можно так

        docker ps  								

// После запуска контейнера можно выполнить команду, 
чтобы обновить `composer`

    docker ps 
    docker exec -it d7a2456b68cc bash`  		// если нужно войти в контейнер по хешу смотрим docker ps. Вход происходит под root
    docker exec -it docker_app_1 bash` 		// Подключаемся к контейнеру по имени смотрим docker ps

    cd /app && composer install`
    cd /app && composer update`

    //Инициализируем и заполняем config
    php init  
   
                             
    //	Выполняем команду миграции БД php 
    php yii migrate
    
    // Telegram
    php yii telegram/run                              

    //испавленно добавленно в шаблон эту строчку можна удалить
    cp config/common-docker.php.example config/common-local.php

    /app/yii migrate


// И выходим 
`exit`

//Тормозим сервис
`docker-compose down`

// Запускаем его заново 
`docker-compose up -d`
======



`http://examle.com:8000` - site

`http://examle.com:8888` - adminer

`db host=mysql`
`port = 3336`
`login = splaa`
`pass = splaa1977`


#Тесты
1. переименовать /paradam.me.loc/tests/acceptance.suite.yml.example
в paradam.me.loc/tests/acceptance.suite.yml

2. прописать url в секции  - PhpBrowser:
    
3. Генерируем тест домашней странички 
настройка alise  http://www.fkn.ktu10.com/?q=node/9698
 настроим alias cept="./vendor/bin/codecept"
    
        cept g:cept acceptance HomePage

полная форма :
    
        vendor/bin/codecept generate:cept acceptance HomePage

Сгенерированый файл paradam.me.loc/tests/acceptance/HomePageCept.php
чтобы PhpStorm неподсвечивал параметр $scenario прописуем аннотацию

    /**
	 * @var \Codeception\Scenario $scenario
	 */
	 
	 
	 $I->wantTo('Тест домашней страницы');
	 
	 $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
	 
# Запуск тестов в Googlecloud


заходм в docker

git pull

1. переименовать /app/tests/acceptance.suite.yml.example
в /app/tests/acceptance.suite.yml

2. прописать url в секции  - PhpBrowser:

3. cept run


#Модуль Services(Услуги)

http://paradam.loc/ru/services/  - Главная страница модуля

http://paradam.loc/ru/services/service - Страница отображения всех услуг

http://paradam.loc/ru/services/question - страница отображает все вопросы

http://paradam.loc/ru/services/service-question - страница отношений услуг и вопросов


