<?php

namespace App\Widgets;

use App\Models\Invoice;
use DB;

use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class CurrentMonthIncomeDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Invoice::where('created_at','>=',date('Y-m').'-01 00:00:00')->sum('total');
        $string = 'month';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'fas fa-money-bill-alt fa-3x text-primary',
            'title'  => "This {$string} income is {$count}",
            'text'   => __('The current income this '.$string.' is '.$count.'. Click on button below to view all invoices.'),
            'button' => [
                'text' => __('View invoices'),
                'link' => route('voyager.invoice.index'),
            ],
            'image' => asset('storage/settings/widgets/CurrentMonthIncome.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return app('VoyagerAuth')->user()->can('browse', Voyager::model('User'));
    }
}
