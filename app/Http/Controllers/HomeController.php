<?php

namespace App\Http\Controllers;

use Ezegyfa\LaravelHelperMethods\Database\FormGenerating\DatabaseInfos;
use Ezegyfa\LaravelHelperMethods\DynamicTemplateMethods;
use Ezegyfa\LaravelHelperMethods\HttpMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function welcome() {
        return DynamicTemplateMethods::getTranslatedTemplateDynamicPage(
            'la75_welcome', 
            'node_modules/la75-vue-components/src/Welcome/CompiledTemplate.json', 
            new \StdClass,
            [ 
                'layout',
                'welcome', 
            ],
            [ 
                'fontawesome/css/fontawesome.min', 
                'fontawesome/css/brands.min' 
            ]
        );
    }

    public function aboutUs() {
        $templateParams = new \StdClass;
        if (property_exists($templateParams, 'success_message')) {
            $templateParams->success_message->is_visible = Session::has('success_message');
        }
        return DynamicTemplateMethods::getTranslatedTemplateDynamicPage(
            'la75_about_us', 
            'node_modules/la75-vue-components/src/AboutUs/CompiledTemplate.json', 
            new \StdClass,
            [ 
                'layout',
                'aboutUs',
            ], 
            [ 
                'fontawesome/css/fontawesome.min', 
                'fontawesome/css/brands.min' 
            ]
        );
    }

    public function contactAndFAQ() {
        $templateParams = DynamicTemplateMethods::getTranslatedTemplateParamsFromFile(base_path('app/Templates/contactAndFAQ_compiled.json'));
        $templateParams->questions = \DB::table('faq')->select(['question', 'answer'])->get()->toArray();
        $templateParams->contact_form = new \stdClass;
        $templateParams->contact_form->form_item_sections = json_decode(file_get_contents(base_path('app/Templates/contactUsTableInfos.json')));
        if (property_exists($templateParams, 'success_message')) {
            $templateParams->success_message->is_visible = Session::has('success_message');
        }
        return DynamicTemplateMethods::getTranslatedTemplateDynamicPage(
            'la75_contact_and_faq', 
            'node_modules/la75-vue-components/src/ContactAndFAQ/CompiledTemplate.json',
            $templateParams, 
            [ 
                'layout',
                'layoutWithHeader',
                'contactAndFAQ',
            ], 
            [ 
                'fontawesome/css/fontawesome.min', 
                'fontawesome/css/brands.min' 
            ]
        );
    }

    public function storeContactMessage(Request $request) {
        try {
            $validationRules = [
                "name" => [
                    "string",
                    "max:255",
                    "required",
                ],
                "email" => [
                    "string",
                    "max:255",
                    "required",
                    "email",
                ],
                "phone" => [
                    "string",
                    "max:15",
                    "required",
                    "regex:/([0-9]|\+){0,14}/"
                ],
                "message" => "required",
            ];
            $request->validate($validationRules);
            $requestData = request()->all();
            $insertData = [
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'phone' => $requestData['phone'],
                'message' => $requestData['message'],
            ];
            \DB::table('contact_messages')->insert($insertData);
        }
        catch (ValidationException $e) {
            $errorMessages = HttpMethods::updateErrors($e->errors(), $e->validator->failed());
            return redirect()->back()->withInput(request()->all())->withErrors($errorMessages);
        }
        return redirect('/contact-and-faq')->with('success_message', __('welcome.contact_success'));
    }
}
