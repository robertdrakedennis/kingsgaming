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
            return redirect('admin.index');

        } else

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
        $user->assignRole('BannedFromEverything');
        return view('front.main');
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
        $user->assignRole('BannedFromPosting');
        return view('front.main');
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
        $user->assignRole('BannedFromEverything');
        return view('front.main');
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
        $user->assignRole('BannedFromPosting');
        return view('front.main');
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
        $user->assignRole('BannedFromPosting');
        return view('front.main');
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
        $user->assignRole('BannedFromPosting');
        return view('front.main');
    }

}
