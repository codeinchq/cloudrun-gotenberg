<?php
/******************************************************************************
 * Copyright (c) 2020 Code Inc. - All Rights Reserved                         *
 * Unauthorized copying of this file, via any medium is strictly prohibited   *
 * Proprietary and confidential                                               *
 * Written by Joan Fabrégat <joan@codeinc.co>, 12/2020                        *
 * Visit https://www.codeinc.co for more information                          *
 ******************************************************************************/

declare(strict_types=1);

namespace CodeInc\CloudrunGotenberg;

use CodeInc\CloudrunAuthHttpClient\HttpClientFactory;
use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Exceptions\NativeFunctionErrored;
use Gotenberg\Exceptions\NoOutputFileInResponse;
use Gotenberg\Gotenberg;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Gotenberg client for Google Cloud Run. Modeled after the Gotenberg class.
 *
 * @see https://cloud.google.com/run/docs/authenticating/service-to-service#set-up-sa
 */
final readonly class CloudRunGotenberg
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(private ClientInterface $httpClient)
    {
    }

    /**
     * @param string $cloudRunServiceUrl
     * @param string|array $serviceAccountJsonKey
     * @return self
     */
    public static function fromUrlAndJsonKey(string $cloudRunServiceUrl, string|array $serviceAccountJsonKey): self
    {
        return new self(
            (new HttpClientFactory())->factory(
                jsonKey: $serviceAccountJsonKey,
                serviceUrl: $cloudRunServiceUrl
            )
        );
    }

    /**
     * Sends a request to Gotenberg and throws an exception if the status code
     * is not 200.
     *
     * @alias Gotenberg::send()
     * @throws GotenbergApiErrored
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        return Gotenberg::send($request, $this->httpClient);
    }

    /**
     * Handles a request to Gotenberg and saves the output file if any.
     * On success, returns the filename based on the 'Content-Disposition' header.
     *
     * @alias Gotenberg::save()
     * @throws GotenbergApiErrored
     * @throws NoOutputFileInResponse
     * @throws NativeFunctionErrored
     */
    public function save(RequestInterface $request, string $dirPath): string
    {
        return Gotenberg::save($request, $dirPath, $this->httpClient);
    }
}