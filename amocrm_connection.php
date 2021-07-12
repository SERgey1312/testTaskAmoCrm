<?php

$subdomain = "example"; // домен 3-его уровня в amoCRM
$login = "example@gmail.com"; // login
$apikey = "example_example_example_example"; // ключ API
$amo = new \AmoCRM\Client($subdomain, $login, $apikey);