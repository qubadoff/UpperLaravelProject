<?php

declare(strict_types=1);

return [
    200 => [
        'login' => 'You are logged in',
        'logout' => 'You are logged out from profile',
        'ticket-take' => 'A ticket has been assigned to the user',
        'tickets-deposit' => 'Create the deposit for ticket',
        'tickets-filter' => 'Get the filtered user tickets',
        'tickets-user' => 'Get the user tickets',
        'user-detail' => 'Get the user detail',
        'user-payments' => 'Get the user payments',
    ],
    401 => [
        'authentication' => 'Authentication error : 401',
        'login' => 'Id or password you entered is invalid',
    ],
    403 => [
        'ticket-take' => 'Internal technicians cannot claim the ticket',
    ]
];
