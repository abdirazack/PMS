<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Check if email is valid
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Send the email
        $recipient = $request->input('to');
        $subject = $request->input('subject');
        $message = $request->input('message');

        // Here, you can choose to check if the email address exists using an external service if needed.

        // Send the email
        try {
            Mail::to($recipient)->send(new SendMail($subject, $message));
            return redirect()->back()->with('status', 'Email sent successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Email not sent: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Email not sent!');
        }
    }
}
