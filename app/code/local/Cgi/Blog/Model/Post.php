<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 14.07.16
 * Time: 18:24
 */
class Cgi_Blog_Model_Post extends Mage_Core_Model_Abstract
{

    public function getPosts()
    {
        $posts = [
            [
                'title' => 'Post1',
                'author' => 'User1',
                'date_create' => '21.06.2016'
            ],
            [
                'title' => 'Post2',
                'author' => 'User2',
                'date_create' => '22.06.2016'
            ]
        ];
        return $posts;
    }
}