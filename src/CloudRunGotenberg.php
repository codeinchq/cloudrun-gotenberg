<?php
/*
 * Copyright 2024 Code Inc. <https://www.codeinc.co>
 *
 * Use of this source code is governed by an MIT-style
 * license that can be found in the LICENSE file or at
 * https://opensource.org/licenses/MIT.
 */

declare(strict_types=1);

namespace CodeInc\CloudRunGotenberg;

use CodeInc\CloudrunAuthHttpClient\HttpClientFactory;
use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Exceptions\NativeFunctionErrored;
use Gotenberg\Exceptions\NoOutputFileInResponse;
use Gotenberg\Gotenberg;
use Gotenberg\Modules\Chromium;
use Gotenberg\Modules\LibreOffice;
use Gotenberg\Modules\PdfEngines;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Gotenberg client for Google Cloud Run. Modeled after the Gotenberg class.
 *
 * @see https://cloud.google.com/run/docs/authenticating/service-to-service#set-up-sa
 */
readonly class CloudRunGotenberg
{
    private ClientInterface $httpClient;

    /**
     * @param string $cloudRunServiceUrl
     * @param string|array $serviceAccountJsonKey
     * @param HttpClientFactory $clientFactory
     */
    public function __construct(
        private string $cloudRunServiceUrl,
        string|array $serviceAccountJsonKey,
        HttpClientFactory $clientFactory = new HttpClientFactory()
    ) {
        $this->httpClient = $clientFactory->factory(
            jsonKey: $serviceAccountJsonKey,
            serviceUrl: $cloudRunServiceUrl
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

    /**
     * @alias Gotenberg::chromium()
     * @return Chromium
     */
    public function chromium(): Chromium
    {
        return new Chromium($this->cloudRunServiceUrl);
    }

    /**
     * @alias Gotenberg::libreOffice()
     * @return LibreOffice
     */
    public function libreOffice(): LibreOffice
    {
        return new LibreOffice($this->cloudRunServiceUrl);
    }

    /**
     * @alias Gotenberg::pdfEngines()
     * @return PdfEngines
     */
    public function pdfEngines(): PdfEngines
    {
        return new PdfEngines($this->cloudRunServiceUrl);
    }
}