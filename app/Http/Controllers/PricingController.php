<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $pricing = [
            [
                'name'    => 'Personal (free)',
                'price'   => 'Free',
                'popular' => false,
                'features' => [
                    'Lifetime free',
                    'Generate Up to 5 Invoices/Month',
                    'Basic Invoice Templates',
                    'Automated Email Reminders',
                    'Community Support',
                    'For freelancers or hobbyists',
                ],
                'button'  => [
                    'text' => 'Sign Up for Free',
                    'link' => '/',
                ],
            ],
            [
                'name'    => 'Startup',
                'price'   => [
                    'monthly'  => '$19',
                    'annual'   => '$16',
                    'discount' => '10%',
                    'original' => '$24',
                ],
                'popular' => true,
                'features' => [
                    'All Free Features',
                    'Generate Up to 100 Invoices/Month',
                    'Advanced Customizable Templates',
                    'Multiple Payment Gateways',
                    'Priority Email & Chat Support',
                    'For growing small businesses',
                ],
                'button'  => [
                    'text' => 'Upgrade to Startup',
                    'link' => '#',
                ],
            ],
            [
                'name'    => 'Enterprise',
                'price'   => 'Custom',
                'popular' => false,
                'features' => [

                    'Unlimited Invoices & Users',
                    'Dedicated Infrastructure',
                    'Multi-Currency Support',
                    'Advanced Role-Based Access',
                    'Dedicated Account Manager',
                    '24/7 Phone & Chat Support',
                    'For large teams and enterprises',

                ],
                'button'  => [
                    'text' => 'Contact us',
                    'link' => '/contact',
                ],
            ],
        ];

        return view('pricing', compact('pricing'));
    }
}
