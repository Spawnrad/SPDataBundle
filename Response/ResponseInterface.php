<?php


namespace SP\Data\Response;

use SP\Data\ResourceOwner\ResourceOwnerInterface;


interface ResponseInterface
{
    /**
     * Get the api response.
     *
     * @return array
     */
    public function getResponse();

    /**
     * Set the raw api response.
     *
     * @param int $response status code
     */
    public function setResponse($response);

    /**
     * Get the api response status code.
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Set the raw api response status code.
     *
     * @param string|array $response
     */
    public function setStatusCode($status_code);

    /**
     * Get the api response etag.
     *
     * @return int
     */
    public function getEtag();

    /**
     * Set the raw api response etag.
     *
     * @param string|array $response
     */
    public function setEtag($etag);

    /**
     * Get the resource owner responsible for the response.
     *
     * @return ResourceOwnerInterface
     */
    public function getResourceOwner();

    /**
     * Set the resource owner for the response.
     *
     * @param ResourceOwnerInterface $resourceOwner
     */
    public function setResourceOwner(ResourceOwnerInterface $resourceOwner);
}
