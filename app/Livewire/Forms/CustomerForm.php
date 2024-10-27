<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{


    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('email')]
    public $email = '';

    #[Validate('min:10')]
    public $phone = '';

    #[Validate('string')]
    public $address = '';

    #[Validate('string|max:255')]
    public $note = '';

    public function createCustomer()
    {
        $this->validate([
            'email' => 'unique:customers,email',
        ]);

        $this->validate();
    }

    public function setCustomer(Customer $customer)
    {
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->note = $customer->note;
    }
}
