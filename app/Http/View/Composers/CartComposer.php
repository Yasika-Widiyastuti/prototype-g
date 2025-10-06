<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Http\Controllers\CheckoutController;

class CartComposer
{
    public function compose(View $view)
    {
        $view->with('globalCartCount', CheckoutController::getCartCount());
    }
}