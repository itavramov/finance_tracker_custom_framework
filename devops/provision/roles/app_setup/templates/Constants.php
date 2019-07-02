<?php

namespace util;

class Constants{
    //DB CONST
    const DB_NAME     = "{{ mysql_database_name }}";
    const DB_HOST     = "{{ db_host }}";
    const DB_PORT     = "3306";
    const DB_USER     = "{{ mysql_database_user_name }}";
    const DB_PASS     = "{{ mysql_database_user_pass }}";
    //DATE FORMAT FOR DB CONST
    const DATE_FORMAT     = '%Y-%m-%d %H:%i';
    //DATE FORMAT FOR PHP
    const DATE_FORMAT_PHP = 'Y-m-d';
    //const DOMAIN_NAME     = "https://" . $_SERVER[HTTP_HOST];
}