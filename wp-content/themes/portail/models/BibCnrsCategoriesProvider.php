<?php

class BibCnrsCategoriesProvider {

    public function getCurrentCategory() {
        return get_the_category()[0];
    }

    public function getUserCategory() {
        return get_category_by_slug(wp_get_current_user()->get('domain'));
    }
}
