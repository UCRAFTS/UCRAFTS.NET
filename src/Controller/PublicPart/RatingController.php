<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use App\Service\Ratings\RatingTypeCollection;
use App\Service\Ratings\RatingTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RatingController
 * @package App\Controller\PublicPart
 */
class RatingController extends AbstractController
{

    /**
     * @Route("/ratings/{type}", name="ratings", methods="GET")
     *
     * @param Request $request
     * @param RatingTypeCollection $ratings
     * @param string $type
     *
     * @return Response
     */
    public function index(Request $request, RatingTypeCollection $ratings, string $type): Response
    {
        /** @var RatingTypeInterface $rating */
        foreach ($ratings->getIterator() as $rating) {
            if ($rating->isSupport($type)) {
                return $rating->render($request);
            }
        }

        return $this->redirectToRoute('index');
    }
}
