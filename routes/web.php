<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// require('install.php');


/**
 * FrontEnd Web Routes
 */

Auth::routes(['verify' => true]);

//Check Email
Route::get('check/unique-email','Auth\RegisterController@checkUniqueEmail');
Route::get('run/command','HomeController@runCommand');
Route::get('visitor/area-name','HomeController@storeAreaInfo');

Route::middleware(['Visitor'])->group(function() {

    Route::get('/', 'HomeController@index');
    Route::get('/packages','FrontEnd\SubscriptionController@showPackages');

    // Blog
    Route::get('/blog','FrontEnd\OthersController@ViewBlogs');
    Route::get('/blog/view-post/{slug}','FrontEnd\OthersController@ViewBlogPost');

    //Succes sstory
    Route::get('success-story/view-all/','FrontEnd\OthersController@viewSuccessStorys');
    Route::get('/success-story/view-story/{slug}','FrontEnd\OthersController@viewSuccessStory');

    // Testimonial
    Route::get('/testimonial/view-all','FrontEnd\OthersController@ViewTestimonials');
    Route::get('/testimonial/view-testimonial/{slug}','FrontEnd\OthersController@ViewTestimonial');

    // Newsmenu
    Route::get('/news/view-all','FrontEnd\OthersController@ViewNewses');
    Route::get('/news/view-news/{slug}','FrontEnd\OthersController@Viewnews');

    //others
    Route::get('/gallery','FrontEnd\OthersController@showGallery');
    Route::get('/news','FrontEnd\OthersController@showNews');
    Route::get('/FAQ','FrontEnd\OthersController@showFAQ');
    Route::get('/our-service','FrontEnd\OthersController@showOurServices');
    Route::get('/privacy-policies','FrontEnd\OthersController@showPrivacyPolicies');
    Route::get('/terms-regulations','FrontEnd\OthersController@showTermsRegulations');
    Route::get('/about-us','FrontEnd\OthersController@showAboutUs');
    Route::get('/user-manual','FrontEnd\OthersController@userManual');
    Route::get('payment-options','FrontEnd\OthersController@showPaymentOption');

    // Contact
    Route::get('/contact','FrontEnd\OthersController@viewContact');
    Route::post('/contact','FrontEnd\OthersController@sendMessage');

    // Payment Gateway
    Route::any('subscription/payment/success','FrontEnd\SubscriptionController@paymentSuccess');
    Route::any('subscription/payment/fail','FrontEnd\SubscriptionController@paymentFail');
    Route::any('subscription/payment/cancel','FrontEnd\SubscriptionController@paymentCancel');

    Route::get('/logout','Auth\LoginController@logout');
    Route::get('news/view/{slug}','HomeController@openNews');

    // Get District & Upazila
    Route::get('get/district','FrontEnd\AccountController@getDistrict')->name('get.district');
    Route::get('get/upazila','FrontEnd\AccountController@getUpazila')->name('get.upazila');

    Route::middleware(['auth'])->group(function(){
        
        Route::get('/home', 'HomeController@home')->name('home');
        Route::get('/connected', 'HomeController@connectedUser')->name('connected_user');
        Route::get('profile/instruction','HomeController@instruction');

        //Incomplete Profile
        Route::get('profile/incomplete','FrontEnd\AccountController@showIncompleteProfilePage');
        Route::post('profile/incomplete','FrontEnd\AccountController@storeIncompleteProfile');
        
        // Profile Section
        Route::get('profile','FrontEnd\AccountController@showUpdateProfile');
        Route::get('profile/update','FrontEnd\AccountController@showUpdateProfile');    
        Route::post('profile/update','FrontEnd\AccountController@updateProfile');
        Route::post('profile/update/profile-pic','FrontEnd\AccountController@updateProfilePic');
        Route::post('profile/upload/image','FrontEnd\AccountController@uploadPicture');
        Route::post('profile/update/password','FrontEnd\AccountController@updatePassword');
        Route::get('profile/{id}/picture/delete','FrontEnd\AccountController@deletePicture')->name('profilepic.delete');
        Route::get('profile/{id}/{name}/view','FrontEnd\AccountController@viewProfile');
        Route::get('profile/my-matches','FrontEnd\AccountController@viewMyMatched');
        Route::get('profile/new-matches','FrontEnd\AccountController@viewMyMatched');
        Route::get('profile/{profile_id}/view-contact','FrontEnd\AccountController@viewContactDetails');

        Route::get('profile/{profile_id}/block','FrontEnd\AccountController@blockProfile');
        Route::get('profile/{profile_id}/unblock','FrontEnd\AccountController@unBlockProfile');

        //Advance Search
        Route::get('/advance-search','FrontEnd\SearchController@showSearchPage');
        Route::post('/advance-search','FrontEnd\SearchController@search');

        // Subscription 
        Route::get('account/membership/upgrade','FrontEnd\SubscriptionController@showPackages')->name('membership.upgrade');
        Route::get('account/subscription/{id}/confirm','FrontEnd\SubscriptionController@confirmSubscription')->name('subscription.confirm'); 
        Route::get('subscription/message','FrontEnd\SubscriptionController@sebscriptionMessage');
        
        //Chat Controller
        Route::get('load/chat','FrontEnd\ChatController@getChat');
        Route::get('load/unload/chat','FrontEnd\ChatController@getUnloadChat');
        Route::get('message/send','FrontEnd\ChatController@sendMessage');
        
        // Notification
        Route::get('notification/list','FrontEnd\NotificationController@showAll');
        Route::get('notification/{id}/{notification}/view','FrontEnd\NotificationController@showAll');
    
        //Proposal or Invitation
        Route::get('profile/{profile_id}/proposal/sent','FrontEnd\AccountController@sentProposal');
        Route::get('profile/{profile_id}/proposal/reject','FrontEnd\ProposalController@cancelProposal');
        Route::get('proposal/{proposal_id}/accept','FrontEnd\ProposalController@acceptProposal');
        Route::get('proposal/{proposal_id}/reject','FrontEnd\ProposalController@rejectProposal');
    });

});  
  

    
/**
 * *********************************************************
 * BackEnd admin Panel Section
 * *********************************************************
 */

