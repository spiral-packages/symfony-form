<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional\Bootloader;

use Spiral\Symfony\Form\Config\FormConfig;
use Spiral\Symfony\Form\Extension\DefaultExtensionsRegistry;
use Spiral\Symfony\Form\Extension\DefaultExtensionsRegistryInterface;
use Spiral\Symfony\Form\FormTypeProcessorRegistry;
use Spiral\Symfony\Form\FormTypeRegistry;
use Spiral\Symfony\Form\FormTypeRegistryInterface;
use Spiral\Symfony\Form\Extension\HttpFoundation\SpiralRequestHandler;
use Spiral\Symfony\Form\Processor\AttributeProcessor;
use Spiral\Symfony\Form\Processor\ConfigProcessor;
use Spiral\Symfony\Form\Tests\Functional\TestCase;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Form\FormFactoryBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\RequestHandlerInterface;

final class FormBootloaderTest extends TestCase
{
    public function testFormFactoryShouldBoundAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(FormFactoryInterface::class, FormFactory::class);
    }

    public function testFormFactoryBuilderShouldBoundAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(FormFactoryBuilderInterface::class, FormFactoryBuilder::class);
    }

    public function testDefaultExtensionsRegistryShouldBoundAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(DefaultExtensionsRegistryInterface::class, DefaultExtensionsRegistry::class);
    }

    public function testFormTypeRegistryShouldBoundAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(FormTypeRegistryInterface::class, FormTypeRegistry::class);
    }

    public function testRequestHandlerShouldBound(): void
    {
        $this->assertContainerBound(RequestHandlerInterface::class, SpiralRequestHandler::class);
    }

    public function testDefaultConfigShouldBeRegistered(): void
    {
        $config = $this->getConfig(FormConfig::CONFIG);

        $this->assertSame([
            'theme' => 'forms:bootstrap_5_layout.twig',
            'form_types' => [],
            'extensions' => [],
            'processors' => [
                AttributeProcessor::class,
                ConfigProcessor::class,
            ]
        ], $config);
    }

    public function testDefaultFormTypeProcessorsShouldBeRegistered(): void
    {
        /** @var FormTypeProcessorRegistry $registry */
        $registry = $this->getContainer()->get(FormTypeProcessorRegistry::class);

        $this->assertTrue($registry->isProcessed());

        $this->assertInstanceOf(AttributeProcessor::class, $registry->getProcessors()[0]);
        $this->assertInstanceOf(ConfigProcessor::class, $registry->getProcessors()[1]);
    }
}
