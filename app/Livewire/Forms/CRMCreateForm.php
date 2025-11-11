<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CRMCreateForm extends Form
{
    public $customerCode;

    #[Validate('required', message: 'Customer name Eng. field is required.')]
    public $customerNameEng;

    public $customerNameThi;

    #[Validate('required', message: 'Start visit date field is required.')]
    public $startVisit;

    #[Validate('required', message: 'Month estimate date field is required.')]
    public $monthEstimate;

    #[Validate('required', message: 'Customer type field is required.')]
    public $customerType;

    public $customerGroup;

    #[Validate('required', message: 'Contact field is required.')]
    public $contact;

    #[Validate('required', message: 'Purpose field is required.')]
    public $purpose;
}
