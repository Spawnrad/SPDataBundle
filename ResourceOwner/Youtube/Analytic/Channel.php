<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'items' => 'rows',
        'error' => 'error.message',
    ];

    public function getInformation(array $extraParameters = [], $content = null)
    {
        if (!$extraParameters) {
            $now = new \DateTime();

            $start_date = '2005-01-01';
            $end_date = $now->format('Y-m-d');

            $youtube_parameters = ['ids' => 'channel==MINE',
                'startDate' => $start_date,
                'endDate' => $end_date];

            $extraParameters = array_merge($youtube_parameters, $extraParameters);
        }

        return parent::getInformation($extraParameters);
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://youtubeanalytics.googleapis.com/v2/reports?metrics=viewerPercentage&dimensions=ageGroup',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
