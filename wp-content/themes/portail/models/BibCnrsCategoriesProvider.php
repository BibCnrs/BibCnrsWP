<?php

class BibCnrsCategoriesProvider {

    private $getTheCategory;
    private $getCategoryBySlug;
    private $getCurrentUser;

    public function __construct($getTheCategory, $getCategoryBySlug, $getCurrentUser) {
        $this->getTheCategory = $getTheCategory;
        $this->getCategoryBySlug = $getCategoryBySlug;
        $this->getCurrentUser = $getCurrentUser;
    }

    public function getCurrentCategory() {
        return $this->getTheCategory()[0];
    }

    public function getUserCategory() {
        return $this->getCategoryBySlug($this->getCurrentUser()->get('domain'));
    }

    /**
     * allow to call anonymous function stored in this class property
    **/
    public function __call($method, $args) {
        if (isset($this->$method)) {
            $func = $this->$method;

            return call_user_func_array($func, $args);
        }
    }
}
