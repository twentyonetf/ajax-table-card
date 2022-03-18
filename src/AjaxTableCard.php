<?php

namespace Twentyonetf\AjaxTableCard;

use Illuminate\Support\Str;
use Laravel\Nova\Card;

class AjaxTableCard extends Card
{
    /**
     * The title of the card, must be unique as
     * it will be used as the slug
     * for cache control
     *
     * @var string
     */
    public string $title = 'Ajax Table Card';

    /**
     * An array of table headers that will be used
     * to display the data
     *
     */
    public array $header = [];

    /**
     * The link to fetch the data from.
     *
     * @var string
     */
    public string $link;

    /**
     * The period to cache the data for.
     *
     * @var string
     */
    public string $cache = '86400';

    /**
     * Define the last column as a link or not.
     *
     * @var bool
     */
    public bool $linkable = true;

    /*
     * The default status of table, expanded or collapsed
     *
     */
    public bool $expanded = true;

    /*
     * Display a counter of how many results next to the title
     *
     */
    public bool $countable = true;

    /*
     * Hide the card when there's no data.
     * (warning) if you have a long cache time, the user has no way to
     * refresh the card to see if there's new data.
     *
     */
    public bool $hideWhenEmpty = true;


    public function slug()
    {
        return Str::slug($this->title);
    }

    /**
     * @return string[]
     */
    public function meta(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug(),
            'cache' => $this->cache,
            'link' => $this->link,
            'header' => $this->header,
            'linkable' => $this->linkable,
            'expanded' => $this->expanded,
            'countable' => $this->countable,
            'hideWhenEmpty' => $this->hideWhenEmpty
        ];
    }



    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'ajax-table-card';
    }
}
