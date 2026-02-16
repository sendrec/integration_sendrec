<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Service;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCP\Http\Client\IClientService;
use OCP\IConfig;
use Psr\Log\LoggerInterface;

class SendRecAPIService {
    public function __construct(
        private IClientService $clientService,
        private IConfig $config,
        private LoggerInterface $logger,
    ) {
    }

    public function getInstanceUrl(): string {
        return rtrim(
            $this->config->getAppValue(Application::APP_ID, 'instance_url', ''),
            '/'
        );
    }

    public function getApiKey(): string {
        return $this->config->getAppValue(Application::APP_ID, 'api_key', '');
    }

    public function getOEmbed(string $shareToken): ?array {
        $instanceUrl = $this->getInstanceUrl();
        if ($instanceUrl === '') {
            return null;
        }

        $client = $this->clientService->newClient();
        try {
            $response = $client->get(
                $instanceUrl . '/api/videos/' . urlencode($shareToken) . '/oembed',
                ['timeout' => 10]
            );
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $this->logger->debug('SendRec oEmbed request failed: ' . $e->getMessage());
            return null;
        }
    }

    public function searchVideos(string $query): array {
        $instanceUrl = $this->getInstanceUrl();
        $apiKey = $this->getApiKey();
        if ($instanceUrl === '' || $apiKey === '') {
            return [];
        }

        $client = $this->clientService->newClient();
        try {
            $response = $client->get(
                $instanceUrl . '/api/videos',
                [
                    'timeout' => 10,
                    'headers' => ['Authorization' => 'Bearer ' . $apiKey],
                    'query' => ['q' => $query, 'limit' => '20'],
                ]
            );
            return json_decode($response->getBody(), true) ?: [];
        } catch (\Exception $e) {
            $this->logger->debug('SendRec search request failed: ' . $e->getMessage());
            return [];
        }
    }
}
