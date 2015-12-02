<?php

function getCategory($domains, $news) {
    $currentUser = wp_get_current_user();
    $userDomain = get_category_by_slug($currentUser->get('domain'));
    $currentDomain = get_the_category()[0];
    if (!is_user_logged_in() && $currentDomain && in_array($currentDomain->slug, $domains)){
        force_login();
    }

    return [
        'visit' => $userDomain ? $currentDomain->slug != $userDomain->slug : true,
        'currentDomain' => $currentDomain,
        'userDomain' =>  $userDomain
    ];
}
