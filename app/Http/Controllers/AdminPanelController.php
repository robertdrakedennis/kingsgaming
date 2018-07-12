<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);

        return view('back.main')->with([
            'users' => $users,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id)->get();

        return view()->with(
            ['user', $user]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id)->get();
        if($user->hasRole('User')) {
            toast('User is already a user?','error','top-right');
            return back()->withInput();

        } else
            toast('Demoted Successfully!','success','top-right');
            $user->assignRole('User');
        return redirect('admin.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function banFromEverything(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $admin = [
            '76561198068281815', //atlas
            '76561198058526102', //x2
            '76561198063801015' //uzi
        ];
        if(in_array($user->steamid, $admin)){
            return back();
        }
        else
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
        $user->assignRole('BannedFromEverything');
        toast('Banned successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function banFromPosting(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $admin = [
            '76561198068281815', //atlas
            '76561198058526102', //x2
            '76561198063801015' //uzi
        ];
        if(in_array($user->steamid, $admin)){
            return back();
        }
        else
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
        $user->assignRole('BannedFromPosting');
        toast('Banned successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unbanFromEverything(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $admin = [
            '76561198068281815', //atlas
            '76561198058526102', //x2
            '76561198063801015' //uzi
        ];
        if(in_array($user->steamid, $admin)){
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
            $user->assignRole('Administrator');
            return back();
        }
        else
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
        $user->assignRole('User');
        toast('Unbanned successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unbanFromPosting(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $admin = [
            '76561198068281815', //atlas
            '76561198058526102', //x2
            '76561198063801015' //uzi
        ];
        if(in_array($user->steamid, $admin)){
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
            $user->assignRole('Administrator');
            return back();
        }
        else
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
        $user->assignRole('User');
        toast('Unbanned successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setRoleAdministrator(Request $request, $id)
    {
        $user = User::findOrFail($id);
        foreach ($user->roles as $role) {
            $user->removeRole($role);
        }
        $user->assignRole('Administrator');
        toast('Promoted successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setRoleUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $admin = [
            '76561198068281815', //atlas
            '76561198058526102', //x2
            '76561198063801015' //uzi
        ];
        if(in_array($user->steamid, $admin)){
            toast('Can\'t demote this user..!','error','top-right');
            return back()->withInput();
        }
        else
            foreach ($user->roles as $role) {
                $user->removeRole($role);
            }
        $user->assignRole('User');
        toast('Demoted successfully!','success','top-right');
        return back();
    }

}
