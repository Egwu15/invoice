<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $pricing = [
            [
                'name'    => 'Personal',
                'price'   => 'Free',
                'popular' => false,
                'features' => [
                    'Lifetime free',
                    'Up to 3 users',
                    'Unlimited Pages',
                    'Astro Sub domain',
                    'Basic Integrations',
                    'Community Support',
                ],
                'button'  => [
                    'text' => 'Get Started',
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
                    'Up to 20 users',
                    '20 Custom domains',
                    'Unlimited Collaborators',
                    'Advanced Integrations',
                    'Priority Support',
                ],
                'button'  => [
                    'text' => 'Get Started',
                    'link' => '#',
                ],
            ],
            [
                'name'    => 'Enterprise',
                'price'   => 'Custom',
                'popular' => false,
                'features' => [
                    'All Pro Features',
                    'Unlimited Custom domains',
                    '99.99% Uptime SLA',
                    'SAML & SSO Integration',
                    'Dedicated Account Manager',
                    '24/7 Phone Support',
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
