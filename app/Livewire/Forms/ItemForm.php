<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Enums\DiscountTypeEnum;
use App\Models\Item;


class ItemForm extends Form
{

    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|numeric')]
    public $amount = '';

    #[Validate('string|max:255')]
    public $description = '';

    public $business_id = '';

    public $item_type_id;




    public function createItem()
    {
        $this->validate();
    }

    public function setItem(Item $item)
    {
        $this->name = $item->name;
        $this->amount = $item->amount;
        $this->description = $item->description;
        $this->business_id = $item->business_id;
        $this->item_type_id = $item->item_type_id;
    }
}
