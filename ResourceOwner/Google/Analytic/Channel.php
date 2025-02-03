<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Google\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Channel extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'items' => 'reports.0.data',
        'error' => 'error.message',
    ];

    public function getInformation(array $extraParameters = [], $content = null)
    {
        $content = json_encode([
            'reportRequests' => [
                [
                    'viewId' => $extraParameters['viewId'],
                    'dateRanges' => [
                        [
                            'startDate' => '30daysAgo',
                            'endDate' => 'yesterday',
                        ],
                    ],
                    'metrics' => [
                        [
                            'expression' => 'ga:users',
                        ],
                        [
                            'expression' => 'ga:pageviews',
                        ],
                    ],
                ],
            ],
        ]);

        unset($extraParameters['viewId']);

        return parent::getInformation($extraParameters, $content);
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'infos_url' => 'https://analyticsreporting.googleapis.com/v4/reports:batchGet',
            'response_class' => 'SP\Bundle\DataBundle\Response\Data\PathResponse',
        ]);
    }
}
