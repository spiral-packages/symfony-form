<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Extension\HttpFoundation;

use Psr\Http\Message\UploadedFileInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\RequestHandlerInterface;

class ArrayRequestHandler implements RequestHandlerInterface
{
    public function handleRequest(FormInterface $form, mixed $request = null): void
    {
        if (!\is_array($request)) {
            throw new UnexpectedTypeException($request, 'array');
        }

        $name = $form->getName();
        $method = $form->getConfig()->getMethod();

        if ('' === $name) {
            $data = $request;
        } elseif (\array_key_exists($name, $request)) {
            $default = $form->getConfig()->getCompound() ? [] : null;
            $data = $request[$name] ?? $default;
        } else {
            // Don't submit the form if it is not present in the request
            return;
        }

        // Don't auto-submit the form unless at least one field is present.
        if ('' === $name && \count(\array_intersect_key($data ?? [], $form->all())) <= 0) {
            return;
        }

        $form->submit($data, 'PATCH' !== $method);
    }

    public function isFileUpload(mixed $data): bool
    {
        return $data instanceof UploadedFileInterface;
    }
}
