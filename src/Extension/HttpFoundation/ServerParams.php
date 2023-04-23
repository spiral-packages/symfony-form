<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Extension\HttpFoundation;

use Spiral\Http\Request\InputManager;

class ServerParams
{
    public function __construct(
        protected readonly ?InputManager $input = null
    ) {
    }

    /**
     * Returns true if the POST max size has been exceeded in the request.
     */
    public function hasPostMaxSizeBeenExceeded(): bool
    {
        $contentLength = $this->getContentLength();
        $maxContentLength = $this->getPostMaxSize();

        return $maxContentLength && $contentLength > $maxContentLength;
    }

    /**
     * Returns maximum post size in bytes.
     */
    public function getPostMaxSize(): int|float|null
    {
        $iniMax = \strtolower($this->getNormalizedIniPostMaxSize());

        if ('' === $iniMax) {
            return null;
        }

        $max = \ltrim($iniMax, '+');
        if (\str_starts_with($max, '0x')) {
            $max = \intval($max, 16);
        } elseif (\str_starts_with($max, '0')) {
            $max = \intval($max, 8);
        } else {
            $max = (int) $max;
        }

        switch (\substr($iniMax, -1)) {
            case 't': $max *= 1024;
            // no break
            case 'g': $max *= 1024;
            // no break
            case 'm': $max *= 1024;
            // no break
            case 'k': $max *= 1024;
        }

        return $max;
    }

    /**
     * Returns the normalized "post_max_size" ini setting.
     */
    public function getNormalizedIniPostMaxSize(): string
    {
        return \strtoupper(\trim(\ini_get('post_max_size')));
    }

    /**
     * Returns the content length of the request.
     */
    public function getContentLength(): ?int
    {
        if (null !== $this->input) {
            return (int) $this->input->server->get('CONTENT_LENGTH');
        }

        return isset($_SERVER['CONTENT_LENGTH'])
            ? (int) $_SERVER['CONTENT_LENGTH']
            : null;
    }
}
