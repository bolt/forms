<?php


namespace Bolt\BoltForms;

use Bolt\Extension\ExtensionRegistry;
use Bolt\Twig\Notifications;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Tightenco\Collect\Support\Collection;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class FormRuntime implements RuntimeExtensionInterface
{
    /** @var ExtensionRegistry */
    private $registry;

    /** @var Notifications */
    private $notifications;

    /** @var FormBuilder */
    private $builder;

    /** @var Environment */
    private $twig;

    public function __construct(ExtensionRegistry $extensionRegistry, Notifications $notifications, Environment $twig, FormBuilder $builder)
    {
        $this->registry = $extensionRegistry;
        $this->notifications = $notifications;
        $this->twig = $twig;
        $this->builder = $builder;
    }

    private function getConfig(): Collection
    {
        $extension = $this->registry->getExtension('BoltForms');

        return $extension->getConfig();
    }

    public function run(string $formName = '')
    {
        $config = $this->getConfig();

        if (! $config->has($formName)) {
            return $this->notifications->warning(
                'Incorrect usage of form',
                'The form "' . $formName . '" is not defined. '
            );
        }

        $formConfig = $config->get($formName);

        $form = $this->builder->build($formName, $formConfig);

        return $this->twig->render('@boltforms/form.html.twig', [
            'formconfig' => $formConfig,
            'debug' => $config->get('debug'),
            'form' => $form->createView()
        ]);

    }
}