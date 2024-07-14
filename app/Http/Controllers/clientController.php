<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Rules\GstNumber;

class clientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::latest();

        if (!empty($request->get('search'))) {
            $clients = $clients->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('value', 'like', '%' . $request->get('search') . '%');
            });
        }

        $perPage = $request->get('perPage', 20);
        $clients = $clients->paginate($perPage);

        return view('client.index', compact('clients'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('client.create', compact('countries'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'business' => 'required',
            'contact' => 'required|numeric',
            'alter_contact' => 'nullable|numeric',
            'email' => 'nullable|email|max:255|string|unique:clients,email',
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable',
            'GST' => ['nullable', new GstNumber],
            'Address' => 'nullable',
            'notes' => 'nullable',
            'website' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = new Client();
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->business = $request->business;
        $client->contact = $request->contact;
        $client->alter_contact = $request->alter_contact;
        $client->email = $request->email;
        $client->country_id = $request->country;
        $client->state_id = $request->state;
        $client->city_id = $request->city;
        $client->postal_code = $request->postal_code;
        $client->GST = $request->GST;
        $client->Notes = $request->notes;
        $client->Address = $request->Address;
        $client->website = $request->website;
        $success = $client->save();
        if ($success) {
            Session::flash('success', 'Client Details Add Successfully!');
        } else {
            Session::flash('error', 'Client Details Add Failed!');
        }
        return redirect()->route('clients');
    }

    public function edit(Request $request, $id)
    {
        $client = Client::find($id);

        if (empty($client)) {
            Session::flash('error', 'No CLient found!');
            return redirect()->route('clients');
        }
        $countries = Country::all();
        return view('client.edit', compact('client', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (empty($client)) {
            $request->session()->flash('error', 'No CLient found!');
            return redirect()->route('clients');
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'business' => 'required',
            'contact' => 'required|numeric',
            'alter_contact' => 'nullable|numeric',
            'email' => 'nullable|email|max:255|string|unique:clients,email,' . $id,
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable',
            'GST' => ['nullable', new GstNumber],
            'Address' => 'nullable',
            'notes' => 'nullable',
            'website' => 'nullable|url',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->business = $request->business;
        $client->contact = $request->contact;
        $client->alter_contact = $request->alter_contact;
        $client->email = $request->email;
        $client->country_id = $request->country;
        $client->state_id = $request->state;
        $client->city_id = $request->city;
        $client->postal_code = $request->postal_code;
        $client->GST = $request->GST;
        $client->Notes = $request->notes;
        $client->Address = $request->Address;
        $client->website = $request->website;
        $success = $client->save();
        if ($success) {
            Session::flash('success', 'Client Details Updated Successfully!');
        } else {
            Session::flash('error', 'Client Details Updated Successfully!');
        }
        return redirect()->route('clients');
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if (empty($client)) {
            Session::flash('error', 'No CLient found!');
            return redirect()->route('clients');
        }
        $client->delete();
        Session::flash('success', 'Client Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Client Deleted Successfully'
        ]);
    }

    public function show($id)
    {
        $client = Client::find($id);
        if (empty($client)) {
            Session::flash('error', 'No Client Found!');
            return redirect()->back();
        }
        $country = Country::find($client->country_id);
        $state = State::find($client->state_id);
        $city = City::find($client->city_id);
        return view('client.show', compact('client', 'country', 'state', 'city'));
    }
}
