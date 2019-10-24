<?php

session_start();

routerRegisterRoute( 'GET', '/', 'home', 'index' );

routerRegisterRoute( 'GET', '/jouets', 'toy', 'index' );

routerStart();