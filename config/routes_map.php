<?php

$routes = [
    // Basic API calls
    '/' => ['searchAddress'],
    '/search' => ['searchAddress'],
    '/save' => ['saveAddress', 'auth'],
    '/read' => ['readAddress', 'auth'],
];