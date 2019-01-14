<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Google\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'items' => 'rows',
        'error' => 'error.message',
    );

    /**
     * {@inheritDoc}
     */
    public function getInformation(array $extraParameters = array(), $content = null)
    {
        // $start_date = '30daysAgo';
        // $end_date = 'yesterday';

        // $dateRanges = [
        //     'startDate' => $start_date,
        //     'endDate' => $end_date,
        // ];

        // $content['dateRanges'] = $dateRanges;

        return parent::getInformation($extraParameters, $content);
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'infos_url' => 'https://analyticsreporting.googleapis.com/v4/reports:batchGet',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ));
    }
}
