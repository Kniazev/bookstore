<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class PhoneValidation implements PhoneValidationInterface
{
    private string $url;
    private string $accessKey;
    private HttpClientInterface $httpClient;


    public function __construct(string $validatorUrl, string $accessKey, HttpClientInterface $httpClient)
    {
        $this->url = $validatorUrl;
        $this->accessKey = $accessKey;
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $phone
     * @return bool
     */
    public function isValid(string $phone): bool
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->url,
                [
                    'query' =>
                        [
                            'access_key' => $this->accessKey,
                            'number' => $phone,
                            'country_code' => '',
                            'format' => 1,
                        ]
                ]
            );

            $context = json_decode($response->getContent(), true);

            return $context['valid'];
        } catch (Exception $exception) {
            return false;
        }
    }
}
