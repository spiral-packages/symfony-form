<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Twig\Extension;

use Psr\Container\ContainerInterface;
use Spiral\Translator\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class TranslationExtension extends AbstractExtension
{
    public function __construct(
        private readonly ContainerInterface $container
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('trans', $this->trans(...)),
        ];
    }

    public function trans(
        string|\Stringable|null $message,
        array $arguments = [],
        string $domain = null,
        string $locale = null
    ): string {
        if ('' === $message = (string) $message) {
            return '';
        }

        if (!$this->container->has(TranslatorInterface::class)) {
            return $message;
        }

        return $this->container->get(TranslatorInterface::class)->trans($message, $arguments, $domain, $locale);
    }
}
