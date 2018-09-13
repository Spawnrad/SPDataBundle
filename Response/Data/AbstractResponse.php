<?php

namespace SP\Bundle\DataBundle\Response\Data;

use SP\Bundle\DataBundle\ResourceOwner\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

abstract class AbstractResponse implements DataResponseInterface
{
    /**
     * @var array
     */
    protected $response;

    /**
     * @var array
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $Etag;

    /**
     * @var ResourceOwnerInterface
     */
    protected $resourceOwner;

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse($response)
    {
        if (is_array($response)) {
            $this->response = $response;
        } else {
            // First check that response exists, due too bug: https://bugs.php.net/bug.php?id=54484
            if (!$response) {
                $this->response = array();
            } else {
                $this->response = json_decode($response, true);

                if (JSON_ERROR_NONE !== json_last_error()) {
                    throw new AuthenticationException('Response is not a valid JSON code.');
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusCode($status_code)
    {
        $this->statusCode = $status_code;
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceOwner()
    {
        return $this->resourceOwner;
    }

    /**
     * {@inheritdoc}
     */
    public function setResourceOwner(ResourceOwnerInterface $resourceOwner)
    {
        $this->resourceOwner = $resourceOwner;
    }

    /**
     * @return array
     */
    public function getEtag()
    {
        return $this->Etag;
    }

    /**
     * @param array $etag
     */
    public function setEtag($Etag)
    {
        $this->Etag = $Etag;
    }
}
