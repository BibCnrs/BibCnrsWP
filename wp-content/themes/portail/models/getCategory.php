<?php

function getCategory($domains, $news) {
    $category = get_the_category();
    $title = $category[0]->name;
    $currentDomain = $category[0]->name;
    $nicename = $category[0]->category_nicename;
    /* Include CNRS domains definition ($domains) and home category definition ($news) arrays*/
    if (in_array($nicename, $news)){
        $currentDomain = 'visit';
    } else {
        force_login();
    }
    if (is_user_logged_in()){
        $_SESSION['domaine'] = 'biologie';
    }
    if (isset($_SESSION['domaine'])){
        $userDomain = $_SESSION['domaine'];
        $categOrigin = get_category_by_slug($_SESSION['domaine']);
        $institute = $categOrigin->category_description;
        $visit = false;
        if ($nicename != $_SESSION['domaine']){
            $visit = true;
            $currentDomain = $title;
            $title = $categOrigin->name;
        }
        /* Delete origin domain from domains array for searching all the posts */
        while (($key = array_search($userDomain, $domains)) !== false) {
            unset($domains[$key]);
        }
    }
    else {
        $userDomain = $nicename;
        $visit = false;
        if (in_array($nicename,$news)){
            $institute = '';
        }
        else {
            $institute = $category[0]->category_description;
        }
    }

    return [
        'visit' => $visit,
        'title' => $title,
        'currentDomain' => $currentDomain,
        'institute' => $institute,
        'userDomain' => $userDomain
    ];
}
