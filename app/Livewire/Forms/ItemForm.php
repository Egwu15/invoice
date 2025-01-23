<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Item;


class ItemForm extends Form
{



    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|numeric')]
    public $amount = '';

    #[Validate('string|max:255')]
    public $description = '';

    #[Validate('nullable|image|max:3024')]
    public $image;

    public $business_id = '';

    public $item_type_id;




    public function createItem()
    {
        $this->validate();
        $this->storeImage();
    }

    public function setItem(Item $item)
    {
        $this->name = $item->name;
        $this->amount = $item->amount;
        $this->description = $item->description;
        $this->business_id = $item->business_id;
        $this->item_type_id = $item->item_type_id;
        $this->image = $item->image;
    }

    public function storeImage()
    {
        if ($this->image) {
            $this->image = $this->image->store('product_images', 'public');
        }
    }
}
