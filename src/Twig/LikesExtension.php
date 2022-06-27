<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Likes;

class LikesExtension extends AbstractExtension
{
    protected $doctrine;

    function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

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
            new TwigFunction('likeStatus', [$this, 'likeStatusFunction']),
        ];
    }

    public function likeStatusFunction($user, $publication_id)
    {
        $entityManager = $this->doctrine->getManager();
        $publication_repository = $entityManager->getRepository(Likes::class);

        $like_user = $publication_repository->findOneBy([
            'user' => $user,
            'publication' => $publication_id
        ]);

        if ($like_user != null && !empty($like_user) && is_object($like_user)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
