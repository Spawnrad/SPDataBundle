<?php

namespace SP\Bundle\DataBundle\Response\Data;

use SP\Bundle\DataBundle\Response\ResponseInterface;

interface DataResponseInterface extends ResponseInterface
{
    /**
     * Get the title to display.
     *
     * @return string
     */
    public function getId();

    /**
     * Get the title to display.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the description to display.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the link to display.
     *
     * @return string
     */
    public function getLink();

    /**
     * Get the shortcode to display.
     *
     * @return string
     */
    public function getShortCode();    

    /**
     * Get the thumbnail to display.
     *
     * @return string
     */
    public function getThumbnail();

    /**
     * Get the publishedAt to display.
     *
     * @return string
     */
    public function getPublishedAt();

    /**
     * Get the items to display.
     *
     * @return array
     */
    public function getItems();

    /**
     * Get the pagination.
     *
     * @return array
     */
    public function getPagination();
}
