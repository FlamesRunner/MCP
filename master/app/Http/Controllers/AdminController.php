<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isAdmin() {
        return (\Auth::user()->role == "admin");
    }

    public function userList() {
        if (!$this->isAdmin()) return redirect()->route('home');
        return view('adminUserList')->with('users', \App\User::get());
    }

    public function editUserPage($email) {
        if (!$this->isAdmin()) return redirect()->route('home');
        if (\App\User::where('email', $email)->count() == 0) {
            return redirect()->route('adminUserList');
        }
        return view('adminEditUser')->with('userData', \App\User::where('email', $email)->first());
    }

    public function editUser(Request $request, $email) {
        if (!$this->isAdmin()) return redirect()->route('home');
        if (\App\User::where('email', $email)->first()["role"] == "admin") {
                $request->session()->flash('message.level', 'warning');
            $request->session()->flash('message.content', 'The changes to the profile were not saved. You cannot modify administrative users.');
            return redirect()->route('adminUserList');
        }
        if (\App\User::where('email', $email)->count() == 0) {
            $request->session()->flash('message.level', 'warning');
            $request->session()->flash('message.content', 'The profile was not found.');
            return redirect()->route('adminUserList');
        }
        $request->validate([
            'name' => 'bail|required|min:3|max:255'
        ]);
        if (!empty($request->input('password'))) {
            if (strlen($request->input('password')) < 8 || strlen($request->input('password')) > 128) {
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'The password must be 8 to 128 characters long.');
                return redirect('/admin/profile/' . $email);
            } else {
                \App\User::where('email', $email)
                ->update(['password' => Hash::make($request->input('password'))]);
            }
        }
        \App\User::where('email', $email)
            ->update(['name' => $request->input('name')]);
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'The profile was updated successfully.');
        return redirect()->route('adminUserList');
    }

        public function userAct(Request $request) {
                if (!$this->isAdmin()) return redirect()->route('home');
                if (empty($request->input('email'))) {
                        $request->session()->flash('message.level', 'danger');
                        $request->session()->flash('message.content', 'Invalid request.');
                        return redirect()->route('adminUserList');
                }
                if ($request->input('action') == "terminate") {
                        if (\App\User::where('email', $request->input('email'))->first()->role == "admin") {
                                $request->session()->flash('message.level', 'danger');
                                $request->session()->flash('message.content', 'You cannot terminate administrative users.');
                        } else {
                                if (\App\MCServers::where('email', $request->input('email'))->count() !== 0) {
                                        $request->session()->flash('message.level', 'danger');
                                        $request->session()->flash('message.content', 'This user still manages servers on ' . env('APP_NAME') . '. Please remove them before terminating this user.');
                                } else {
                                        \App\User::where('email', $request->input('email'))->delete();
                                        $request->session()->flash('message.level', 'success');
                                        $request->session()->flash('message.content', 'The user was terminated.');
                                }
                        }
                } else if ($request->input('action') == "edit") {
				return redirect()->route('editUserPage', ['email' => $request->input('email')]);
        	   } else {
				$request->session()->flash('message.level', 'danger');
				$request->session()->flash('message.content', 'Not implemented.');
                }
                return redirect()->route('adminUserList');
    }

    public function index() {
                if (!$this->isAdmin()) return redirect()->route('home');
        return view('admin');
    }
}
 ?>
