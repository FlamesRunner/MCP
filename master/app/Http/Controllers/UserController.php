<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update (Request $request) {
        $request->validate([
            	'name' => 'bail|required|min:3|max:255'
            ]);
            if (!empty($request->input('password'))) {
                if (strlen($request->input('password')) < 8 || strlen($request->input('password')) > 128) {
                    $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Your password must be 8 to 128 characters long.');
            return redirect()->route('profile');
                } else {
                    \App\User::where('email', \Auth::user()->email)
                    ->update(['password' => Hash::make($request->input('password'))]);
                }
            }
            \App\User::where('email', \Auth::user()->email)
                ->update(['name' => $request->input('name')]);
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Your profile was updated successfully.');
            return redirect()->route('profile');
    }

    public function updatePage () {
        return view('profile');
    }
}
