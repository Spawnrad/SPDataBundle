<?php

namespace SP\Bundle\DataBundle\Response\Analytic;

class PathResponse extends AbstractResponse
{
    /**
     * @var array
     */
    protected $paths = array(
        'identifier' => null,
        'followers' => null,
        'profilepicture' => null,
        'name' => null,
        'viewCount' => null,
        'commentCount' => null,
        'likeCount' => null,
        'shareCount' => null,
        'subscriberCount' => null,
        'postCount' => null,
        'items' => null,
        'item_name' => null,
        'error' => null,
    );

    public function getId($level = null)
    {
        return $this->getValueForPath('identifier', $level);
    }

    public function getProfilePicture()
    {
        return $this->getValueForPath('profilepicture');
    }

    public function getFollowers()
    {
        return $this->getValueForPath('followers');
    }    

    public function getName()
    {
        return $this->getValueForPath('name');
    }

    public function getPagination()
    {
        return $this->getValueForPath('pagination');
    }

    public function getViewCount($level = null)
    {
        return $this->getValueForPath('viewCount', $level);
    }

    public function getCommentCount($level = null)
    {
        return $this->getValueForPath('commentCount', $level);
    }

    public function getLikeCount($level = null)
    {
        return $this->getValueForPath('likeCount', $level);
    }

    public function getShareCount($level = null)
    {
        return $this->getValueForPath('shareCount', $level);
    }

    public function getSubscriberCount($level = null)
    {
        return $this->getValueForPath('subscriberCount', $level);
    }

    public function getPostCount($level = null)
    {
        return $this->getValueForPath('postCount', $level);
    }

    public function getItems($level = null)
    {
        return $this->getValueForPath('items', $level);
    }

    public function getItemName($level = null)
    {
        return $this->getValueForPath('item_name', $level);
    }

    public function getError()
    {
        return $this->getValueForPath('error');
    }

    /**
     * Get the configured paths.
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Configure the paths.
     *
     * @param array $paths
     */
    public function setPaths(array $paths)
    {
        $this->paths = array_merge($this->paths, $paths);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getPath($name)
    {
        return array_key_exists($name, $this->paths) ? $this->paths[$name] : null;
    }

    /**
     * Extracts a value from the response for a given path.
     *
     * @param string $path Name of the path to get the value for
     *
     * @return null|string
     */
    protected function getValueForPath($path, $level = null)
    {
        $response = $this->response;
        if (!$response) {
            return null;
        }

        $steps = $this->getPath($path);
        if (!$steps) {
            return null;
        }

        if ($level) {
            $steps = preg_replace("|(\d+)|", $level, $steps);
        }

        if (is_array($steps)) {
            if (1 === count($steps)) {
                return $this->getValue(current($steps), $response);
            }

            $value = array();
            foreach ($steps as $step) {
                $value[] = $this->getValue($step, $response);
            }

            $value = trim(implode(' ', $value));

            return $value ? : null;
        }

        return $this->getValue($steps, $response);
    }


    /**
     * @param string $steps
     * @param array $response
     *
     * @return null|string
     */
    private function getValue($steps, array $response)
    {
        $value = $response;
        $steps = explode('.', $steps);
        foreach ($steps as $step) {
            if (!array_key_exists($step, $value)) {
                return null;
            }

            $value = $value[$step];
        }

        return $value;
    }
}
