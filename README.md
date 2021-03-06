# Laravel Helpers

Helpers for laravel

## Link ##

## UI (User Interface) Helper ##

1. Define the form fields

```php
private function getFields($options = []) {
  $model = $options['model'] ?? null;
  $fields = [
      [
          'type' => 'html',
          'html' => '<style>.btn-success { width:100%; padding:10px;}</style>',
      ],
      [
          'type' => 'html',
          'html' => '<div class="col-sm-12"><h1>First Heading</h1></div>',
      ],
      [
          'type' => 'text',
          'name' => 'TextField',
          'label' => 'Text Field',
          'width' => 12,
          'rule' => 'required',
          'value' => is_null($model) ? null : '' . $model->TextField,
      ],
      [
          'type' => 'textarea',
          'name' => 'TextArea',
          'label' => 'Text Area',
          'width' => 12,
          'rule' => 'required',
          'value' => is_null($model) ? null : '' . $model->TextArea,
      ],
      [
          'type' => 'hidden',
          'name' => 'HiddenField',
          'label' => 'Hidden Field',
          'width' => 12,
          'rule' => 'required',
          'value' => is_null($model) ? null : '' . $model->HiddenField,
      ],
      [
          'type' => 'select',
          'name' => 'SelectField',
          'label' => 'Select Field',
          'options' => [''=>'','1'=>'1','2'=>'2',],
          'width' => 12,
          'rule' => 'required',
          'value' => is_null($model) ? null : '' . $model->SelectField,
      ],
  ];
  return $fields;
}
```

2. Build the form

```php
$form = \Sinevia\LaravelHelpers\Ui::formBuild($this->getFields(), [
      'button.apply.show' => 'yes',
      'button.cancel.show' => 'yes',
      'button.cancel.link' => '/back',
      'button.cancel.icon' => '<i class="fas fa-chevron-left"></i>',
      'button.apply.icon' => '<i class="fas fa-check"></i>',
      'button.save.icon' => '<i class="fas fa-save"></i>',
  ])
  ->toHtml();
```

3. Validate and save model

```php
$validOrErrorMessage = \Sinevia\LaravelHelpers\Ui::formValidate($this->formFields());
if ($validOrErrorMessage !== true) {
    return back()->withErrors($validOrErrorMessage)->withInput(request()->all());
}

$formValues = \App\Helpers\Ui::formFieldValues($this->getFields());
\App\Models\YourModel::unguard();
$yourModel = \App\Models\YourModel::create($formValues);

if(is_null($yourModel)){
    return back()->withErrors('Model creation failed')->withInput(request()->all());
}

if (request('form_action') == 'apply') {
    return redirect('/update?ModelId=' . $yourModel->Id]))
                    ->withSuccess('Model successfully created');
}

return redirect('/list')->withSuccess('Model successfully created');
```
