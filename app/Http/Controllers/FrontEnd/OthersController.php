<?php

namespace App\Http\Controllers\FrontEnd;

use App\Blog;
use App\Galary;
use App\Http\Controllers\Controller;
use App\Jobs\SendMessage;
use App\News;
use App\OurService;
use App\PrivacyPolicy;
use App\SuccessStory;
use App\TermsRegulation;
use App\Testimonial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OthersController extends Controller
{
    /**
     * show FAQ
     */
    public function showFAQ(){
        return view('frontEnd.others.FAQ');
    }

    /**
     * Show Privacy Policies  
     */
    protected function showPrivacyPolicies (){
        $param['privacyPolicies'] = PrivacyPolicy::where('status', 'published')->orderBy('id', 'DESC')->get();
        return view('frontEnd.others.privacyPolicies', $param);
    }

    /**
     * Show Terms & Regulations 
     */
    protected function showTermsRegulations(){
        $param['termsRegulations'] = TermsRegulation::where('status', 'published')->orderBy('id', 'DESC')->get();
        return view('frontEnd.others.termsRegulations', $param);
    }

    /**
     * Our Service
     */
    public function showOurServices(){
        $param['ourServices'] = OurService::where('status', 'published')->orderBy('id', 'DESC')->paginate(12);
        return view('frontEnd.others.ourServices', $param);
    }

    /**
     * View Success Story
     */
    public function viewSuccessStorys(){
        $param['successStories'] = SuccessStory::where('status', 'published')->orderBy('id', 'DESC')->paginate(12);
        return view('frontEnd.successStory.successStory', $param);
    }


    /**
     * View Blog post
     */
    public function viewSuccessStory($slug){
        $parms['successStory'] = SuccessStory::where('slug', $slug)->firstOrFail();
        return view('frontEnd.successStory.view', $parms);
    }

    /**
     * View Testimonial Page
     */
    public function ViewTestimonials(){
        $parms['testimonials'] = Testimonial::where('status', 'published')->orderBy('id','DESC')->paginate(12);
        return view('frontEnd.testimonial.testimonial', $parms);
    }

    /**
     * View Testimonial
     */
    public function ViewTestimonial($slug){
        $parms['testimonial'] = Testimonial::where('slug', $slug)->firstOrFail();
        return view('frontEnd.testimonial.view', $parms);
    }

    /**
     * View Blogs
     */
    public function ViewBlogs(){
        $parms['blogs'] = Blog::where('status', 'published')->orderBy('id','DESC')->paginate(12);
        return view('frontEnd.blog.blog', $parms);
    }
    
    /**
     * View Blog post
     */
    public function ViewBlogPost($slug){
        $parms['blog'] = Blog::where('slug', $slug)->firstOrFail();
        return view('frontEnd.blog.view', $parms);
    }

    /**
     * View All Newses
     */
    public function showNews(){
        $parms['newses'] = News::where('status', 'published')->orderBy('id','DESC')->paginate(12);
        return view('frontEnd.news.news', $parms);
    }

    /**
     * View News
     */
    public function Viewnews($slug){
        $parms['news'] = News::where('slug', $slug)->firstOrFail();
        return view('frontEnd.news.view', $parms);
    }

    /**
     * Show Gallery
     */
    public function showGallery(){
        $parms['galleries'] = Galary::where('status', 'published')->orderBy('id', 'DESC')->paginate(16);
        return view('frontEnd.others.gallery', $parms);
    }

    /**
     * View Contact
     */
    public function viewContact(){
        return view('frontEnd.others.contact');
    }

    /**
     * Send Message to Admin
     */
    public function sendMessage(Request $request){
        try{
            $data_arr = $request->all();
            $validator = Validator::make($data_arr, [
                'name'      => ['required','string','min:2'],
                'email'     => ['required','email'],
                'subject'   => ['required','string','min:2'],
                'message'   => ['required','string','min:2'],
            ]);            
            if($validator->fails()){
                return $this->output($this->getValidationError($validator));
            }
            SendMessage::dispatch($data_arr)->delay(10);
            $message = "We Take your message. As soon as we contact with you. Thank you for Share your openion with us.";
            $this->success($message);
            $this->table = false;
            $this->button = true;
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show About Us page
     */
    public function showAboutUs(Request $request){
        return view('frontEnd.others.aboutUs');
    }

    /**
     * User manual
     */
    public function userManual(){
        return view('frontEnd.others.userManual');
    }

    /**
     * Show Payment Option Page
     */
    public function showPaymentOption(){
        return view('frontEnd.others.paymentOptions');
    }
}
