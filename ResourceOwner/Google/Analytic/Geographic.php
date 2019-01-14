<?php

namespace SP\Bundle\DataBundle\ResourceOwner\Google\Analytic;

use SP\Bundle\DataBundle\ResourceOwner\GenericOAuth2ResourceOwner;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Geographic extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'items' => 'reports.0.data',
        'error' => 'error.message',
    );

    /**
     * {@inheritDoc}
     */
    public function getInformation(array $extraParameters = array(), $content = null)
    {
        $content = json_encode([
            'reportRequests' => [
                [
                    'viewId' => '62414894',
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
                    ],
                    'dimensions' => [
                        [
                            'name' => 'ga:countryIsoCode',
                        ],
                    ],
                    "orderBys" => [
                        [
                            'fieldName' => 'ga:users',
                            'sortOrder' => 'DESCENDING'
                        ],
                    ],
                    'pageSize' => 5,
                ],
            ],
        ]);

        unset($extraParameters['viewId']);

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
