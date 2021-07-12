<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';

try{
    //подключение к API amoCRM (необходимо ввести свои данные)
    require_once __DIR__ . '/amocrm_connection.php';

    $pipelineId = 4455868; //id воронки

    //получение сделок из тестовой воронки для вывода в Google Sheets
    $leadList = getLeadsFromPipeline($amo, $pipelineId);
    //получение массива из id контактов к сделкам
    $contactList = getContactsByLeads($amo, $leadList);

    //создание массива информации о сделках для вывода в Google Sheets
    $values =  getLeadsInfo($leadList, $contactList);

    //подключение к Google Sheets
    $googleAccountKeyFilePath = __DIR__ . '/assets/example-example-example.json'; //путь к ключу сервисного аккаунта (нужно получить свой)
    putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();

    // Области, к которым будет доступ
    $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' ); // добавить Google Sheets в область доступа
    $service = new Google_Service_Sheets( $client ); // создание сервиса для доступа к таблицам
    $spreadsheetId = '1Gjmq1dpaTgsayR7qzftDQukmjWNWBp8bNfktrCFZU30'; // id таблицы
    $response = $service->spreadsheets->get($spreadsheetId); // запрос к таблице
    $spreadsheetProperties = $response->getProperties(); //получение свойств таблицы

    //занесение сделок в Google Sheets
    $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );
    $options = array( 'valueInputOption' => 'RAW' );
    $service->spreadsheets_values->update( $spreadsheetId, '!A2', $body, $options );

} catch (Exception $e) {
    printf('Error (%d): %s', $e->getCode(), $e->getMessage());
}


