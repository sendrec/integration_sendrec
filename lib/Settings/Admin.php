<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Settings;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class Admin implements ISettings {
    public function __construct(
        private IConfig $config,
    ) {
    }

    public function getForm(): TemplateResponse {
        $params = [
            'instance_url' => $this->config->getAppValue(Application::APP_ID, 'instance_url', ''),
            'api_key' => $this->config->getAppValue(Application::APP_ID, 'api_key', ''),
        ];
        return new TemplateResponse(Application::APP_ID, 'adminSettings', $params);
    }

    public function getSection(): string {
        return 'connected-accounts';
    }

    public function getPriority(): int {
        return 10;
    }
}
