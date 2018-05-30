<?php
/**
 * Created by PhpStorm.
 * User: gnat
 * Date: 01/11/16
 * Time: 2:18 PM
 */

namespace NS\SimpleMDEBundle\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarkdownEditorType extends AbstractType
{

    protected $options
        = [
            'autofocus',
            'autosave',
            'blockStyles',
            'forceSync',
            'hideIcons',
            'indentWithTabs',
            'insertTexts',
            'lineWrapping',
            'parsingConfig',
            'placeholder',
            'previewRender',
            'promptURLs',
            'renderingConfig',
            'shortcuts',
            'showIcons',
            'spellChecker',
            'status',
            'styleSelectedText',
            'tabSize',
            'toolbar',
            'toolbarTips'
        ];

    protected $config;

    /**
     * MarkdownEditorType constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->options as $option) {
            if (isset($options[$option])) {
                $builder->setAttribute($option, $options[$option]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        foreach ($this->options as $option) {
            if (isset($options[$option])) {
                $view->vars[$option] = $options[$option];
            }
        }
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        if (isset($this->config['hideIcons'])) {
            $resolver->setDefault('hideIcons', $this->config['hideIcons']);
        }

        if (isset($this->config['placeholder'])) {
            $resolver->setDefault('placeholder', $this->config['placeholder']);
        }

        if (isset($this->config['showIcons'])) {
            $resolver->setDefault('showIcons', $this->config['showIcons']);
        }

        if (isset($this->config['tabSize']) && $this->config['tabSize'] !== 2) {
            $resolver->setDefault('tabSize', $this->config['tabSize']);
        }

        foreach (['indentWithTabs', 'lineWrapping', 'spellChecker', 'styleSelectedText'] as $defaultTrueOption) {
            if (isset($this->config[$defaultTrueOption]) && $this->config[$defaultTrueOption] === false) {
                $resolver->setDefault($defaultTrueOption, false);
            }
        }

        foreach (['autofocus', 'forceSync', 'promptURLs'] as $defaultFalseOption) {
            if (isset($this->config[$defaultFalseOption]) && $this->config[$defaultFalseOption] === true) {
                $resolver->setDefault($defaultFalseOption, true);
            }
        }
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'simplemde_editor';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return TextareaType::class;
    }
}
