<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/** @var string Role Admin **/
const ROLE_ADMIN = "admin";

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Function to check whether user is Admin or not.
     *
     * @return bool
     */
    private function isAdmin(): bool
    {
        return (\Auth::user()->role == self::ROLE_ADMIN);
    }

    /**
     * Function will return Admin Users list.
     *
     * @return mixed
     */
    public function userList()
    {
        if (!$this->isAdmin()) return redirect()->route('home');
        return view('adminUserList')->with('users', \App\User::get());
    }

    /**
     * Edit user page.
     *
     * @param string $email
     * @return mixed
     */
    public function editUserPage(string $email)
    {
        if (!$this->isAdmin()) return redirect()->route('home');
        if (\App\User::where('email', $email)->count() == 0) {
            return redirect()->route('adminUserList');
        }
        return view('adminEditUser')->with('userData', \App\User::where('email', $email)->first());
    }

    /**
     * Function to edit user.
     *
     * @param Request $request
     * @param string $email
     * @return mixed
     */
    public function editUser(Request $request, string $email)
    {
        if (!$this->isAdmin()) return redirect()->route('home');
        if (\App\User::where('email', $email)->first()["role"] == self::ROLE_ADMIN) {
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

    /**
     * Function User Activation.
     *
     * @param Request $request
     * @return mixed
     */
    public function userAct(Request $request)
    {
        if (!$this->isAdmin()) return redirect()->route('home');
        if (empty($request->input('email'))) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Invalid request.');
            return redirect()->route('adminUserList');
        }
        if ($request->input('action') == "terminate") {
            if (\App\User::where('email', $request->input('email'))->first()->role == self::ROLE_ADMIN) {
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

    /**
     * Admin page.
     *
     * @return mixed
     */
    public function index()
    {
        if (!$this->isAdmin()) return redirect()->route('home');
        return view('admin');
    }
}
