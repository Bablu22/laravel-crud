<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ListingController extends Controller
{

    //Show all listings
    public function index()
    {
        $listings = Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6);

        return view('index', compact('listings'));
    }



    // Show single listing
    public function show($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            return view('show', [
                'listing' => $listing
            ]);
        } else {
            abort('404');
        }
    }

    // Show listing create form

    public function create()
    {

        return view('create');
    }


    // Store listing
    public function store(Request $request)
    {

        // dd($request->file('logo'));

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',

        ]);

        if ($request->hasFile('logo')) {

            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created success');
    }

    // Show edit Form
    public function edit(Listing $listing)
    {
        return view('edit', ['listing' => $listing]);
    }


    // Upadate
    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }


        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',

        ]);

        if ($request->hasFile('logo')) {

            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing Update success');
    }

    // Delete
    public function delete(Listing $listing)
    {
        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted success');

    }

    // Manage listings

    public function manage()
    {
        return view('manage', ['listings' => auth()->user()->listings()->get()]);
    }
}