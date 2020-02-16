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

    /** @var FormFactory */
    private $formFactory;

    /** @var Environment */
    private $twig;

    public function __construct(ExtensionRegistry $extensionRegistry, Notifications $notifications, FormFactoryInterface $formFactory, Environment $twig)
    {
        $this->registry = $extensionRegistry;
        $this->notifications = $notifications;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
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

        $formBuilder = $this->formFactory->createBuilder();

        foreach($formConfig['fields'] as $name => $field) {
            $formBuilder->add($name,TextType::class);
        }

        $form = $formBuilder->getForm();

        return $this->twig->render('@boltforms/form.html.twig', [
            'formconfig' => $formConfig,
            'debug' => $config->get('debug'),
            'form' => $form->createView()
        ]);

    }
}