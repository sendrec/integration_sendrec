<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\AppInfo;

use OCA\IntegrationSendrec\Listener\SendRecReferenceListener;
use OCA\IntegrationSendrec\Reference\SendRecReferenceProvider;
use OCA\IntegrationSendrec\Search\SendRecSearchProvider;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\Collaboration\Reference\RenderReferenceEvent;

class Application extends App implements IBootstrap {
    public const APP_ID = 'integration_sendrec';

    public function __construct(array $urlParams = []) {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void {
        $context->registerSearchProvider(SendRecSearchProvider::class);
        $context->registerReferenceProvider(SendRecReferenceProvider::class);
        $context->registerEventListener(RenderReferenceEvent::class, SendRecReferenceListener::class);
    }

    public function boot(IBootContext $context): void {
    }
}
