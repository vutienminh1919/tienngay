<?php

return [
    'name' => 'Homedy',
    'test' => env('213'),
    'secret_key' => env('HOMEDY_CLIENT', 'mQksh64fDUNhdmzsCEMVtQZ9GzbLXNsZ'),
    'homedy_hook' => env('HOMEDY_HOOK', ''),
    'homedy_secret' => 'Bearer '. env('HOMEDY_SECRET', 't6KS8SQ87gBwCEsZyp2B8V8t6VjqYeQ7'),
];
