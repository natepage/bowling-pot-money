<?php
declare(strict_types=1);

namespace App\Controller\Web\TurboFrame;

use App\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractTurboFrameController extends AbstractWebController
{
    private RequestStack $requestStack;

    #[Required]
    public function setRequestStack(RequestStack $requestStack): void
    {
        $this->requestStack = $requestStack;
    }

    protected function renderFrame(string $view, ?array $viewContext = null): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $frameId = $request->headers->get('Turbo-Frame');
        $frameContent = $this->renderView($view, $viewContext ?? []);

        return $this->render('web/layout_turbo_frame.html.twig', [
            'frameId' => $frameId,
            'frameContent' => $frameContent,
        ]);
    }
}
