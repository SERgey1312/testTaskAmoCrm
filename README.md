# test task amoCRM
_Этот проект - тестовое задание от Bizandsoft._

***

__Задание:__
1. Cоздать в  amoCRM 300 сделок c одним контактом в каждой. Заполнить поля: название сделки, название контакта, бюджет сделки, телефон контакта, одно кастомное поле. Данные заполнять рандомайзером. (за создание воронки, сделок и контактов в amoCRM отвечает файл pipelina_and_leads_creating.php)
2. Выгрузить из  amoCRM эти 300 сделок в Google sheets. Поля таблицы: название сделки, название контакта, бюджет сделки, телефон контакта, одно кастомное поле. (за получение сделок из amoCRM и занесение этих сделок в Google Sheets отвечает файл index.php)

***

_При выполнении использовались следующие библиотеки:_
1) amocrm-php (установка через composer: "composer require dotzero/amocrm") - для работы с API amoCRM.
2) faker-php (установка через composer: "composer require fzaninotto/faker") - для генерации случайных данных.
3) google/apiclient (установка через composer: "composer require google/apiclient:^2.0") - для работы с API Google Sheets.

***

Итоговая таблица:
<https://docs.google.com/spreadsheets/d/1Gjmq1dpaTgsayR7qzftDQukmjWNWBp8bNfktrCFZU30/edit#gid=0>
