<?php

require_once dirname(__FILE__) . '/../../wp-content/themes/portail/models/BibCnrsCategoriesProvider.php';
require_once dirname(__FILE__) . '/../utils/Literal.php';

class BibCnrsCategoriesProviderTest extends PHPUnit_Framework_TestCase
{

    public function testgetCurrentCategory()
    {
        $getTheCategoryCall = 0;
        $getTheCategory = function () use(&$getTheCategoryCall) {
            $getTheCategoryCall++;
            return ['wantedCurrentCategory'];
        };
        $categoryProvider = new BibCnrsCategoriesProvider($getTheCategory, null, null);
        $category = $categoryProvider->getCurrentCategory();
        $this->assertEquals(1, $getTheCategoryCall);
        $this->assertEquals('wantedCurrentCategory', $category);
    }

    public function testgetUserCategory()
    {
        $getCurrentUserCall = 0;
        $getCurrentUser = function () use(&$getCurrentUserCall) {
            $getCurrentUserCall++;

            return new Literal([
                'get' => function ($fieldname) {
                    return 'userDomain';
                }
            ]);
        };

        $getCategoryBySlugCall = [];
        $getCategoryBySlug = function ($slug) use(&$getCategoryBySlugCall) {
            $getCategoryBySlugCall[] = $slug;
            if ($slug == 'userDomain') {
                return 'wantedUserCategory';
            }

            return 'wrongDomain';
        };

        $categoryProvider = new BibCnrsCategoriesProvider(null, $getCategoryBySlug, $getCurrentUser);
        $category = $categoryProvider->getUserCategory();
        $this->assertEquals(1, $getCurrentUserCall);
        $this->assertEquals(['userDomain'], $getCategoryBySlugCall);
        $this->assertEquals('wantedUserCategory', $category);
    }
}
