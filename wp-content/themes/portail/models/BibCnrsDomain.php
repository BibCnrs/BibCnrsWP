<?php

class BibCnrsDomain {
    public $currentCategory;
    public $userCategory;
    public $visit;
    public function __construct($domains, $news) {
        $this->currentDomain = get_the_category()[0];
        $this->userDomain = get_category_by_slug(wp_get_current_user()->get('domain'));
        $this->visit = $this->userDomain ? $this->currentDomain->slug != $this->userDomain->slug : true;
    }
}
