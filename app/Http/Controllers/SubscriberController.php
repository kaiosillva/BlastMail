<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList)
    {
        $search = request()->search;
        $showTrash = request()->get('showTrash', false);

        return view('subscriber.index', [
            'emailList' => $emailList,
            'subscribers' => $emailList->subscribers()
                ->when($showTrash, fn (Builder $query) => $query->withTrashed())
                ->when($search, fn (Builder $query) => $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', '=', "%$search%")
                )
                ->paginate()
                ->appends(compact('search')),
            'search' => $search,
            'showTrash' => $showTrash,
        ]);
    }

    public function create(EmailList $emailList)
    {
        return view('subscriber.create', compact('emailList'));
    }

    public function store(EmailList $emailList)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', Rule::unique('Subscribers')->where('email_list_id', $emailList)],
        ]);

        $emailList->subscribers()->create($data);
        return to_route('subscribers.index', $emailList)->with('mensagem', __('Subscriber successully created'));
    }

    public function destroy(mixed $list, Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('mensagem', __('Sudscriber deleted from the list!'));
    }
}
