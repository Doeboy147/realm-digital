<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Welcome extends Controller
{
    public function index()
    {
        $todayWishList = $this->birthDayWishList();
        return view('welcome', ['todayWishList' => $todayWishList]);
    }

    public function sendWishes()
    {
        $todayWishList = $this->birthDayWishList();
        $message = 'Happy Birthday ';

        if (empty($todayWishList) === false) {
            foreach ($todayWishList as $employee) {
                if (!in_array($employee['id'],$this->excludeEmployees(), true)) {
                    $message .= $employee['name'] . ' ';
                } else {
                    continue;
                }
            }
            $this->sendEmail($message, 'email@domail.com');
        } else {
            return redirect()->back()->with('error', 'Today birthday wish list is empty');
        }

        return redirect()->back()->with('success', 'Birthday wishes sent successfully');
    }

    protected function birthDayWishList()
    {
        $todayWishList = [];
        $employees     = $this->getEmployeesList();
        $todayDate     = Carbon::today()->toDateString();
        foreach ($employees  as $employee) {
            if ($this->validateEmployeeData($employee)) {
                if (is_null($employee['employmentEndDate']) && $employee['employmentStartDate'] < $todayDate) {
                    $dateOfBirth = date('m-d', strtotime($employee['dateOfBirth']));
                    if ($dateOfBirth == date('m-d', strtotime($todayDate))) {
                        $todayWishList[] = $employee;
                    }
                }
            } else {
                continue;
            }
        }
        return $todayWishList;
    }

    protected function validateEmployeeData($employee)
    {
        $valid          = false;
        $requiredFields = ['employmentEndDate', 'employmentStartDate', 'dateOfBirth'];

        foreach ($requiredFields as $field) {
            if (array_key_exists($field, $employee)) {
                $valid =  true;
            }
        }
        return $valid;
    }

    protected function sendEmail($message, $emailAddress)
    {
        Mail::send(['text' => 'mail'], $message, function ($mail) use ($emailAddress) {
            $mail->to($emailAddress)->subject('Happy Birthday :)');
            $mail->from('admin@lohdir.online', 'Realm Digital CEO');
        });
    }

    protected function getEmployeesList()
    {
        $response = Http::get('https://interview-assessment-1.realmdigital.co.za/employees');
        return $response->json();
    }

    protected function excludeEmployees()
    {
        $response = Http::get('https://interview-assessment-1.realmdigital.co.za/do-not-send-birthday-wishes');
        return $response->json();
    }
}
