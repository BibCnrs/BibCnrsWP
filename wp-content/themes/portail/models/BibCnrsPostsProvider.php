<?php
require_once dirname(__FILE__) . '/../utils/CallablePropertyTrait.php';

class BibCnrsPostsProvider {
    use CallablePropertyTrait;

    private $domains;
    private $getCategoryBySlug;
    private $getPosts;

    public function __construct($domains, $getCategoryBySlug, $getPosts) {
        $this->domains = $domains;
        $this->getCategoryBySlug = $getCategoryBySlug;
        $this->getPosts = $getPosts;
    }

    public function getPostsNotIn($category, $max) {
        foreach ($this->domains as $value) {
            $cat = $this->getCategoryBySlug($value);
            if ($cat->slug != $category->slug) {
                $categoryIds[] = $cat->term_id;
            }
        }
        return $this->getPosts(['category__in' => $categoryIds, 'showposts' => $max]);
    }

    public function getPostsFor($category) {
        return $this->getPosts(['category_name' => $category->slug ]);
    }
}
