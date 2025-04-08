<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contacts = Contact::search($request)->latest()->orderBy('status', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reply($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.reply', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function sendReply(Request $request, $id)
{
    $request->validate([
        'reply_message' => 'required|string',
    ]);

    $contact = Contact::findOrFail($id);
    $replyMessage = $request->input('reply_message');

    // Gửi mail
    Mail::to($contact->email)->send(new ContactReplyMail($contact, $replyMessage));
    $contact->status = true;
    $contact->save();
    return redirect()->route('admin.contacts.index')->with('success', 'Phản hồi đã được gửi thành công!');
}

    /**
     * Remove the specified resource from storage.
     */
     /**
     * Xóa mềm một liên hệ
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Liên hệ đã được xóa.');
    }

    /**
     * Hiển thị danh sách liên hệ đã xóa mềm
     */
    public function trashed()
    {
        $contacts = Contact::onlyTrashed()->paginate(10);
        return view('admin.contacts.trashed', compact('contacts'));
    }

    /**
     * Khôi phục liên hệ đã bị xóa mềm
     */
    public function restore($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();

        return redirect()->route('admin.contacts.trashed')->with('success', 'Liên hệ đã được khôi phục.');
    }

    /**
     * Xóa vĩnh viễn một liên hệ
     */
    public function forceDelete($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();

        return redirect()->route('admin.contacts.trashed')->with('success', 'Liên hệ đã bị xóa vĩnh viễn.');
    }
}
