<?php

class BibCnrsCategory {

    public $currentCategory;
    public $userCategory;
    public $visit;

    public function __construct($domains, $news) {
        $this->currentCategory = get_the_category()[0];
        $this->userCategory = get_category_by_slug(wp_get_current_user()->get('domain'));
        $this->visit = $this->userCategory ? $this->currentCategory->slug != $this->userCategory->slug : true;
    }
}
