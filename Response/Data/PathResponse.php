<?php

namespace SP\Bundle\DataBundle\Response\Data;

class PathResponse extends AbstractResponse
{
    /**
     * @var array
     */
    protected $paths = [
        'identifier' => null,
        'title' => null,
        'description' => null,
        'shortcode' => null,
        'link' => null,
        'thumbnail' => null,
        'publishedAt' => null,
        'userId' => null,
        'items' => null,
        'error' => null,
        'pagination' => null,
    ];

    public function getId($level = null)
    {
        return $this->getValueForPath('identifier', $level);
    }

    public function getPagination()
    {
        return $this->getValueForPath('pagination');
    }

    public function getTitle($level = null)
    {
        return $this->getValueForPath('title', $level);
    }

    public function getDescription($level = null)
    {
        return $this->getValueForPath('description', $level);
    }

    public function getLink($level = null)
    {
        return $this->getValueForPath('link', $level);
    }

    public function getUserId($level = null)
    {
        return $this->getValueForPath('userId', $level);
    }

    public function getThumbnail($level = null)
    {
        return $this->getValueForPath('thumbnail', $level);
    }

    public function getMedia($level = null)
    {
        return $this->getValueForPath('media', $level);
    }

    public function getPublishedAt($level = null)
    {
        return $this->getValueForPath('publishedAt', $level);
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

    public function getItems()
    {
        return $this->getValueForPath('items');
    }

    public function getShortCode($level = null)
    {
        return $this->getValueForPath('shortcode', $level);
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
     */
    public function setPaths(array $paths)
    {
        $this->paths = array_merge($this->paths, $paths);
    }

    /**
     * @param string $name
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
     * @return string|null
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
            $steps = preg_replace("|(\d+)|", $level, $steps, 1);
        }

        if (is_array($steps)) {
            if (1 === count($steps)) {
                return $this->getValue(current($steps), $response);
            }

            $value = [];
            foreach ($steps as $step) {
                $value[] = $this->getValue($step, $response);
            }

            $value = trim(implode(' ', $value));

            return $value ?: null;
        }

        return $this->getValue($steps, $response);
    }

    /**
     * @param string $steps
     *
     * @return string|null
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
