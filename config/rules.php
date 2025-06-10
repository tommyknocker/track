<?php

$uuidRegExp = '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}';

return  [
    'GET <module:api>/<controller:track>' => '<module>/<controller>/index',
    'GET <module:api>/<controller:track>/<id:\d+>' => '<module>/<controller>/get',
    'POST <module:api>/<controller:track>' => '<module>/<controller>/create',
    'PATCH <module:api>/<controller:track>/<id:\d+>' => '<module>/<controller>/update',
    'DELETE <module:api>/<controller:track>/<id:\d+>' => '<module>/<controller>/delete',
    'POST <module:api>/<controller:track>/<action:change-status>' => '<module>/<controller>/change-status',
    '/register' => 'site/register',
    '/login' => 'site/login',
    '/logout' => 'site/logout',
    '/updates' => 'site/updates',
    '/recovery' => 'site/recovery',
    '/reset-password/<hash:' . $uuidRegExp . '>/' => 'site/reset-password',
];