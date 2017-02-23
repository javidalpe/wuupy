<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Storage;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $response = \Stripe\Account::create(
                array(
                    "country" => $request->input('country'),
                    "managed" => true,
                    "tos_acceptance"=> [
                        "date"=> time(),
                        "ip"=> $request->ip(),
                        "user_agent"=> $request->header('User-Agent')
                    ],
                    "legal_entity"=> [
                        "type"=> $request->input('type'),
                        "first_name"=> $request->input('first_name'),
                        "last_name"=> $request->input('last_name'),
                        "dob"=> [
                            "day"=> $request->input('day'),
                            "month"=> $request->input('month'),
                            "year"=> $request->input('year'),
                        ]
                    ],
                    )
                );

                $account_id = $response['id'];

                \Stripe\Plan::create(array(
                    "amount" => config('plans.one'),
                    "interval" => "month",
                    "name" => "One dollar plan",
                    "currency" => "usd",
                    "id" => "one"
                ), array("stripe_account" => $account_id));

                \Stripe\Plan::create(array(
                    "amount" => config('plans.five'),
                    "interval" => "month",
                    "name" => "Five dollars plan",
                    "currency" => "usd",
                    "id" => "five"
                ), array("stripe_account" => $account_id));

                \Stripe\Plan::create(array(
                    "amount" => config('plans.ten'),
                    "interval" => "month",
                    "name" => "Ten dollars plan",
                    "currency" => "usd",
                    "id" => "ten"
                ), array("stripe_account" => $account_id));

                \Stripe\Plan::create(array(
                    "amount" => config('plans.twenty'),
                    "interval" => "month",
                    "name" => "Twenty dollars plan",
                    "currency" => "usd",
                    "id" => "twenty"
                ), array("stripe_account" => $account_id));

                $user->account_id = $account_id;
                $user->save();

                return redirect('/home#2');

            } catch (\Stripe\Error\Base $e) {
                return back()->with('error', $e->getMessage());
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        public function edit(Request $request)
        {
            $user = Auth::user();
            $account = null;

            if ($user->account_id) {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                $account = \Stripe\Account::retrieve($user->account_id);

                if (count($account['verification']['fields_needed']) <= 0)
                    return redirect('/home');
            }

            $data = [
                'user' => $user,
                'account' => $account,
            ];
            return view('monetize.account.verify', $data);
        }

        public function update(Request $request)
        {
            $user = Auth::user();
            $account = null;

            try {
                if ($user->account_id) {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                    $account = \Stripe\Account::retrieve($user->account_id);
                } else {
                    return back();
                }

                if ($request->has('personal_id_number')) {
                    $account->legal_entity->personal_id_number = $request->input('personal_id_number');
                }
                if ($request->has('ssn_last_4')) {
                    $account->legal_entity->ssn_last_4 = $request->input('ssn_last_4');
                }

                if ($request->has('address_city')) {
                    $account->legal_entity->address->city = $request->input('address_city');
                }
                if ($request->has('address_line1')) {
                    $account->legal_entity->address->line1 = $request->input('address_line1');
                }
                if ($request->has('address_postal_code')) {
                    $account->legal_entity->address->postal_code = $request->input('address_postal_code');
                }
                if ($request->has('address_state')) {
                    $account->legal_entity->address->state = $request->input('address_state');
                }

                if ($request->has('business_name')) {
                    $account->legal_entity->business_name = $request->input('business_name');
                }
                if ($request->has('business_tax_id')) {
                    $account->legal_entity->business_tax_id = $request->input('business_tax_id');
                }

                if ($request->has('personal_address_city')) {
                    $account->legal_entity->personal_address->city = $request->input('personal_address_city');
                }
                if ($request->has('personal_address_line1')) {
                    $account->legal_entity->personal_address->line1 = $request->input('personal_address_line1');
                }
                if ($request->has('personal_address_postal_code')) {
                    $account->legal_entity->personal_address->postal_code = $request->input('personal_address_postal_code');
                }
                if ($request->has('personal_address_state')) {
                    $account->legal_entity->personal_address->state = $request->input('personal_address_state');
                }

                if ($request->file('document')) {

                    $path = $request->document->store('documents');
                    $document = \Stripe\FileUpload::create(
                      array(
                        "purpose" => "identity_document",
                        "file" => Storage::get($path)
                      ),
                      array("stripe_account" => $user->account_id)
                    );

                    $account->legal_entity->verification->document = $document->id;
                }

                $account->save();
                return back();

            } catch (\Stripe\Error\Base $e) {
                return back()->with('error', $e->getMessage());
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }

        }
    }
