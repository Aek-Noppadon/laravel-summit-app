<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CRMCreateForm extends Form
{
    #[Validate('required', message: 'Please provide a post title')]
    public $customerNameEng = '';
}
