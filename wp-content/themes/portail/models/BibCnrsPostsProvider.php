<?php
class BibCnrsPostsProvider {

    private $domains;

    public function __construct($domains) {
        $this->domains = $domains;
    }

    public function getPostsNotIn($category, $max) {
        foreach ($this->domains as $value) {
            $cat = get_category_by_slug($value);
            if ($cat->slug != $category->slug) {
                $categoryIds[] = get_category_by_slug($value)->term_id;
            }
        }

        return Timber::get_posts(array( 'category__in' => $categoryIds, 'showposts' => $max));
    }

    public function getPostsFor($category) {
        return Timber::get_posts(['category_name' => $category->slug ]);
    }

    public function getCurrentPost() {
        return new TimberPost();
    }
}
