<?php
class BibCnrsPosts {
    private $domains;

    public function __construct($domains) {
        $this->domains = $domains;
    }

    public function getPostsNotIn($domain, $max) {
        foreach ($this->domains as $value) {
            $cat = get_category_by_slug($value);
            if ($cat->slug != $domain->slug) {
                $domainIds[] = get_category_by_slug($value)->term_id;
            }
        }

        return Timber::get_posts(array( 'category__in' => $domainIds, 'showposts' => $max));
    }

    public function getPostsFor($domain) {
        return Timber::get_posts(['category_name' => $domain->slug ]);
    }

    public function getCurrentPost() {
        return new TimberPost();
    }
}
