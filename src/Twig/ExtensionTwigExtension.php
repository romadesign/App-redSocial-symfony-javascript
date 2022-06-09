<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ExtensionTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
            new TwigFunction('tags_unique_items', [$this, 'tagsUniqueItems']),
        ];
    }

    public function doSomething($value)
    {
        // ...
    }

    public function tagsUniqueItems($tags)
    {
      foreach ($tags as $tag) {
        $tag_names[] = $tag->getName();
        $tags_names_unique = array_values(array_unique($tag_names));
      }
      return $tags_names_unique;
    }
}
