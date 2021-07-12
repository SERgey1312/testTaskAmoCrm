<?php

/*
 * метод для получения контакта из сделки
 */
function getContactByLead($lead, $contacts) {
    foreach ($contacts as $contact){
        if ($contact['id'] == $lead['main_contact_id']){
            return $contact;
        }
    }
    return  0;
}

/*
 * метод для получения сделок из воронки
 */
function getLeadsFromPipeline($amo, $pipelineId){
    return $amo->lead->apiList([
        'query' => (string)$pipelineId,
    ]);
}

/*
 * метод для получения массива контактов для нужных сделок
 */
function getContactsByLeads($amo, $leadList) {
    $idAllContacts = [];
    foreach ($leadList as $lead){
        $idAllContacts[] = $lead['main_contact_id'];
    }
    return $amo->contact->apiList([
        'id' => $idAllContacts,
    ]);
}

/*
 * создание массива информации для вывода в Google Sheets
 */

function getLeadsInfo($leadList, $allContacts) {
    $values = [];
    for ($i = 0; $i < count($leadList); $i++){
        $currentLead = $leadList[$i];
        $currentContact = getContactByLead($currentLead, $allContacts);
        $values[] = [
            $currentLead['name'], //название сделки
            $currentContact['name'], //название контакта
            $currentLead['price'], // бюджет сделки
            $currentContact['custom_fields'][0]['values'][0]['value'], // телефон контакта
            $currentLead['custom_fields'][0]["values"][0]['value'], // кастомное поле (ВОПРОС)
        ];
    }
    return $values;
}