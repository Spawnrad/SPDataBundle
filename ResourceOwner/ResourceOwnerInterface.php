<?php

namespace SP\Bundle\DataBundle\ResourceOwner;

use SP\Bundle\DataBundle\Response\ResponseInterface;

/**
 * ResourceOwnerInterface.
 *
 * @author Geoffrey Bachelet <geoffrey.bachelet@gmail.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
interface ResourceOwnerInterface
{
    /**
     * Retrieves the user's information from an access_token.
     * @return ResponseInterface the wrapped response interface
     */
    public function getInformation(array $extraParameters = [], array $content = null);

    /**
     * Return a name for the resource owner.
     *
     * @return string
     */
    public function getName();

    /**
     * Retrieve an option by name.
     *
     * @param string $name The option name
     *
     * @return mixed The option value
     *
     * @throws \InvalidArgumentException When the option does not exist
     */
    public function getOption($name);

    /**
     * Sets a name for the resource owner.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Retrieve an access token
     *
     * @return The access token
     */
    public function getAccessToken();

    /**
     * Sets an access token
     *
     * @return The access token
     */
    public function setAccessToken($access_token);

    /**
     * Retrieve an etag
     *
     * @return The Etag
     */
    public function setEtag($etag);

    /**
     * Sets an etag
     *
     * @return The etag
     */
    public function getEtag();
}
