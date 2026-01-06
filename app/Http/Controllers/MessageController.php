<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get list of users the current user has chatted with
        $conversations = Pesan::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->select(DB::raw('CASE WHEN sender_id = ' . $userId . ' THEN receiver_id ELSE sender_id END as contact_id'), DB::raw('MAX(created_at) as last_message_time'))
            ->groupBy('contact_id')
            ->orderBy('last_message_time', 'desc')
            ->get();

        $contacts = [];
        foreach ($conversations as $conv) {
            $contact = User::find($conv->contact_id);
            if ($contact) {
                $lastMsg = Pesan::where(function ($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id_users);
                })->orWhere(function ($q) use ($userId, $contact) {
                    $q->where('sender_id', $contact->id_users)->where('receiver_id', $userId);
                })->orderBy('created_at', 'desc')->first();

                $contact->last_message = $lastMsg;
                $contact->unread_count = Pesan::where('sender_id', $contact->id_users)
                    ->where('receiver_id', $userId)
                    ->where('is_read', 0)
                    ->count();
                $contacts[] = $contact;
            }
        }

        return view('messages.index', compact('contacts'));
    }

    public function show(User $user)
    {
        $userId = Auth::id();

        // Mark as read
        Pesan::where('sender_id', $user->id_users)
            ->where('receiver_id', $userId)
            ->update(['is_read' => 1]);

        $messages = Pesan::where(function ($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('receiver_id', $user->id_users);
        })->orWhere(function ($q) use ($userId, $user) {
            $q->where('sender_id', $user->id_users)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Get contacts list again for the sidebar in the view
        $conversations = Pesan::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->select(DB::raw('CASE WHEN sender_id = ' . $userId . ' THEN receiver_id ELSE sender_id END as contact_id'), DB::raw('MAX(created_at) as last_message_time'))
            ->groupBy('contact_id')
            ->orderBy('last_message_time', 'desc')
            ->get();

        $contacts = [];
        foreach ($conversations as $conv) {
            $contact = User::find($conv->contact_id);
            if ($contact) {
                $lastMsg = Pesan::where(function ($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id_users);
                })->orWhere(function ($q) use ($userId, $contact) {
                    $q->where('sender_id', $contact->id_users)->where('receiver_id', $userId);
                })->orderBy('created_at', 'desc')->first();
                $contact->last_message = $lastMsg;
                $contact->unread_count = Pesan::where('sender_id', $contact->id_users)->where('receiver_id', $userId)->where('is_read', 0)->count();
                $contacts[] = $contact;
            }
        }

        return view('messages.show', compact('user', 'messages', 'contacts'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
        ]);

        Pesan::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'pesan' => $request->pesan,
            'is_read' => 0,
        ]);

        return redirect()->route('messages.show', $request->receiver_id);
    }
}
