<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HWI\Bundle\OAuthBundle\OAuth\ResourceOwner;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * InstagramResourceOwner.
 *
 * @author Jean-Christophe Cuvelier <jcc@atomseeds.com>
 */
class InstagramResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = array(
        'identifier'      => 'data.id',
        'name'        => 'data.username',
        'profilepicture'  => 'data.profile_picture',
        'followers' => 'data.counts.followed_by',
    );

    /**
     * {@inheritdoc}
     */
    protected function doGetUserInformationRequest($url, array $parameters = array())
    {
        return $this->httpRequest($this->normalizeUrl($url, $parameters), null, array(), 'GET');
    }

        /**
     * {@inheritDoc}
     */
    public function revokeToken($token)
    {
        $parameters = array(
            'client_id' => $this->options['client_id'],
            'client_secret' => $this->options['client_secret'],
            'token' => $token,
        );

        $response = $this->httpRequest($this->options['revoke_token_url'], http_build_query($parameters, '', '&'), array(), 'POST');

        return 200 === $response->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'authorization_url'         => 'https://api.instagram.com/oauth/authorize',
            'access_token_url'          => 'https://api.instagram.com/oauth/access_token',
            'revoke_token_url'          => 'https://www.instagram.com/oauth/revoke_access/',
            'infos_url'                 => 'https://api.instagram.com/v1/users/self',

            // Instagram supports authentication with only one defined URL
            'auth_with_one_url' => false,

            'use_bearer_authorization' => false,
        ));
    }
}
