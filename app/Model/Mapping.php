<?php

class Mapping extends AppModel {

    public $name = 'Mapping';

    public $whitelist = array(
        'id_user', 'role', 'pid', 'status', 'activation'
    );

    /**
     * Return a UUID suitable for account activation and reset tokens.
     */
    function getToken() {
        App::uses('String', 'Utility');
        return CakeText::uuid();
    }
}
