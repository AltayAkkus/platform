<?php declare(strict_types=1);

namespace Shopware\Core\System\Snippet\Filter;

/**
 * @package system-settings
 */
class TermFilter extends AbstractFilter implements SnippetFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'term';
    }

    /**
     * {@inheritdoc}
     */
    public function filter(array $snippets, $requestFilterValue): array
    {
        if (empty($requestFilterValue) || !\is_string($requestFilterValue)) {
            return $snippets;
        }

        $result = [];
        foreach ($snippets as $setId => $set) {
            foreach ($set['snippets'] as $translationKey => $snippet) {
                $keyMatch = mb_stripos($snippet['translationKey'], $requestFilterValue);
                $valueMatch = mb_stripos($snippet['value'], $requestFilterValue);
                
                if ($keyMatch === false && $valueMatch === false) {
                    continue;
                }

                $result[$setId]['snippets'][$translationKey] = $snippet;
            }
        }

        return $this->readjust($result, $snippets);
    }
}