Route::get('dashboard/admin-login','BackEnd\Auth\LoginController@showLoginForm')->name('admin.login');
Route::get('/admin','BackEnd\Auth\LoginController@showLoginForm');
Route::post('dashboard/admin-login','BackEnd\Auth\LoginController@login');
Route::get('dashboard/admin-password-reset','BackEnd\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('dashboard/admin-password-reset','BackEnd\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('dashboard/admin-password-reset-form/','BackEnd\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('dashboard/admin-password/update','BackEnd\Auth\ResetPasswordController@reset')->name('admin.password.update');


route::get('religious/cast/get','BackEnd\ReligiousCastController@getCastList')->name('religious.cast.get');

Route::middleware(['Admin'])->prefix('/')->group(function(){
    Route::get('/dashboard','BackEnd\Auth\LoginController@showDashboard')->name('dashboard');
    Route::get('/visitor/country-summary','BackEnd\Auth\LoginController@countruBasedSummary')->name('visitor.country.summary');

    Route::prefix('admin/')->name('admin.')->group(function(){

        Route::get('/logout','BackEnd\Auth\LoginController@logout')->name('logout');

        Route::get('/website/setting','BackEnd\WebsiteSettingsController@create')->name('website.setting');
        Route::post('/website/setting','BackEnd\WebsiteSettingsController@store');

        Route::get('/list','BackEnd\AdminController@index')->name('list');
        Route::get('/create','BackEnd\AdminController@create')->name('create');
        Route::post('/create','BackEnd\AdminController@store');
        Route::get('/{id}/view','BackEnd\AdminController@showProfile')->name('profile');
        Route::get('/{id}/edit','BackEnd\AdminController@edit')->name('edit');
        Route::get('/{id}/archive','BackEnd\AdminController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\AdminController@archiveList')->name('archive_list');
        Route::get('/{id}/restore','BackEnd\AdminController@restore')->name('restore');

        Route::get('/monitoring','BackEnd\AdminController@monitoringList')->name('monitoring');
    });

    Route::prefix('user/')->name('user.')->group(function(){
        Route::get('/list', 'BackEnd\UserController@index')->name('list');
        Route::get('/create', 'BackEnd\UserController@create')->name('create');
        Route::post('/create', 'BackEnd\UserController@store');
        Route::get('/{id}/view', 'BackEnd\UserController@showProfile')->name('profile');
        Route::get('/{id}/download', 'BackEnd\UserController@downloadBio')->name('bio');
        Route::get('/{id}/edit', 'BackEnd\UserController@edit')->name('edit');        
        Route::get('/{id}/status-update', 'BackEnd\UserController@createStatusUpdate')->name('status_update');
        Route::post('/{id}/status-update', 'BackEnd\UserController@storeStatusUpdate');
        Route::get('/{id}/image-update', 'BackEnd\UserController@showImages')->name('image_update');
        Route::post('/{id}/image-update', 'BackEnd\UserController@uploadImages');
        Route::get('/{id}/picture/delete','BackEnd\UserController@deletePicture')->name('pic_delete');
        Route::get('/{id}/picture/rotate','BackEnd\UserController@rotatePicture')->name('pic_rotate');

        Route::get('/{id}/update-password','BackEnd\UserController@showChangePassword')->name('password_update');
        Route::post('/{id}/update-password','BackEnd\UserController@updatePassword');

        Route::get('/{id}/archive', 'BackEnd\UserController@archive')->name('archive');
        Route::get('/archive-list','BackEnd\UserController@archiveList')->name('archive_list');
        Route::get('/{id}/restore','BackEnd\UserController@restore')->name('restore');

        Route::get('/access/log','BackEnd\UserController@accessLog')->name('monitor_list');
    });

    Route::prefix('payments/')->name('payments.')->group(function(){
        Route::prefix('offline/')->name('offline.')->group(function(){
            Route::get('/','BackEnd\PaymentsController@offlinePayments')->name('list');
            Route::get('create/','BackEnd\PaymentsController@createOfflinePayments')->name('create');
            Route::post('create/','BackEnd\PaymentsController@storeOfflinePayments');
            Route::get('{id}/payment-view/','BackEnd\PaymentsController@viewOfflinePayments')->name('view');
        });
        
        Route::prefix('online/')->name('online.')->group(function(){
            Route::get('/','BackEnd\PaymentsController@onlinePayments')->name('list');
            Route::get('{id}/payment-view/','BackEnd\PaymentsController@viewOnlinePayments')->name('view');
        });
        
    });

    Route::prefix('report/')->name('report.')->group(function(){
        Route::get('user-report/{type?}','BackEnd\ReportController@userReport')->name('user');
        Route::get('user-payment-report/{type?}','BackEnd\ReportController@paymentReport')->name('payment');
    });

    // Seo Part
    Route::get('manage/seo','BackEnd\SeoController@show')->name('seo');
    Route::post('manage/seo','BackEnd\SeoController@store');
    
    Route::prefix('banner/')->name('banner.')->group(function(){
        Route::get('/list', 'BackEnd\BannerController@index')->name('list');
        Route::get('/create', 'BackEnd\BannerController@create')->name('create');
        Route::post('/create', 'BackEnd\BannerController@store');
        Route::get('/{slug}/view', 'BackEnd\BannerController@showProfile')->name('view');
        Route::get('/{slug}/edit', 'BackEnd\BannerController@edit')->name('edit');
        Route::get('/{slug}/archive', 'BackEnd\BannerController@archive')->name('archive');
        
        Route::get('/archive-list','BackEnd\BannerController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\BannerController@restore')->name('restore');
    });

    Route::prefix('Marital-status/')->name('marital_status.')->group(function(){
        Route::get('/list', 'BackEnd\MaritalStatusController@index')->name('list');
        Route::get('/create', 'BackEnd\MaritalStatusController@create')->name('create');
        Route::post('/create', 'BackEnd\MaritalStatusController@store');
        Route::get('/{slug}/edit', 'BackEnd\MaritalStatusController@edit')->name('edit');
    });

    Route::prefix('galary/')->name('galary.')->group(function(){
        Route::get('/list', 'BackEnd\GalaryController@index')->name('list');
        Route::get('/create', 'BackEnd\GalaryController@create')->name('create');
        Route::post('/create', 'BackEnd\GalaryController@store');
        Route::get('/{slug}/edit', 'BackEnd\GalaryController@edit')->name('edit');
        Route::get('/{slug}/archive', 'BackEnd\GalaryController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\GalaryController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\GalaryController@restore')->name('restore');
        Route::get('/{slug}/delete','BackEnd\GalaryController@delete')->name('delete');
    });

    Route::prefix('news/')->name('news.')->group(function(){
        Route::get('/list', 'BackEnd\NewsController@index')->name('list');
        Route::get('/create', 'BackEnd\NewsController@create')->name('create');
        Route::post('/create', 'BackEnd\NewsController@store');
        Route::get('/{slug}/view', 'BackEnd\NewsController@view')->name('view');
        Route::get('/{slug}/edit', 'BackEnd\NewsController@edit')->name('edit');
        Route::get('/{slug}/archive', 'BackEnd\NewsController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\NewsController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\NewsController@restore')->name('restore');
        Route::get('/{slug}/delete','BackEnd\NewsController@delete')->name('delete');
    });

    Route::prefix('testimonial/')->name('testimonial.')->group(function(){
        Route::get('/list', 'BackEnd\TestimonialController@index')->name('list');
        Route::get('/create', 'BackEnd\TestimonialController@create')->name('create');
        Route::post('/create', 'BackEnd\TestimonialController@store');
        Route::get('/{slug}/view', 'BackEnd\TestimonialController@view')->name('view');
        Route::get('/{slug}/edit', 'BackEnd\TestimonialController@edit')->name('edit');
        Route::get('/{slug}/archive', 'BackEnd\TestimonialController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\TestimonialController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\TestimonialController@restore')->name('restore');
        Route::get('/{slug}/delete','BackEnd\TestimonialController@delete')->name('delete');
    });

    Route::prefix('our-service/')->name('ourservice.')->group(function(){
        Route::get('/list', 'BackEnd\OurServiceController@index')->name('list');
        Route::get('/create', 'BackEnd\OurServiceController@create')->name('create');
        Route::post('/create', 'BackEnd\OurServiceController@store');
        Route::get('/{slug}/view', 'BackEnd\OurServiceController@view')->name('view');
        Route::get('/{slug}/edit', 'BackEnd\OurServiceController@edit')->name('edit');
        Route::get('/{slug}/archive', 'BackEnd\OurServiceController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\OurServiceController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\OurServiceController@restore')->name('restore');
        Route::get('/{slug}/delete','BackEnd\OurServiceController@delete')->name('delete');
    });
    
    Route::prefix('blog/')->name('blog.')->group(function(){

        Route::prefix('category/')->name('category.')->group(function(){
            Route::get('/list', 'BackEnd\BlogCategoryController@index')->name('list');
            Route::get('/create', 'BackEnd\BlogCategoryController@create')->name('create');
            Route::post('/create', 'BackEnd\BlogCategoryController@store');
            Route::get('/{slug}/edit', 'BackEnd\BlogCategoryController@edit')->name('edit');
            Route::get('/{slug}/archive', 'BackEnd\BlogCategoryController@archive')->name('archive');

            Route::get('/archive-list','BackEnd\BlogCategoryController@archiveList')->name('archive_list');
            Route::get('/{slug}/restore','BackEnd\BlogCategoryController@restore')->name('restore');
        });
        
        Route::get('/list', 'BackEnd\BlogController@index')->name('list');
        Route::get('/create', 'BackEnd\BlogController@create')->name('create');
        Route::post('/create', 'BackEnd\BlogController@store');
        Route::get('/{slug}/edit', 'BackEnd\BlogController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\BlogController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\BlogController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\BlogController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\BlogController@restore')->name('restore');  
    });

    Route::prefix('success-story/')->name('successStory.')->group(function(){
        Route::get('/list', 'BackEnd\SuccessStoryController@index')->name('list');
        Route::get('/create', 'BackEnd\SuccessStoryController@create')->name('create');
        Route::post('/create', 'BackEnd\SuccessStoryController@store');
        Route::get('/{slug}/edit', 'BackEnd\SuccessStoryController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\SuccessStoryController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\SuccessStoryController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\SuccessStoryController@archiveList')->name('archive_list');
        Route::get('/{slug}/restore','BackEnd\SuccessStoryController@restore')->name('restore');  
    });

    Route::prefix('privacy/')->name('privacy.')->group(function(){
        
        Route::get('/list', 'BackEnd\PrivacyController@index')->name('list');
        Route::get('/create', 'BackEnd\PrivacyController@create')->name('create');
        Route::post('/create', 'BackEnd\PrivacyController@store');
        Route::get('/{slug}/edit', 'BackEnd\PrivacyController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\PrivacyController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\PrivacyController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\PrivacyController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\PrivacyController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\PrivacyController@restore')->name('restore');  
    });

    Route::prefix('package/')->name('package.')->group(function(){
        
        Route::get('/list', 'BackEnd\PackageController@index')->name('list');
        Route::get('/create', 'BackEnd\PackageController@create')->name('create');
        Route::post('/create', 'BackEnd\PackageController@store');
        Route::get('/{slug}/edit', 'BackEnd\PackageController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\PackageController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\PackageController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\PackageController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\PackageController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\PackageController@restore')->name('restore');  
    });

    Route::prefix('trams-regulation/')->name('tramsRegulation.')->group(function(){
        
        Route::get('/list', 'BackEnd\TramsRegulationController@index')->name('list');
        Route::get('/create', 'BackEnd\TramsRegulationController@create')->name('create');
        Route::post('/create', 'BackEnd\TramsRegulationController@store');
        Route::get('/{slug}/edit', 'BackEnd\TramsRegulationController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\TramsRegulationController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\TramsRegulationController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\TramsRegulationController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\TramsRegulationController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\TramsRegulationController@restore')->name('restore');  
    });

    Route::prefix('career/')->name('careerProfessional.')->group(function(){
        
        Route::get('/list', 'BackEnd\CareerProfessionalController@index')->name('list');
        Route::get('/create', 'BackEnd\CareerProfessionalController@create')->name('create');
        Route::post('/create', 'BackEnd\CareerProfessionalController@store');
        Route::get('/{slug}/edit', 'BackEnd\CareerProfessionalController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\CareerProfessionalController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\CareerProfessionalController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\CareerProfessionalController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\CareerProfessionalController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\CareerProfessionalController@restore')->name('restore');  
    });

    Route::prefix('monthly/income-range')->name('monthlyIncome.')->group(function(){
        
        Route::get('/list', 'BackEnd\MonthlyIncomeController@index')->name('list');
        Route::get('/create', 'BackEnd\MonthlyIncomeController@create')->name('create');
        Route::post('/create', 'BackEnd\MonthlyIncomeController@store');
        Route::get('/{slug}/edit', 'BackEnd\MonthlyIncomeController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\MonthlyIncomeController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\MonthlyIncomeController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\MonthlyIncomeController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\MonthlyIncomeController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\MonthlyIncomeController@restore')->name('restore');  
    });

    Route::prefix('education/')->name('education_level.')->group(function(){
        
        Route::get('/list', 'BackEnd\EducationLevelController@index')->name('list');
        Route::get('/create', 'BackEnd\EducationLevelController@create')->name('create');
        Route::post('/create', 'BackEnd\EducationLevelController@store');
        Route::get('/{slug}/edit', 'BackEnd\EducationLevelController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\EducationLevelController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\EducationLevelController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\EducationLevelController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\EducationLevelController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\EducationLevelController@restore')->name('restore');  
    });

    Route::prefix('Life-style/')->name('life_style.')->group(function(){
        
        Route::get('/list', 'BackEnd\LifeStyleController@index')->name('list');
        Route::get('/create', 'BackEnd\LifeStyleController@create')->name('create');
        Route::post('/create', 'BackEnd\LifeStyleController@store');
        Route::get('/{slug}/edit', 'BackEnd\LifeStyleController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\LifeStyleController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\LifeStyleController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\LifeStyleController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\LifeStyleController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\LifeStyleController@restore')->name('restore');  
    });

    Route::prefix('religious/')->name('religious.')->group(function(){
        
        Route::get('/list', 'BackEnd\ReligiousController@index')->name('list');
        Route::get('/create', 'BackEnd\ReligiousController@create')->name('create');
        Route::post('/create', 'BackEnd\ReligiousController@store');
        Route::get('/{slug}/edit', 'BackEnd\ReligiousController@edit')->name('edit');
        Route::get('/{slug}/view', 'BackEnd\ReligiousController@view')->name('view');
        Route::get('/{slug}/archive', 'BackEnd\ReligiousController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\ReligiousController@archiveList')->name('archive_list');
        Route::get('/{slug}/delete','BackEnd\ReligiousController@restore')->name('delete');  
        Route::get('/{slug}/restore','BackEnd\ReligiousController@restore')->name('restore');  

        route::prefix('cast/')->name('cast.')->group( function(){
            Route::get('/list', 'BackEnd\ReligiousCastController@index')->name('list');
            Route::get('/create', 'BackEnd\ReligiousCastController@create')->name('create');
            Route::post('/create', 'BackEnd\ReligiousCastController@store');
            Route::get('/{slug}/edit', 'BackEnd\ReligiousCastController@edit')->name('edit');
            Route::get('/{slug}/archive', 'BackEnd\ReligiousCastController@archive')->name('archive');

            Route::get('/archive-list','BackEnd\ReligiousCastController@archiveList')->name('archive_list');
            Route::get('/{slug}/delete','BackEnd\ReligiousCastController@restore')->name('delete');  
            Route::get('/{slug}/restore','BackEnd\ReligiousCastController@restore')->name('restore');            
        });
    });

    Route::prefix('social-media/')->name('social_media.')->group(function(){
        //Social Media
        Route::get('/','BackEnd\SocialMediaController@index')->name('list');
        Route::get('/create','BackEnd\SocialMediaController@create')->name('create');
        Route::post('/create','BackEnd\SocialMediaController@store');
        Route::get('/{id}/edit','BackEnd\SocialMediaController@edit')->name('edit');
        Route::get('/{id}/delete','BackEnd\SocialMediaController@delete')->name('delete');

    });

    
});


