<?php


namespace SP\Bundle\DataBundle\Response;

use SP\Bundle\DataBundle\ResourceOwner\ResourceOwnerInterface;


interface ResponseInterface
{
    public function getResponse();

    public function setResponse($response);

    public function getStatusCode();

    public function setStatusCode($status_code);

    public function getEtag();

    public function setEtag($etag);

    public function getResourceOwner();

    public function setResourceOwner(ResourceOwnerInterface $resourceOwner);
}
