<?php

require_once dirname(__FILE__) . '/../../wp-content/themes/portail/models/BibCnrsPostsProvider.php';
require_once dirname(__FILE__) . '/../utils/Literal.php';

class BibCnrsPostsProviderTest extends PHPUnit_Framework_TestCase
{

    public function testGetPostsNotIn()
    {
        $domains = [
            'mySlug',
            'hisSlug',
            'herSlug',
            'theirSlug'
        ];
        $getCategoryBySlugCall = [];
        $getCategoryBySlug = function ($slug) use(&$getCategoryBySlugCall) {
            $getCategoryBySlugCall[] = $slug;

            return (object) [
                'slug' => $slug,
                'term_id' => $slug
            ];
        };
        $getPostsCall = [];
        $getPosts = function ($args) use(&$getPostsCall) {
            $getPostsCall[] = $args;

            return 'list of posts';
        };
        $postsProvider = new BibCnrsPostsProvider($domains, $getCategoryBySlug, $getPosts);
        $posts = $postsProvider->getPostsNotIn((object)['slug' => 'mySlug'], 4);
        $this->assertEquals($domains, $getCategoryBySlugCall);
        $this->assertEquals([[
            'category__in' => [
                'hisSlug',
                'herSlug',
                'theirSlug'
            ],
            'showposts' => 4
        ]], $getPostsCall);
        $this->assertEquals('list of posts', $posts);
    }

    public function testGetPostsFor() {
        $getPostsCall = [];
        $getPosts = function ($args) use(&$getPostsCall) {
            $getPostsCall[] = $args;

            return 'list of posts';
        };

        $postsProvider = new BibCnrsPostsProvider(null, null, $getPosts);
        $posts = $postsProvider->getPostsFor((object)['slug' => 'mySlug']);

        $this->assertEquals([['category_name' => 'mySlug' ]], $getPostsCall);
        $this->assertEquals('list of posts', $posts);
    }
}
