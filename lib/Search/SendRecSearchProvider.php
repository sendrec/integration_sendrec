<?php

declare(strict_types=1);

namespace OCA\IntegrationSendrec\Search;

use OCA\IntegrationSendrec\AppInfo\Application;
use OCA\IntegrationSendrec\Service\SendRecAPIService;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\Search\IProvider;
use OCP\Search\ISearchQuery;
use OCP\Search\SearchResult;
use OCP\Search\SearchResultEntry;

class SendRecSearchProvider implements IProvider {
    public function __construct(
        private SendRecAPIService $apiService,
        private IURLGenerator $urlGenerator,
        private IL10N $l10n,
    ) {
    }

    public function getId(): string {
        return 'integration_sendrec-search';
    }

    public function getName(): string {
        return $this->l10n->t('SendRec Videos');
    }

    public function getOrder(string $route, array $routeParameters): int {
        return 15;
    }

    public function search(IUser $user, ISearchQuery $query): SearchResult {
        $videos = $this->apiService->searchVideos($query->getTerm());
        $iconUrl = $this->urlGenerator->getAbsoluteURL(
            $this->urlGenerator->imagePath(Application::APP_ID, 'sendrec.svg')
        );

        $entries = [];
        foreach ($videos as $video) {
            $duration = $video['duration'] ?? 0;
            $minutes = intdiv($duration, 60);
            $seconds = $duration % 60;

            $entries[] = new SearchResultEntry(
                $video['thumbnailUrl'] ?? $iconUrl,
                $video['title'] ?? 'Untitled',
                sprintf('%d:%02d', $minutes, $seconds),
                $video['shareUrl'] ?? '',
                $iconUrl,
            );
        }

        return SearchResult::complete($this->getName(), $entries);
    }
}
