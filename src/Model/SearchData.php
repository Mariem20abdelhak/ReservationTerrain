<?php

namespace App\Model;

use DateTimeInterface;

class SearchData
{
    /** @var int */
    public $page = 1;

    /** @var string */
    public string $location = '';

    /** @var array */
    public array $category = [];
}
