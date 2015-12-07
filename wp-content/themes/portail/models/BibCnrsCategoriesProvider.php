<?php

require_once dirname(__FILE__) . '/../utils/CallablePropertyTrait.php';

class BibCnrsCategoriesProvider {
    use CallablePropertyTrait;

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
}
