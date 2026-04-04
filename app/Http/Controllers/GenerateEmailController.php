<?php

namespace App\Http\Controllers;

use App\Jobs\SendGeneratedEmailJob;
use App\Models\TrSubscription;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GenerateEmailController extends Controller
{
    public function index()
    {
        return view('admin-page.email-config.generate.index')
            ->with('title', 'Generate Email');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject'        => 'required|string|max:255',
            'body'           => 'required|string',
            'recipient_type' => 'required|in:subscribers,custom',
            'custom_emails'  => 'required_if:recipient_type,custom|nullable|string',
        ], [
            'subject.required'        => 'Subject is required.',
            'body.required'           => 'Email body is required.',
            'custom_emails.required_if' => 'Please enter at least one email address.',
        ]);

        if ($request->recipient_type === 'subscribers') {
            $emails = TrSubscription::where('flagActive', true)->pluck('email')->toArray();

            if (empty($emails)) {
                Alert::error('Error', 'No active subscribers found.');
                return redirect()->back()->withInput();
            }
        } else {
            $lines  = preg_split('/[\r\n,;]+/', $request->custom_emails);
            $emails = array_values(array_unique(array_filter(array_map('trim', $lines))));

            // Filter invalid emails
            $emails = array_filter($emails, fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL));
            $emails = array_values($emails);

            if (empty($emails)) {
                Alert::error('Error', 'No valid email addresses found.');
                return redirect()->back()->withInput();
            }
        }

        SendGeneratedEmailJob::dispatch(
            $request->subject,
            $request->body,
            $emails
        )->delay(now()->addSeconds(3));

        $count = count($emails);
        Alert::success('Success', "Email queued to {$count} recipient(s).");
        return redirect()->route('admin.email-config.generate');
    }
}
