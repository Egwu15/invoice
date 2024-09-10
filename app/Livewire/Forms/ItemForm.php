<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ItemForm extends Form
{

    //'name',  // 'amount',  // 'quantity',  // 'description',  // 'business_id',    
    //'tax_rate', // 'discount_value',  // 'discount_type_id',  // 'item_type_id',
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('numeric')]
    public $price = '';

    #[Validate('numeric')]
    public $quantity = '';

    #[Validate('string|max:255')]
    public $description = '';

    public function createItem()
    {
        $this->validate();
    }

    public function setItem($item)
    {
        $this->name = $item->name;
        $this->price = $item->price;
        $this->quantity = $item->quantity;
        $this->description = $item->description;
    }
}
