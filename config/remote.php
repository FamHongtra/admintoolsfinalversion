<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Remote Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default connection that will be used for SSH
    | operations. This name should correspond to a connection name below
    | in the server list. Each connection will be manually accessible.
    |
    */

    'default' => 'production',

    /*
    |--------------------------------------------------------------------------
    | Remote Server Connections
    |--------------------------------------------------------------------------
    |
    | These are the servers that will be accessible via the SSH task runner
    | facilities of Laravel. This feature radically simplifies executing
    | tasks on your servers, such as deploying out these applications.
    |
    */

    'connections' => [
        'production' => [
            'host'      => '',
            'username'  => '',
            'password'  => '',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 10,
        ],
        'gitlab' => [
            'host'      => '13.228.10.174',
            'username'  => 'root',
            'password'  => 'project2017',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 120,
        ],
        //In progress
        'gitlab2' => [
            'host'      => '13.228.10.174',
            'username'  => 'ubuntu',
            'password'  => '',
            'key'       => 'gitlab.pem',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 10,
        ],
        //Ansible Server on AWS
        'ansible2' => [
            'host'      => '13.228.0.211',
            'username'  => 'ubuntu',
            'password'  => '',
            'key'       => 'ansible.pem',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 120,
        ],
        'ansible' => [
            'host'      => '54.254.145.81',
            'username'  => 'centos',
            'password'  => 'eieiei',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
            'timeout'   => 120,
        ],
        // 'ansible' => [
        //     'host'      => '10.4.24.174',
        //     'username'  => 'root',
        //     'password'  => 'eieiei',
        //     'key'       => '',
        //     'keytext'   => '',
        //     'keyphrase' => '',
        //     'agent'     => '',
        //     'timeout'   => 90,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Remote Server Groups
    |--------------------------------------------------------------------------
    |
    | Here you may list connections under a single group name, which allows
    | you to easily access all of the servers at once using a short name
    | that is extremely easy to remember, such as "web" or "database".
    |
    */

    'groups' => [
        'web' => ['production'],
    ],

];
