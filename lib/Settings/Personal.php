<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Settings;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class Personal implements ISettings {
    public function __construct(
        private IConfig $config,
        private string $userId,
    ) {
    }

    public function getForm(): TemplateResponse {
        $params = [
            'search_enabled' => $this->config->getUserValue($this->userId, Application::APP_ID, 'search_enabled', '1') === '1',
            'link_preview_enabled' => $this->config->getUserValue($this->userId, Application::APP_ID, 'link_preview_enabled', '1') === '1',
        ];
        return new TemplateResponse(Application::APP_ID, 'personalSettings', $params);
    }

    public function getSection(): string {
        return 'connected-accounts';
    }

    public function getPriority(): int {
        return 10;
    }
}
