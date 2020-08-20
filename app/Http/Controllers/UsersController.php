<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \App\User
     */
    public function update(Request $request, User $user)
    {
        //update and return the user
        //you cant return the user immediatelly it gives bool

        return tap($user)->update($request->only('name'));
    }

}
