<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DevDojo\Chatter\Events\ChatterAfterNewResponse;
use DevDojo\Chatter\Events\ChatterBeforeNewResponse;
use \App\Models;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use LukeTowers\Purifier\Facades\Purifier;

class ChatterPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stripped_tags_body = ['body' => strip_tags($request->body)];
        $validator = Validator::make($stripped_tags_body, [
            'body' => 'required|min:10|max:2000',
        ],[
            'body.required' => trans('chatter::alert.danger.reason.content_required'),
            'body.min' => trans('chatter::alert.danger.reason.content_min'),
            'body.max' => 'The maximum character length is 2000.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (config('chatter.security.limit_time_between_posts')) {
            if ($this->notEnoughTimeBetweenPosts()) {
                alert()->info('Please wait..','1 minute before posting again!');
                return back()->withInput();
            }
        }

        $request->request->add(['user_id' => Auth::user()->id]);

        $new_post = Models::post()->create($request->all());

        $discussion = Models::discussion()->find($request->chatter_discussion_id);

        if($request->user()->hasRole('User') && $discussion->locked = 1){
            alert()->question('owo', 'What\'s this?');
            return back()->withInput();
        }

        $category = Models::category()->find($discussion->chatter_category_id);
        if (!isset($category->slug)) {
            $category = Models::category()->first();
        }
        if($request->user()->hasRole('Administrator') && $discussion->locked == 1 || $request->user()->hasRole('User') && $discussion->locked == 0 || $request->user()->hasRole('Administrator') && $discussion->locked == 0) {
            if ($new_post->id) {
                $discussion->last_reply_at = $discussion->freshTimestamp();
                $discussion->save();

                // if email notifications are enabled
                if (config('chatter.email.enabled')) {
                    // Send email notifications about new post
                    $this->sendEmailNotifications($new_post->discussion);
                }

                toast('Replied successfully!','success','top-right');
                return redirect('/' . config('chatter.routes.home') . '/' . config('chatter.routes.discussion') . '/' . $category->slug . '/' . $discussion->slug);
            } else {
                alert()->error('Yikes', 'Something went wrong, contact us if it persists');
                return redirect('/' . config('chatter.routes.home') . '/' . config('chatter.routes.discussion') . '/' . $category->slug . '/' . $discussion->slug);
            }
        }
    }

    private function notEnoughTimeBetweenPosts()
    {
        $user = Auth::user();

        $past = Carbon::now()->subMinutes(config('chatter.security.time_between_posts'));

        $last_post = Models::post()->where('user_id', '=', $user->id)->where('created_at', '>=', $past)->first();

        if (isset($last_post)) {
            return true;
        }

        return false;
    }

    private function sendEmailNotifications($discussion)
    {
        $users = $discussion->users->except(Auth::user()->id);
        foreach ($users as $user) {
            Mail::to($user)->queue(new ChatterDiscussionUpdated($discussion));
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::findOrFail($id);

        if (!Auth::user()->hasRole('Administrator') || Auth::user()->id !== (int) $post->user_id) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/'.config('chatter.routes.home'));
        }

        //check for correct user
        if(Auth::user()->hasRole('Administrator')) {
            return view('front.editPost')->with([
                'post' => $post
            ]);
        } elseif(Auth::user()->id !== $post->user_id){
            return view('front.main')->with('error', 'Unauthorized page');
        }

        return view('front.editPost')->with([
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $stripped_tags_body = ['body' => strip_tags($request->body)];
        $validator = Validator::make($stripped_tags_body, [
            'body' => 'required|min:10',
        ],[
            'body.required' => trans('chatter::alert.danger.reason.content_required'),
            'body.min' => trans('chatter::alert.danger.reason.content_min'),
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = Models::post()->find($id);

        if (!$request->user()->hasRole('Administrator') || $request->user()->id !== (int) $post->user_id) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/'.config('chatter.routes.home'));
        }
        if (Auth::user()->hasRole('Administrator')) {
            if ($post->markdown) {
                $post->body = $request->body;
            } else {
                $post->body = Purifier::clean($request->body);
            }
            $post->save();

            $discussion = Models::discussion()->find($post->chatter_discussion_id);

            $category = Models::category()->find($discussion->chatter_category_id);
            if (!isset($category->slug)) {
                $category = Models::category()->first();
            }
            toast('Updated successfully!','success','top-right');
            return redirect('/'.config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/'.$category->slug.'/'.$discussion->slug);
        } elseif (!Auth::guest() && ($request->user()->id == $post->user_id)) {
            if ($post->markdown) {
                $post->body = $request->body;
            } else {
                $post->body = Purifier::clean($request->body);
            }
            $post->save();

            $discussion = Models::discussion()->find($post->chatter_discussion_id);

            $category = Models::category()->find($discussion->chatter_category_id);
            if (!isset($category->slug)) {
                $category = Models::category()->first();
            }

            toast('Updated successfully!','success','top-right');

            return redirect('/'.config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/'.$category->slug.'/'.$discussion->slug);
        } else {
            toast('Something went wrong...','error','top-right');

            return redirect('/'.config('chatter.routes.home'));
        }
    }

    /**
     * Delete post.
     *
     * @param string $id
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Routing\Redirect
     * @throws \Exception
     */
    public function destroy($id, Request $request)
    {
        $post = Models::post()->with('discussion')->findOrFail($id);

        if (!$request->user()->hasRole('Administrator') || $request->user()->id !== (int) $post->user_id) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/'.config('chatter.routes.home'));
        }

        if($request->user()->hasrole('Administrator') || $request->user()->id == (int) $post->user_id){
            if ($post->discussion->posts()->oldest()->first()->id === $post->id) {
                if(config('chatter.soft_deletes')) {
                    $post->discussion->posts()->delete();
                    $post->discussion()->delete();
                } else {
                    $post->discussion->posts()->forceDelete();
                    $post->discussion()->forceDelete();
                }

                toast('Destroyed successfully!','success','top-right');
                return redirect('/'.config('chatter.routes.home'));
            }
            $post->delete();

            $url = '/'.config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/'.$post->discussion->category->slug.'/'.$post->discussion->slug;

            toast('Destroyed successfully!','success','top-right');
            return redirect($url);
        }

        if ($post->discussion->posts()->oldest()->first()->id === $post->id) {
            if(config('chatter.soft_deletes')) {
                $post->discussion->posts()->delete();
                $post->discussion()->delete();
            } else {
                $post->discussion->posts()->forceDelete();
                $post->discussion()->forceDelete();
            }
            toast('Destroyed successfully!','success','top-right');
            return redirect('/'.config('chatter.routes.home'));
        }

        $post->delete();

        $url = '/'.config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/'.$post->discussion->category->slug.'/'.$post->discussion->slug;

        toast('Destroyed successfully!','success','top-right');
        return redirect($url);
    }
}
