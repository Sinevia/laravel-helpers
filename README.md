# Laravel Helpers

Helpers for laravel

## UI (User Interface) Helper ##

```php
private function getFields() {
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
      ],
      [
          'type' => 'textarea',
          'name' => 'TextArea',
          'label' => 'Text Area',
          'width' => 12,
          'rule' => 'required',
      ],
      [
          'type' => 'hidden',
          'name' => 'HiddenField',
          'label' => 'Hidden Field',
          'width' => 12,
          'rule' => 'required',
      ],
      [
          'type' => 'select',
          'name' => 'SelectField',
          'label' => 'Select Field',
          'options' => [''=>'','1'=>'1','2'=>'2',],
          'width' => 12,
          'rule' => 'required',
      ],
  ];
  return $fields;
}
```

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
