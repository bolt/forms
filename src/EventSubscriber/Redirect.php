<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Common\Str;
use Bolt\Log\LoggerTrait;
use Illuminate\Support\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Redirect implements EventSubscriberInterface
{
    use LoggerTrait;

    private PostSubmitEvent $event;
    private Collection $formConfig;
    private Collection $feedback;

    public function handleEvent(PostSubmitEvent $event): void
    {
        $this->event = $event;

        // Don't redirect, if the form isn't valid
        if (! $this->event->getForm()->isValid()) {
            return;
        }

        $this->formConfig = $this->event->getFormConfig();
        $this->feedback = new Collection($this->formConfig->get('feedback'));
        if ($this->feedback->get('redirect')) {
            $this->redirect();
        }
    }

    public function redirect(): void
    {
        if (isset($this->formConfig->get('submission')['ajax']) && $this->formConfig->get('submission')['ajax']) {
            return;
        }

        if (isset($this->feedback->get('redirect')['target']) && ! empty($this->feedback->get('redirect')['target'])) {
            $response = $this->getRedirectResponse($this->feedback->get('redirect'));

            $response->send();
            return;
        }

        throw new HttpException(Response::HTTP_FOUND, '', null, []);
    }

    protected function getRedirectResponse(array $redirect): RedirectResponse
    {
        $url = $this->makeUrl($redirect);

        return new RedirectResponse($url);
    }

    private function makeUrl(array $redirect): string
    {
        $parsedUrl = parse_url((string) $redirect['target']);

        // Special case, if redirecting to 'self', get the current URL and return it
        if ($redirect['target'] == 'self') {
            return $this->event->getMeta()['path'];
        }

        // parse_str returns result in `$query` ¯\_(ツ)_/¯
        parse_str($parsedUrl['query'] ?? '', $query);

        if (isset($this->formConfig['feedback']['redirect']['query'])) {
            foreach ($this->formConfig['feedback']['redirect']['query'] as $key) {
                if ($this->event->getForm()->has($key)) {
                    $query[$key] = $this->event->getForm()->get($key)->getNormData();
                }
            }
        }

        $url = Str::splitFirst($redirect['target'], '?') . '?' . http_build_query($query);

        if ((mb_strpos($url, 'http') === 0) || (mb_strpos($url, '#') === 0)) {
            return $url;
        }

        return '/' . mb_ltrim($url, '/');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'boltforms.post_submit' => ['handleEvent', 5],
        ];
    }
}
