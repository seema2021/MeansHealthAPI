<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Contracts\Support;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase;

class ApiController extends Controller {

    public function index() {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->create();
        $db = $firebase->getDatabase();
        $db->getReference('config/website')->set([
            'id' => 1,
            'name' => 'neha',
            'email' => 'neha@gmail.com',
            'online' => 1,
        ]);
        echo '<h1>data has been Success</h1>';
    }

    public function Registration(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/users');
        $snapshot = $reference->getSnapshot();
        if ($admins = collect($snapshot->getValue())->where('email', '=', $request->email)) {
//            dd($admins);
            foreach ($admins as $admin)
                if ($admin['email'] = $request->email) {
                    $response = ['message' => "login"];
                    return response(['message' => "Duplicate Entry For Email Field"], 403);
                }
        } else
            $snapshot = $reference->getSnapshot();
        $users = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $users['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;

        $url = 'users/' . $neha;
        $db->getReference($url)
                ->set(['id' => $id + 1,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'nric' => $request->nric,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'password' => $request->password,
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'dob' => $request->dob,
        ]);
        $reference = $db->getReference($url);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();

        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'admin_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User New Registration',
        ]);


        return response($k1);
    }

    public function Faq(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/faq');
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function User(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/users');
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function AddQusetion(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/Qusetion');
        $snapshot = $reference->getSnapshot();
        $que = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $que['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $postData = [
            'id' => $id + 1,
            'question' => $request->question,
            'answer' => $request->answer,
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option4,
        ];
        $postRef = $db->getReference('question/')->push($postData);
        return response()->json(['db' => $firebase]);
    }

    public function Question(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/question');
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function AddFaq(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/faq');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'faq/' . $neha;
        $db->getReference($url)
                ->set(['id' => $id + 1,
                    'question' => $request->question,
                    'answer' => $request->answer,
        ]);
        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Admin Add New Faq System',
        ]);
        return response()->json(['db' => $firebase]);
    }

    public function AddAbout(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/abouts');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $postData = [
            'id' => $id + 1,
            'name' => $request->name,
            'header' => $request->header,
            'title' => $request->title,
        ];
        $notify = 'user_notification/' . $neha;
        $db->getReference($notify)
                ->set(['id' => $id + 1,
                    'title' => 'Admin Add New About',
                    'view' => 0,
        ]);
        $postRef = $db->getReference('abouts/')->push($postData);
        return response()->json(['db' => $firebase]);
    }

    public function About(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/abouts/-L2ZZ7uFWI4xPQxmSXHN');
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();

        return response()->json($k1);
    }

    public function userLogin(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/users');
        $snapshot = $reference->getSnapshot();
        if ($admins = collect($snapshot->getValue())->where('email', '=', $request->email)->where('password', '=', $request->password)) {
//            dd($admins);
            foreach ($admins as $admin)
                if ($admin['email'] = $request->email) {
                    $response = ['message' => "login"];
                    return response($admin, 200);
                } else
                    $response = ['message' => "Not Login"];
            return response(['message' => "Invalid Request"], 403);
        }
    }
    
    
    public function ForgetPass(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/users');
        $snapshot = $reference->getSnapshot();
        if ($admins = collect($snapshot->getValue())->where('email', '=', $request->email)) {
            foreach ($admins as $admin)
                if ($admin['email'] = $request->email) {
                    $otp = 'Your Means Health: ' . $admin['password'];
                    \Mail::raw($otp, function($message) use ($request) {
                    $message->to($request->email)->subject('Your MeansHealth Password');
                });
                    $response = ['message' => "login"];
                    return response(['message' => "Please check your email ! We have sent Your Password on your email"], 200);
                } else
                    $response = ['message' => "Not Login"];
            return response(['message' => "Provided email dose not match"], 403);
        }
    }

    public function adminLogin(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/admin_login');
        $snapshot = $reference->getSnapshot();
        if ($admins = collect($snapshot->getValue())->where('email', '=', $request->email)->where('password', '=', $request->password)) {
            foreach ($admins as $admin)
                if ($admin['email'] = $request->email) {
                    $response = ['message' => "login"];
                    return response($admin, 200);
                } else
                    $response = ['message' => "Not Login"];
            return response(['message' => "Invalid Request"], 403);
        }
    }

    public function Profile(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/users/1';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function ProfileUpdate(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'users/' . $neha;
//        dd($request);
        $db->getReference($url)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'nric' => $request->nric,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'password' => $request->password,
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'country' => $request->country,
                    'city' => $request->city,
                    'postcode' => $request->postcode,
        ]);
        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'admin_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User Update Profile',
        ]);

        return response()->json(['db' => $firebase]);
    }

    public function ChangePassword(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'users/' . $neha;
//        dd($request);
        $db->getReference($url)
                ->update([
                    'password' => $request->new_password,
        ]);
        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'admin_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User Change Password',
        ]);

        return response()->json(['db' => $firebase]);
    }

    public function QuestionWithUser(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/question_users');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $postData = [
            'id' => $id + 1,
            'question' => $request->question,
            'other' => $request->other,
            'answer' => $request->answer,
            'user_id' => $request->user_id,
            'user_first_name' => $request->user_first_name,
            'user_last_name' => $request->user_last_name,
        ];
                $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'admin_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User Add New Qusetion',
        ]); 
        $postRef = $db->getReference('question_users/')->push($postData);
        return response()->json(['db' => $firebase]);
    }

    public function AddEnquery(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/enquery');
        $snapshot = $reference->getSnapshot();
        $enquery = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $enquery['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'enquery/' . $neha;
        $db->getReference($url)
                ->set(['id' => $id + 1,
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' => $request->message,
        ]);
                $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'admin_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User Add Enquery',
        ]); 
        return response()->json(['db' => $firebase]);
    }

    public function AddContact(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/contact');
        $snapshot = $reference->getSnapshot();
        $contact = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $contact['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'contact/' . $neha;
        $db->getReference($url)
                ->set(['id' => $id + 1,
                    'address' => $request->address,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
        ]);
                $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Admin Update Contact',
        ]); 
        return response()->json(['db' => $firebase]);
    }

    public function Contact(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/contact/1');
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response()->json($k1);
    }

    public function FaqUpdate(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'faq/' . $neha;
//        dd($request);
        $db->getReference($url)
                ->update([
                    'question' => $request->question,
                    'answer' => $request->answer,
        ]);
                $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Admin Faq Update',
        ]); 
        return response()->json(['db' => $firebase]);
    }

    public function UpdateAbout(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'abouts/-L2ZZ7uFWI4xPQxmSXHN';
//        dd($request);
        $db->getReference($url)
                ->update([
                    'name' => $request->name,
                    'header' => $request->header,
                    'title' => $request->title,
        ]);
                $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Admin About Update',
        ]); 

        return response()->json(['db' => $firebase]);
    }

    public function UpdateContact(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'contact/1';
//        dd($request);
        $db->getReference($url)
                ->update([
                    'address' => $request->address,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
        ]);
                $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Admin Update Contact',
        ]); 

        return response()->json(['db' => $firebase]);
    }

    public function Enquery(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/enquery');
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function AddQuestion(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/question');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'question/' . $neha;
        $db->getReference($url)
                ->set([
                    'id' => $id + 1,
                    'question' => $request->question,
                    'answer' => [
                        $request->answer
                    ],
                    'options' => [
                        $request->options
                    ],
                    'type' => $request->type,
        ]);

        return response()->json(['db' => $firebase]);
    }

    public function Particular(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/question/' . $id;
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response()->json($k1);
    }

    public function AllQuestion(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = '/question/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function AddAnswer(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/answer');
        $snapshot = $reference->getSnapshot();
        $answer = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $answer['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'answer/' . $neha;
        $db->getReference($url)
                ->set([
                    'id' => $id + 1,
                    'question' => $request->question,
                    'question_id' => $request->question_id,
                    'answer' => [
                        'option' => $request->options,
                    ],
                    'user_id' => $request->user_id,
                    'user_first_name' => $request->user_first_name,
                    'user_last_name' => $request->user_last_name,
        ]);
               $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'admin_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User Add Answer',
        ]); 

        return response()->json(['db' => $firebase]);
    }

    public function UserAnswer(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/answer/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        if ($k1 = collect($snapshot->getValue())->where('user_id', '=', $request->id)) {
            return response($k1, 200);
        }
    }

    public function FixAppotiment(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/appoitment');
        $snapshot = $reference->getSnapshot();
        $appoitment = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $appoitment['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'appoitment/' . $neha;
        $db->getReference($url)
                ->set([
                    'id' => $id + 1,
                    'appoitment_date' => $request->appoitment_date,
                    'appoitment_day' => $request->appoitment_day,
                    'user_id' => $request->user_id,
                    'user_first_name' => $request->user_first_name,
                    'user_last_name' => $request->user_last_name,
        ]);
        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'User Appointment Fixed',
        ]); 
        
        $user = $firebase->getDatabase();
        $reference = $user->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $user = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $user->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Your Appointment Fixed',
        ]); 

        return response()->json(['db' => $firebase]);
    }

    public function YourAppoitment(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = '/appoitment/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $appoitments = $snapshot->getValue();
        if ($appoitments = collect($snapshot->getValue())->where('user_id', '=', $request->id)) {
            foreach ($appoitments as $app)
                $id = '/appoitment/' . $app['id'];
            $reference = $db->getReference($id);
            $snapshot = $reference->getSnapshot();
            $k1 = $snapshot->getValue();
            return response($k1);
        }
    }

    public function AllAnswer(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/answer/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1, 200);
    }

    public function AllAppointment(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
//        $id = $request->id;
        $id = '/appoitment/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1, 200);
    }

    public function AppointmentDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/appoitment/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

    public function UserDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/users/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

    public function FaqDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/faq/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

    public function EnqueryDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/enquery/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

    public function AnswerDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/answer/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

    public function AddProducts(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/product');
        $snapshot = $reference->getSnapshot();
        $product = collect($snapshot->getValue())->sortBy('id')->last();

        $id = $product['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $db = $firebase->getDatabase();

        $image = $request->file('file');
        $cover1Path = str_random(16) . '.' . $image->getClientOriginalExtension();
        $image->move('upload', $cover1Path);
        // $data['file'] = 'upload/' . $cover1Path;

        $neha = $id + 1;
        $url = 'product/' . $neha;
        $price = (int) $request->price;

        $db->getReference($url)
                ->set(['id' => $id + 1,
                    'name' => $request->name,
                    'price' => $price,
                    'sub_name' => $request->sub_name,
                    'image' => 'upload/' . $cover1Path,
        ]);
        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => 'Admin ADD New Product',
        ]); 
        $reference = $db->getReference($url);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }

    public function ProductDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/product/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

    public function AllProducts(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
//        $id = $request->id;
        $id = '/product/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1, 200);
    }

    public function AdminNotification(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/admin_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->where('view', '=', 0)->last();
        return response($faq, 200);
    }

    public function UserNotification(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $reference = $db->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->where('view', '=', 0)->last();

        return response($faq, 200);
    }

    public function UserAddNotification(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'user_notification/' . $neha;
//        dd($request);
        $db->getReference($url)
                ->update([
                    'view' => 1,
        ]);
        return response()->json(['db' => $firebase]);
    }

    public function AdminAddNotification(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $neha = $id;
        $url = 'admin_notification/' . $neha;
//        dd($request);
        $db->getReference($url)
                ->update([
                    'view' => 1,
        ]);
        return response()->json(['db' => $firebase]);
    }
    
    public function AllNotification(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
//        $id = $request->id;
        $id = '/user_notification/';
        $reference = $db->getReference($id);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1, 200);
    }
    
    public function AddNotification(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        
        $notify = $firebase->getDatabase();
        $reference = $notify->getReference('/user_notification');
        $snapshot = $reference->getSnapshot();
        $faq = collect($snapshot->getValue())->sortBy('id')->last();
        $id = $faq['id'];
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $notify = $firebase->getDatabase();
        $neha = $id + 1;
        $url = 'user_notification/' . $neha;
        $notify->getReference($url)
                ->set(['id' => $id + 1,
                    'title' => $request->title,
        ]); 
        $reference = $notify->getReference($url);
        $snapshot = $reference->getSnapshot();
        $k1 = $snapshot->getValue();
        return response($k1);
    }
    
      public function NotificationDelete(Request $request) {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/mens-health-feb20-firebase-adminsdk-hsgx6-dac1480bbc.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://mens-health-feb20.firebaseio.com/')->create();
        $db = $firebase->getDatabase();
        $id = $request->id;
        $id = '/user_notification/' . $id;
        $db->getReference($id)->remove();
        return response(200);
    }

}
