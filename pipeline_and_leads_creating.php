<?php
require_once __DIR__ . '/vendor/autoload.php';

try{
    //подключение к API amoCRM (необходимо ввести свои данные)
    require_once __DIR__ . '/amocrm_connection.php';

    //создание объекта генерации случайных данных
    $faker = Faker\Factory::create();

    //создание тестовой воронки
    $pipeline = $amo->pipelines;
    $pipeline['name'] = "!!! TEST !!!";
    $pipeline->addStatusField([
        'name' => 'Pending',
        'sort' => 10,
        'color' => '#fffeb2',
    ]);
    $pipeline->addStatusField([
        'name' => 'Done',
        'sort' => 20,
        'color' => '#f3beff',
    ]);
    $pipelineId = $pipeline->apiAdd(); //добавление воронки

    //заполнение тестовой воронки сделками и создание контактов к сделкам
    $allLeads = [];
    $allContacts = [];
    for ($i = 1; $i <= 300; $i++){
        $lead = $amo->lead;
        $lead['pipeline_id'] = $pipelineId;
        $lead['name'] = 'testLead' . $i;
        $lead['price'] = rand(500, 5000);
        $lead->addCustomField(276695, [
            ["$faker->text"]
        ]);
        $lead->addCustomField(316953, [ //кастомное поле (для выборки сделок из воронки)
            [(string)$pipelineId]
        ]);
        $allLeads[] = $lead;

        $contact = $amo->contact;
        $contact['name'] = $faker->name;
        $contact->addCustomField(30379,[ // кастомное поле телефон (OTHER)
            [$faker->phoneNumber, "OTHER"]
        ]);
        $allContacts[] = $contact;
    }

    //добавление всех сделок и контактов к ним в amoCRM
    $idLeads = $amo->lead->apiAdd($allLeads);
    for ($i = 0; $i < count($idLeads); $i++){
        $allContacts[$i]['linked_leads_id'] = [(int)$idLeads[$i]]; //привязка контактов к сделкам
    }
    $idContacts = $amo->contact->apiAdd($allContacts);

} catch (Exception $e) {
    printf('Error (%d): %s', $e->getCode(), $e->getMessage());
}
