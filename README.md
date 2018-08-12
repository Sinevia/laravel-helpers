# laravel-helpers

```php
$form = \Sinevia\Helpers\Ui::formBuild($this->getFields(), [
      'button.apply.show' => 'yes',
      'button.cancel.show' => 'yes',
      'button.cancel.link' => '/back',
      'button.cancel.icon' => '<i class="fas fa-chevron-left"></i>',
      'button.apply.icon' => '<i class="fas fa-check"></i>',
      'button.save.icon' => '<i class="fas fa-save"></i>',
  ])
  ->toHtml();
```
