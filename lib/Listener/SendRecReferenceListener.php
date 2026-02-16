<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Listener;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCP\Collaboration\Reference\RenderReferenceEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Util;

/** @implements IEventListener<RenderReferenceEvent> */
class SendRecReferenceListener implements IEventListener {
    public function handle(Event $event): void {
        if (!$event instanceof RenderReferenceEvent) {
            return;
        }
        Util::addScript(Application::APP_ID, Application::APP_ID . '-reference');
    }
}
