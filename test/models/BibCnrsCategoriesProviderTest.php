<?php

require dirname(__FILE__) . '/../../wp-content/themes/portail/models/BibCnrsCategoriesProvider.php';
require dirname(__FILE__) . '/../utils/Literal.php';

class BibCnrsCategoriesProviderTest extends PHPUnit_Framework_TestCase
{

    public function testgetCurrentCategory()
    {
        function get_the_category() {
            return ['wantedCurrentCategory'];
        }
        $categoryProvider = new BibCnrsCategoriesProvider();
        $category = $categoryProvider->getCurrentCategory();
        $this->assertEquals('wantedCurrentCategory', $category);
    }

    public function testgetUserCategory()
    {
        function wp_get_current_user() {
            return new Literal([
                'get' => function ($fieldname) {
                    return 'userDomain';
                }
            ]);
        }
        function get_category_by_slug($slug) {
            if ($slug == 'userDomain') {
                return 'wantedUserCategory';
            }

            return 'wrongDomain';
        }

        $categoryProvider = new BibCnrsCategoriesProvider();
        $category = $categoryProvider->getUserCategory();
        $this->assertEquals('wantedUserCategory', $category);
    }
}
