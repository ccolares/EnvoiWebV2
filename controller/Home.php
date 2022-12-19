<?php

Class Home extends appModel {

    public function __construct() {
        
    }

    public function indexAction() {
        Tpl::View("site.index");
    }

}
