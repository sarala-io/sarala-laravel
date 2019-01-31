<?php

declare(strict_types=1);

namespace Sarala\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class ApiException extends Exception implements JsonApiExceptionContract
{
    /**
     * Get unique identifier for this particular occurrence
     * of the problem.
     */
    public function id(): string
    {
        return '';
    }

    /**
     * Get application-specific error code.
     */
    public function code(): string
    {
        return '';
    }

    /**
     * Get human-readable explanation specific to this
     * occurrence of the problem.
     */
    public function detail(): string
    {
        return '';
    }

    /**
     * Get the URI that yield further details about this
     * particular occurrence of the problem.
     */
    public function href(): string
    {
        return '';
    }

    /**
     * Get associated resources, which can be dereferenced
     * from the request document.
     */
    public function links(): array
    {
        return [];
    }

    /**
     * Get relative path to the relevant attribute within
     * the associated resource(s).
     */
    public function path(): string
    {
        return '';
    }

    /**
     * Get non-standard meta-information about the error.
     */
    public function meta(): array
    {
        return [];
    }

    public function render(Request $request): JsonResponse
    {
        $data = [
            'status' => (string) $this->status(),
            'title' => (string) $this->title(),
        ];

        $data = array_merge($data, $this->getAvailableData());

        return response()
            ->json(['error' => $data], $this->status());
    }

    private function getAvailableData(): array
    {
        $data = [];

        collect(['links', 'meta', 'id', 'href', 'code', 'detail', 'path'])->each(function ($key) use (&$data) {
            if (! empty($this->{$key}())) {
                $data[$key] = $this->{$key}();
            }
        });

        return $data;
    }
}
