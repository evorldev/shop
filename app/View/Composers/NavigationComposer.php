<?php

namespace App\View\Composers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view): void
    {
        $menu = Menu::make()
            ->add(MenuItem::make(route('home'), 'Главная'))
            ->add(MenuItem::make(route('catalog'), 'Каталог товаров'))
            ->add(MenuItem::make('#', 'Корзина'));

        $mmenu = Menu::make()
            ->add(MenuItem::make(route('home'), 'Главная'))
            ->add(MenuItem::make(route('catalog'), 'Каталог товаров'))
            ->add(MenuItem::make('#', 'Мои заказы'))
            ->add(MenuItem::make('#', 'Корзина'));

        $view->with('menu', $menu);
        $view->with('mmenu', $mmenu);
    }
}
