<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\BoltFormsConfig\\:\\:getAdditionalFormConfigs\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/BoltFormsConfig.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\BoltFormsConfig\\:\\:getConfig\\(\\) return type with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/BoltFormsConfig.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\BoltFormsConfig\\:\\:getDefaults\\(\\) return type with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/BoltFormsConfig.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\BoltFormsConfig\\:\\:\\$config with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/BoltFormsConfig.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\BoltFormsEvent\\:\\:getData\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/BoltFormsEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\BoltFormsEvent\\:\\:setData\\(\\) has parameter \\$data with no type specified\\.$#',
	'identifier' => 'missingType.parameter',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/BoltFormsEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:__construct\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:addAttachments\\(\\) has parameter \\$attachments with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:getAttachments\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:getConfig\\(\\) return type with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:getForm\\(\\) return type with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:getFormConfig\\(\\) return type with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:getMeta\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEvent\\:\\:\\$attachments with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEvent.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEventDispatcher\\:\\:dispatch\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEventDispatcher.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEventDispatcher\\:\\:handle\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEventDispatcher.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\Event\\\\PostSubmitEventDispatcher\\:\\:\\$dispatchedForms with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Event/PostSubmitEventDispatcher.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\AbstractPersistSubscriber\\:\\:save\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/AbstractPersistSubscriber.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\AbstractPersistSubscriber\\:\\:save\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/AbstractPersistSubscriber.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TKey in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/AbstractPersistSubscriber.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TValue in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/AbstractPersistSubscriber.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\ContentTypePersister\\:\\:save\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\ContentTypePersister\\:\\:save\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\ContentTypePersister\\:\\:setContentData\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\ContentTypePersister\\:\\:setContentFields\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\ContentTypePersister\\:\\:setContentFields\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TKey in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 2,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TValue in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 2,
	'path' => __DIR__ . '/src/EventSubscriber/ContentTypePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\DbTablePersister\\:\\:parseForm\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\DbTablePersister\\:\\:parseForm\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\DbTablePersister\\:\\:parseForm\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\DbTablePersister\\:\\:save\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\DbTablePersister\\:\\:save\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\DbTablePersister\\:\\:saveToTable\\(\\) has parameter \\$fields with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TKey in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 2,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TValue in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 2,
	'path' => __DIR__ . '/src/EventSubscriber/DbTablePersister.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\FileUploadHandler\\:\\:getFilename\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\FileUploadHandler\\:\\:getFilename\\(\\) has parameter \\$formConfig with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\FileUploadHandler\\:\\:processFileField\\(\\) has parameter \\$field with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\FileUploadHandler\\:\\:processFileField\\(\\) has parameter \\$fieldConfig with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\FileUploadHandler\\:\\:uploadFiles\\(\\) has parameter \\$file with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\FileUploadHandler\\:\\:uploadFiles\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TKey in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TValue in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/FileUploadHandler.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\Redirect\\:\\:getRedirectResponse\\(\\) has parameter \\$redirect with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/Redirect.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\EventSubscriber\\\\Redirect\\:\\:makeUrl\\(\\) has parameter \\$redirect with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/Redirect.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\EventSubscriber\\\\Redirect\\:\\:\\$feedback with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/Redirect.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\EventSubscriber\\\\Redirect\\:\\:\\$formConfig with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/EventSubscriber/Redirect.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:create\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:create\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:create\\(\\) has parameter \\$formConfig with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:create\\(\\) has parameter \\$meta with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:\\$config with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:\\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:\\$formConfig with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Bolt\\\\BoltForms\\\\Factory\\\\EmailFactory\\:\\:\\$notification with generic class Illuminate\\\\Support\\\\Collection does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TKey in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TValue in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/EmailFactory.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldConstraints\\:\\:get\\(\\) has parameter \\$field with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldConstraints.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldConstraints\\:\\:get\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldConstraints.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldConstraints\\:\\:getClassFromArray\\(\\) has parameter \\$input with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldConstraints.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldConstraints\\:\\:getClassFromString\\(\\) has parameter \\$params with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldConstraints.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldOptions\\:\\:get\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldOptions.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldOptions\\:\\:get\\(\\) has parameter \\$field with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldOptions.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldOptions\\:\\:get\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldOptions.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Factory\\\\FieldType\\:\\:get\\(\\) has parameter \\$field with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Factory/FieldType.php',
];
$ignoreErrors[] = [
	'message' => '#^Class Bolt\\\\BoltForms\\\\Form\\\\ContenttypeType extends generic class Symfony\\\\Component\\\\Form\\\\AbstractType but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/ContenttypeType.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Form\\\\ContenttypeType\\:\\:getDefaultParams\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/ContenttypeType.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addCaptchaField\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addCaptchaField\\(\\) has parameter \\$field with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addCaptchaField\\(\\) has parameter \\$formBuilder with generic interface Symfony\\\\Component\\\\Form\\\\FormBuilderInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addField\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addField\\(\\) has parameter \\$field with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addField\\(\\) has parameter \\$formBuilder with generic interface Symfony\\\\Component\\\\Form\\\\FormBuilderInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addHoneypot\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:addHoneypot\\(\\) has parameter \\$formBuilder with generic interface Symfony\\\\Component\\\\Form\\\\FormBuilderInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:build\\(\\) has parameter \\$config with generic class Illuminate\\\\Support\\\\Collection but does not specify its types\\: TKey, TValue$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:build\\(\\) has parameter \\$data with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormBuilder\\:\\:build\\(\\) return type with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormBuilder.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormHelper\\:\\:get\\(\\) has parameter \\$form with generic interface Symfony\\\\Component\\\\Form\\\\FormInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/FormHelper.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormHelper\\:\\:get\\(\\) has parameter \\$values with no type specified\\.$#',
	'identifier' => 'missingType.parameter',
	'count' => 1,
	'path' => __DIR__ . '/src/FormHelper.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\FormRuntime\\:\\:run\\(\\) has parameter \\$data with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/FormRuntime.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TKey in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/FormRuntime.php',
];
$ignoreErrors[] = [
	'message' => '#^Unable to resolve the template type TValue in call to function collect$#',
	'identifier' => 'argument.templateType',
	'count' => 1,
	'path' => __DIR__ . '/src/FormRuntime.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Bolt\\\\BoltForms\\\\Honeypot\\:\\:addField\\(\\) has parameter \\$formBuilder with generic interface Symfony\\\\Component\\\\Form\\\\FormBuilderInterface but does not specify its types\\: TData$#',
	'identifier' => 'missingType.generics',
	'count' => 1,
	'path' => __DIR__ . '/src/Honeypot.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
