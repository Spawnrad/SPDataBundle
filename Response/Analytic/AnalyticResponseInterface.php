<?php

namespace SP\Bundle\DataBundle\Response\Analytic;

use SP\Bundle\DataBundle\Response\ResponseInterface;

interface AnalyticResponseInterface extends ResponseInterface
{
    /**
     * Get the title to display.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get the ViewCount to display.
     *
     * @return string
     */
    public function getViewCount();

    /**
     * Get the CommentCount to display.
     *
     * @return string
     */
    public function getCommentCount();

    /**
     * Get the SubscriberCount to display.
     *
     * @return string
     */
    public function getSubscriberCount();

    /**
     * Get the postCount to display.
     *
     * @return string
     */
    public function getPostCount();

    /**
     * Get the items to display.
     *
     * @return array
     */
    public function getItems();

    /**
     * Get the Name of items to display.
     *
     * @return array
     */
    public function getItemName();

    /**
     * Get the pagination.
     *
     * @return array
     */
    public function getPagination();

    public function getFollowers();

    public function getProfilePicture();

    public function getName();
}
