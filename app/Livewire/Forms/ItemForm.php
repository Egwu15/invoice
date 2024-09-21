<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Enums\DiscountTypeEnum;
use App\Models\Item;


class ItemForm extends Form
{

    //'name',  // 'amount',  // 'quantity',  // 'description',  // 'business_id',    
    //'tax_rate', // 'discount_value',  // 'discount_type_id',  // 'item_type_id',
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|numeric')]
    public $amount = '';

    #[Validate('numeric')]
    public $quantity = '';

    #[Validate('string|max:255')]
    public $description = '';

    public $business_id = '';

    #[Validate('numeric|max:100')]
    public $tax_rate = 0;

    public $discount_type_id =  DiscountTypeEnum::PERCENTAGE->value;

    #[Validate('numeric')]
    public $discount_value = 0;

    public $item_type_id;

    private $max_percentage = 100;



    public function createItem()
    {
        if ($this->discount_type_id == DiscountTypeEnum::PERCENTAGE->value && $this->discount_value > $this->max_percentage) {
            $this->addError('discount_value', 'Discount value must be a percentage');
            return;
        }
        $this->validate();
    }

    public function setItem(Item $item)
    {
        $this->name = $item->name;
        $this->amount = $item->amount;
        $this->quantity = $item->quantity;
        $this->description = $item->description;
        $this->business_id = $item->business_id;
        $this->tax_rate = $item->tax_rate;
        $this->discount_value = $item->discount_value;
        $this->discount_type_id = $item->discount_type_id;
        $this->item_type_id = $item->item_type_id;
    }
}
