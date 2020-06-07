<?php

namespace App\Entity;

use App\Entity\Country;

class Search
{
    public $page=1;

    public $identity = "";

    /**
     *
     * @var Country
     */
    public $country;



    public $phone = "";

    /**
     *
     * @var boolean
     */
    public $maxPosts = false;

    /**
     *
     * @var boolean
     */

    public $maxLikes = false;
}
