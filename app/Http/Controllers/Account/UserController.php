<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $user = User::with('role')->find(auth()->user()->id);
        return view('account/index', compact('user'));
    }

    public function edit(User $user)
    {
        return view('account/users/edit', compact('user'));
    }

    public function update(AccountUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect(route('account.main'))->with('status', 'Profile data was successfully updated!');
    }
}
