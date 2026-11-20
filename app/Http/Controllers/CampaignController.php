<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index() {
         $search = request()->get('search', null);
        $withTrashed = request()->get('withTrashed', false);


        return view('campaigns.index', [
            'campaigns' => Campaign::query()
                ->when($withTrashed, fn (Builder $query) => $query->withTrashed())
                ->when($search, fn (Builder $query) => $query
                ->where('name', 'like', "%$search%")
                ->orWhere('id', '=', $search)
            )
            ->paginate(5)
            ->appends(compact('search')),
                'search' => $search,
                'withTrashed' => $withTrashed,
        ]);
    }
}
