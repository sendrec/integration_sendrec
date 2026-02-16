<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Reference;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCA\IntegrationSendrec\Service\SendRecAPIService;
use OCP\Collaboration\Reference\ADiscoverableReferenceProvider;
use OCP\Collaboration\Reference\ISearchableReferenceProvider;
use OCP\Collaboration\Reference\Reference;
use OCP\IL10N;
use OCP\IURLGenerator;

class SendRecReferenceProvider extends ADiscoverableReferenceProvider implements ISearchableReferenceProvider {
    public function __construct(
        private SendRecAPIService $apiService,
        private IURLGenerator $urlGenerator,
        private IL10N $l10n,
    ) {
    }

    public function getId(): string {
        return 'integration_sendrec-video';
    }

    public function getTitle(): string {
        return $this->l10n->t('SendRec Videos');
    }

    public function getOrder(): int {
        return 10;
    }

    public function getIconUrl(): string {
        return $this->urlGenerator->getAbsoluteURL(
            $this->urlGenerator->imagePath(Application::APP_ID, 'sendrec.svg')
        );
    }

    public function getSupportedSearchProviderIds(): array {
        return ['integration_sendrec-search'];
    }

    public function matchReference(string $referenceText): bool {
        $instanceUrl = $this->apiService->getInstanceUrl();
        if ($instanceUrl === '') {
            return false;
        }
        return preg_match(
            '#^' . preg_quote($instanceUrl, '#') . '/watch/[a-zA-Z0-9]+$#',
            $referenceText
        ) === 1;
    }

    public function resolveReference(string $referenceText): ?Reference {
        if (!$this->matchReference($referenceText)) {
            return null;
        }

        $shareToken = basename($referenceText);
        $data = $this->apiService->getOEmbed($shareToken);
        if ($data === null) {
            return null;
        }

        $reference = new Reference($referenceText);
        $reference->setTitle($data['title'] ?? 'SendRec Video');

        $duration = $data['duration'] ?? 0;
        $minutes = intdiv($duration, 60);
        $seconds = $duration % 60;
        $description = sprintf('%s · %d:%02d', $data['authorName'] ?? '', $minutes, $seconds);
        $reference->setDescription($description);

        if (!empty($data['thumbnailUrl'])) {
            $reference->setImageUrl($data['thumbnailUrl']);
        }

        $reference->setRichObject('integration_sendrec_video', [
            'title' => $data['title'] ?? '',
            'duration' => $duration,
            'authorName' => $data['authorName'] ?? '',
            'thumbnailUrl' => $data['thumbnailUrl'] ?? '',
            'watchUrl' => $data['watchUrl'] ?? $referenceText,
            'createdAt' => $data['createdAt'] ?? '',
        ]);

        return $reference;
    }

    public function getCachePrefix(string $referenceId): string {
        return $referenceId;
    }

    public function getCacheKey(string $referenceId): ?string {
        return $referenceId;
    }
}
