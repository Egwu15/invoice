<?php

namespace App\Livewire\Forms;

use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BusinessForm extends Form
{
    #[validate('required|string')]
    public string $businessName = '';

    #[validate('required|string')]
    public string $businessType = '';

    #[Validate('required|string')]
    public string $email = '';

    #[Validate('string')]
    public string $phone_number = '';

    #[Validate('string')]
    public string $address = '';

    #[Validate('string')]
    public string $post_office_number = '';




    public function createBusiness()
    {

        $this->validate();


        $user = Auth::user();

        cache()->forget("user_{$user->id}_has_business");

        Business::create([
            'name' => $this->businessName,
            'user_id' => $user->id,
            'business_type' => $this->businessType,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'post_office_number' => $this->post_office_number,
        ]);
    }
}
