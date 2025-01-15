<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickAccessWidget extends Widget

{
    protected static string $view = 'filament.widgets.quick-access-widget';

    public function registerCustomer()
    {
        return redirect('/admin/users/create');
    }

    public function registerBarber()
    {
        return redirect('/admin/barber-users');
    }

    //ISI PAGE ONLY
    public function addBarber()
    {
        return redirect('/admin/barbers/create');
    }

    public function addService()
    {
        return redirect('/admin/services/create');
    }

    public function addTren()
    {
        return redirect('/admin/trens/create');
    }
}
