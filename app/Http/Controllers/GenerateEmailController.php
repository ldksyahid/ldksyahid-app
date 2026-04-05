<?php

namespace App\Http\Controllers;

use App\Jobs\SendGeneratedEmailJob;
use App\Models\TrSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'subject'       => 'required|string|max:255',
            'body'          => 'required|string',
            'recipient_type'=> 'required|in:subscribers,custom',
            'custom_emails' => 'required_if:recipient_type,custom|nullable|string',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
        ], [
            'subject.required'          => 'Subject is required.',
            'body.required'             => 'Email body is required.',
            'custom_emails.required_if' => 'Please enter at least one email address.',
            'attachments.*.mimes'       => 'Each attachment must be a PDF, Word, Excel, PowerPoint, or image file.',
            'attachments.*.max'         => 'Each attachment may not be larger than 10MB.',
        ]);

        if ($request->recipient_type === 'subscribers') {
            $emails = TrSubscription::where('flagActive', true)->pluck('email')->toArray();
            if (empty($emails)) {
                Alert::error('Error', 'No active subscribers found.');
                return redirect()->back()->withInput();
            }
        } else {
            $lines  = preg_split('/[\r\n,;]+/', $request->custom_emails);
            $emails = array_values(array_filter(array_map('trim', $lines), fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL)));
            if (empty($emails)) {
                Alert::error('Error', 'No valid email addresses found.');
                return redirect()->back()->withInput();
            }
        }

        $attachmentPaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('email-attachments');
            }
        }

        SendGeneratedEmailJob::dispatch(
            $request->subject,
            $request->body,
            $emails,
            $attachmentPaths
        )->delay(now()->addSeconds(3));

        $count = count($emails);
        Alert::success('Success', "Email queued to {$count} recipient(s).");
        return redirect()->route('admin.email-config.generate');
    }
}
