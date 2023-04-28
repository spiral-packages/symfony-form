<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Config;

use Spiral\Core\Container\Autowire;
use Spiral\Core\InjectableConfig;
use Spiral\Symfony\Form\Extension\HttpFoundation\SpiralRequestHandler;
use Spiral\Symfony\Form\Processor\ProcessorInterface;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\RequestHandlerInterface;

/**
 * @psalm-type TExtension = FormExtensionInterface|class-string<FormExtensionInterface>|Autowire<FormExtensionInterface>
 * @psalm-type TFormType = FormTypeInterface|class-string<FormTypeInterface>|Autowire<FormTypeInterface>
 * @psalm-type TProcessor = ProcessorInterface|class-string<ProcessorInterface>|Autowire<ProcessorInterface>
 *
 * @property array{
 *     theme: non-empty-string,
 *     request_handler: class-string<RequestHandlerInterface>,
 *     form_types: TFormType[],
 *     extensions: TExtension[],
 *     processors: TProcessor[]
 * } $config
 */
final class FormConfig extends InjectableConfig
{
    public const CONFIG = 'form';

    protected array $config = [
        'theme' => 'forms:bootstrap_5_layout.twig',
        'request_handler' => SpiralRequestHandler::class,
        'form_types' => [],
        'extensions' => [],
        'processors' => [],
    ];

    /**
     * @return non-empty-string
     */
    public function getTheme(): string
    {
        return $this->config['theme'];
    }

    /**
     * @psalm-return TFormType[]
     */
    public function getFormTypes(): array
    {
        return $this->config['form_types'];
    }

    /**
     * @return class-string<RequestHandlerInterface>
     */
    public function getRequestHandler(): string
    {
        return $this->config['request_handler'] ?? SpiralRequestHandler::class;
    }

    /**
     * @psalm-return TExtension[]
     */
    public function getExtensions(): array
    {
        return $this->config['extensions'];
    }

    /**
     * @psalm-return TProcessor[]
     */
    public function getProcessors(): array
    {
        return $this->config['processors'];
    }
}
