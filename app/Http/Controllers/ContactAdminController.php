<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactAdminController extends Controller
{
    public function index()
    {
        return view('post.contacts.index', [
            'contacts' => Contact::latest()->paginate(10),
        ]);
    }

    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('post.contacts.show', compact('contact'));
    }
}
