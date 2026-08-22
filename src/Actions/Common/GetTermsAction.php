<?php

declare(strict_types=1);

namespace Planka\Bridge\Actions\Common;

use Planka\Bridge\Contracts\Actions\ResponseResultInterface;
use Planka\Bridge\Contracts\Actions\ActionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Planka\Bridge\Views\Dto\Common\TermsDto;
use Planka\Bridge\Exceptions\ResponseException;

final class GetTermsAction implements ActionInterface, ResponseResultInterface
{
    public function __construct(private readonly ?string $language = null) {}

    public function url(): string
    {
        return 'api/terms';
    }

    public function getOptions(): array
    {
        if (null === $this->language) {
            return [];
        }

        return [
            'query' => [
                'language' => $this->language,
            ],
        ];
    }

    public function hydrate(ResponseInterface $response): TermsDto
    {
        $result = $response->toArray();
        $item = $result['item'] ?? null;

        if (!is_array($item)) {
            throw new ResponseException($response->getContent());
        }

        return new TermsDto(
            language: $item['language'] ?? '',
            content: $item['content'] ?? '',
            signature: $item['signature'] ?? '',
        );
    }
}
