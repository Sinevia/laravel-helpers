<?php

namespace Sinevia\LaravelHelpers;

class Ui {

    public static function formValidate($fields) {
        $rules = [];
        foreach ($fields as $field) {
            $type = trim($field['type'] ?? null);
            $name = trim($field['name'] ?? null);
            $rule = trim($field['rule'] ?? null);
            if ($name == "") {
                continue;
            }
            if ($type == "") {
                continue;
            }
            if ($rule == "") {
                continue;
            }
            $rules[$name] = $rule;
        }

        if (count($rules) < 1) {
            return true;
        }

        $validator = \Validator::make(\Request::all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    public static function formBuild($fields, $options = []) {
        $formAction = $options['form.action'] ?? 'POST';
        $formButtonsTop = $options['form.buttons.top'] ?? 'yes';
        $formButtonsBottom = $options['form.buttons.bottom'] ?? 'yes';
        $formCsrfField = $options['form.csrf.field'] ?? 'yes';
        $buttonApplyIcon = $options['button.apply.icon'] ?? '';
        $buttonApplyText = $options['button.apply.text'] ?? 'Apply';
        $buttonApplyShow = $options['button.apply.show'] ?? 'no';
        $buttonSaveIcon = $options['button.save.icon'] ?? '';
        $buttonSaveText = $options['button.save.text'] ?? 'Save';
        $buttonSaveShow = $options['button.save.show'] ?? 'yes';
        $buttonCancelIcon = $options['button.cancel.icon'] ?? '';
        $buttonCancelText = $options['button.cancel.text'] ?? 'Cancel';
        $buttonCancelShow = $options['button.cancel.show'] ?? 'no';
        $buttonCancelLink = $options['button.cancel.link'] ?? '';
        $buttonCancelClick = $options['button.cancel.click'] ?? '';
        $hasApplyButton = $buttonApplyShow == 'yes';
        $hasCancelButton = $buttonCancelShow == 'yes';
        $hasSaveButton = $buttonSaveShow == 'yes';
        $hasButtons = ($hasApplyButton OR $hasCancelButton OR $hasSaveButton);
        $fieldFormActionId = 'id_' . uniqid();

        $csrfField = (new \Sinevia\Html\Input)
                ->setName('_token')
                ->setValue(csrf_token())
                ->setType(\Sinevia\Html\Input::TYPE_HIDDEN);

        $formActionField = (new \Sinevia\Html\Input)
                ->setId($fieldFormActionId)
                ->setName('form_action')
                ->setValue('save')
                ->setType(\Sinevia\Html\Input::TYPE_HIDDEN);

        $rowFields = (new \Sinevia\Html\Div)
                ->setClass('row');


        foreach ($fields as $field) {
            $type = trim($field['type'] ?? null);
            $name = trim($field['name'] ?? null);
            $value = $field['value'] ?? request($name, old($name));
            $options = $field['options'] ?? [];
            $disabled = $field['disabled'] ?? false;
            $readonly = $field['readonly'] ?? false;
            $label = $field['label'] ?? $name;
            $width = $field['width'] ?? 12;
            $html = trim($field['html'] ?? null); // for "html" fields only

            if ($type == 'html') {
                $rowFields->addChild($html);
                continue;
            }

            if ($name == "") {
                continue;
            }

            if ($type == "") {
                continue;
            }

            $value = request($name, old($name, $value));

            $formGroup = (new \Sinevia\Html\Div)->setClass('form-group float-left col-sm-' . $width);

            $label = (new \Sinevia\Html\Label)->addChild($label);

            $input = 'n/a';
            $hiddenInput = null; // For readonly selects only

            if ($type == 'password') {
                $input = (new \Sinevia\Html\Input)
                        ->setClass('form-control')
                        ->setName($name)
                        ->setValue($value)
                        ->setType('password');
            }

            if ($type == 'select') {
                $input = (new \Sinevia\Html\Select)
                        ->setClass('form-control')
                        ->setName($name);
                //->setValue($value);
                foreach ($options as $optionKey => $optionValue) {
                    $selected = $optionKey == $value ? true : false;
                    $input->item($optionKey, $optionValue, $selected);
                }
            }

            if ($type == 'text') {
                $input = (new \Sinevia\Html\Input)
                        ->setClass('form-control')
                        ->setName($name)
                        ->setValue($value);
            }

            if ($type == 'textarea') {
                $input = (new \Sinevia\Html\Textarea)
                        ->setClass('form-control')
                        ->setName($name)
                        ->setValue($value);
            }

            if (is_object($input) AND $disabled == true) {
                $input->setAttribute('disabled', 'disabled');
            }

            if (is_object($input) AND $readonly == true) {
                // Selects are different. Readonly for selects does not work.
                // Disable and create a hidden field
                if ($type == "select") {
                    $input->setAttribute('disabled', 'disabled');
                    $input->setName($name . '_Readonly');
                    $hiddenInput = (new \Sinevia\Html\Input())
                            ->setClass('form-control')
                            ->setName($name)
                            ->setValue($value)
                            ->setType('hidden');
                } else {
                    $input->setAttribute('readonly', 'readonly');
                }
            }

            $formGroup->addChild($label);
            $formGroup->addChild($input);
            if (is_null($hiddenInput) == false) {
                $formGroup->addChild($hiddenInput);
            }

            $rowFields->addChild($formGroup);
        }

        $rowButtons = (new \Sinevia\Html\Div)->setClass('row');
        $colButtons = (new \Sinevia\Html\Div)
                ->setClass('col-sm-12')
                ->setParent($rowButtons);

        // Button Save
        var_dump($hasSaveButton);
        if ($hasSaveButton) {
            if ($buttonSaveIcon != '') {
                $buttonSaveText = $buttonSaveIcon . ' ' . $buttonSaveText;
            }
            $buttonSave = (new \Sinevia\Html\Button())
                    ->setClass('btn btn-success button-save float-right')
                    ->setType('submit')
                    ->setText($buttonSaveText)
                    ->setOnClick("document.getElementById('$fieldFormActionId').value='save';");

            $colButtons->addChild($buttonSave);
        }
        
        // Button Apply
        var_dump($hasApplyButton);
        if ($hasApplyButton == 'yes') {
            if ($buttonApplyIcon != '') {
                $buttonApplyText = $buttonApplyIcon . ' ' . $buttonApplyText;
            }
            
            $buttonApply = (new \Sinevia\Html\Button())
                    ->setClass('btn btn-success button-apply float-right')
                    ->setType('submit')
                    ->setText($buttonApplyText)
                    ->setOnClick("document.getElementById('$fieldFormActionId').value='apply';");

            $colButtons->addChild($buttonApply);
        }        

        // Button Cancel
        var_dump($hasCancelButton);
        if ($hasCancelButton) {
            if ($buttonCancelIcon != '') {
                $buttonCancelText = $buttonCancelIcon . ' ' . $buttonCancelText;
            }
            $buttonCancel = (new \Sinevia\Html\Hyperlink())
                    ->setUrl($buttonCancelLink)
                    ->setClass('btn btn-success button-cancel')
                    ->setText($buttonCancelText);
            $colButtons->addChild($buttonCancel);
        }

        $form = (new \Sinevia\Html\Form)->setMethod($formAction);

        if ($hasButtons AND $formButtonsTop == 'yes') {
            $rowButtonsTop = clone($rowButtons);
            $rowButtonsTop->addClass('row-buttons');
            $rowButtonsTop->addClass('row-buttons-top');
            $form->addChild($rowButtonsTop);
        }

        $form->addChild($rowFields);

        if ($hasButtons AND $formButtonsBottom == 'yes') {
            $rowButtonsBottom = clone($rowButtons);
            $rowButtonsBottom->addClass('row-buttons');
            $rowButtonsBottom->addClass('row-buttons-bottom');
            $form->addChild($rowButtonsBottom);
        }

        // CSRF field
        if ($formCsrfField == 'yes') {
            $form->addChild($csrfField);
        }
        
        $form->addChild($formActionField);

        return $form;
    }
}
