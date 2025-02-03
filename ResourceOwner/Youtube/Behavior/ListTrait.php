<?php

/**
 * This file is a part of nekland youtube api package.
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace SP\Bundle\DataBundle\ResourceOwner\Youtube\Behavior;

trait ListTrait
{
    /**
     * @param string $id
     *
     * @return array
     */
    public function listById($id, array $parts = ['snippet'], array $otherParameters = [])
    {
        $parameters = array_merge(
            ['part' => implode(',', $parts), 'id' => $id],
            $otherParameters
        );

        return $this->getInformation($parameters);
    }

    /**
     * @return array
     */
    public function listBy(array $filters, array $parts = ['snippet'], array $otherParameters = [])
    {
        $parameters = array_merge(
            ['part' => implode(',', $parts)],
            $filters,
            $otherParameters
        );

        return $this->getInformation($parameters);
    }
}
