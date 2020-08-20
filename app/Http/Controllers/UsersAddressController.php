<?php

namespace App\Http\Controllers;

use App\Address;
use App\Country;
use App\User;
use Illuminate\Http\Request;

class UsersAddressController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param \App\User                $user
     * @param \App\Address             $address
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function update(User $user, Address $address, Request $request)
    {
        return tap($address, function ($address) use ($request){
            $address->fill($request->only($this->getAddressFields()));
            $this->associateCountry($address, $request);

            $address->load('user');

            $address->save();
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\User                $user
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(User $user, Request $request)
    {
        //you might not have the country id available thats why we are pulling the country code

        ////look up the country
        //$country = Country::where('code', $request->country_code)->first();
        ////create an address
        //$address = new Address();
        ////fill
        //$address->fill($request->only('line_1'));
        ////associate country
        //$address->country()->associate($country);
        ////associate user
        //$address->user()->associate($user);
        ////save
        //$address->save();
        ////return
        //return $address;

        return tap($this->newAddressRequest($request), function ($address) use ($user) {
            $this->associateUser($address, $user);
        });

    }

    protected function newAddressRequest(Request $request)
    {
        $address = new Address($request->only($this->getAddressFields()));

        return tap($address, function ($address) use ($request) {
            $this->associateCountry($address, $request);
        });

    }

    protected function associateCountry(Address $address, Request $request)
    {
        $address->country()->associate($this->getCountryByCode($request->country_code));
    }
    protected function associateUser(Address $address, User $user)
    {
        $address->user()->associate($user);
    }

    protected function getCountryByCode($code)
    {
        return Country::where('code', $code)->first();
    }

    protected function getAddressFields()
    {
        return [
            'line_1',
        ];
    }

}
