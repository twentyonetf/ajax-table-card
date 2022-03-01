<?php

namespace App\Nova\Cards;

use Twentyonetf\AjaxTableCard\AjaxTableCard;

class :className extends AjaxTableCard
{
    /**
     * The title of the card, must be unique as
     * it will be used as the slug
     * for cache control
     *
     * @var string
     */
    public string $title = ':title' ;

    /**
     * An array of table headers that will be used
     * to display the data
     *
     */
    public array $header = [''];

    /**
     * The link to fetch the data from.
     *
     * @var string
     */
    public string $link = '';
}
