<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Controller;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;

class ConfigController extends Controller {
    public function __construct(
        string $appName,
        IRequest $request,
        private IConfig $config,
        private ?string $userId,
    ) {
        parent::__construct($appName, $request);
    }

    public function setAdminConfig(string $instanceUrl = '', string $apiKey = ''): DataResponse {
        $this->config->setAppValue(Application::APP_ID, 'instance_url', $instanceUrl);
        $this->config->setAppValue(Application::APP_ID, 'api_key', $apiKey);
        return new DataResponse(['status' => 'ok']);
    }

    /**
     * @NoAdminRequired
     */
    public function setPersonalConfig(bool $searchEnabled = true, bool $linkPreviewEnabled = true): DataResponse {
        $this->config->setUserValue($this->userId, Application::APP_ID, 'search_enabled', $searchEnabled ? '1' : '0');
        $this->config->setUserValue($this->userId, Application::APP_ID, 'link_preview_enabled', $linkPreviewEnabled ? '1' : '0');
        return new DataResponse(['status' => 'ok']);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index(): void {
        $instanceUrl = $this->config->getAppValue(Application::APP_ID, 'instance_url', '');
        if ($instanceUrl !== '') {
            header('Location: ' . $instanceUrl);
            exit;
        }
    }
}
