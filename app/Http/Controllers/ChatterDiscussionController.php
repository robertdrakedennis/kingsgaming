<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\ChatterAfterNewDiscussion;
use App\Events\ChatterBeforeNewDiscussion;
use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ChatterDiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Models::category()->all();

        return view('chatter::discussion.create', compact('categories'));
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
        $request->request->add(['body_content' => strip_tags($request->body)]);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:255',
            'body_content' => 'required|min:10|max:5000',
            'chatter_category_id' => 'required',
        ], [
            'title.required' => trans('chatter::alert.danger.reason.title_required'),
            'title.min' => [
                'string' => trans('chatter::alert.danger.reason.title_min'),
            ],
            'title.max' => [
                'string' => trans('chatter::alert.danger.reason.title_max'),
            ],
            'body_content.required' => trans('chatter::alert.danger.reason.content_required'),
            'body_content.min' => trans('chatter::alert.danger.reason.content_min'),
            'chatter_category_id.required' => trans('chatter::alert.danger.reason.category_required'),
            'body_content.max' => 'The maximum characters for a post is 5000.',
        ]);


        Event::fire(new ChatterBeforeNewDiscussion($request, $validator));
        if (function_exists('chatter_before_new_discussion')) {
            chatter_before_new_discussion($request, $validator);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::user()->id;

        if (config('chatter.security.limit_time_between_posts')) {
            if ($this->notEnoughTimeBetweenDiscussion()) {
                alert()->error('Error','You need to wait a few moments to post again..');
                return redirect('/' . config('chatter.routes.home'));

                //return redirect('/' . config('chatter.routes.home'))->with($chatter_alert)->withInput();
            }
        }

        $slug = str_slug($request->title, '-');

        $discussion_exists = Models::discussion()->where('slug', '=', $slug)->withTrashed()->first();
        $incrementer = 1;
        $new_slug = $slug;

        while (isset($discussion_exists->id)) {
            $new_slug = $slug . '-' . $incrementer;
            $discussion_exists = Models::discussion()->where('slug', '=', $new_slug)->withTrashed()->first();
            $incrementer += 1;
        }

        if ($slug != $new_slug) {
            $slug = $new_slug;
        }

        $new_discussion = [
            'title' => $request->title,
            'chatter_category_id' => $request->chatter_category_id,
            'user_id' => $user_id,
            'slug' => $slug,
            'color' => $request->color,
        ];

        $category = Models::category()->find($request->chatter_category_id);
        if (!isset($category->slug)) {
            $category = Models::category()->first();
        }

        $discussion = Models::discussion()->create($new_discussion);

        $new_post = [
            'chatter_discussion_id' => $discussion->id,
            'user_id' => $user_id,
            'body' => $request->body,
        ];

        $discussion->users()->attach($user_id);

        $post = Models::post()->create($new_post);

            if ($post) {
                toast('Thread created successfully!','success','top-right');
                return redirect('/' . config('chatter.routes.home') . '/' . config('chatter.routes.discussion') . '/' . $category->slug . '/' . $slug);
            } else {
                alert()->error('Uh oh...', 'Something went wrong...');
                return redirect('/' . config('chatter.routes.home'));
            }
        }


    private function notEnoughTimeBetweenDiscussion()
    {
        $user = Auth::user();

        $past = Carbon::now()->subMinutes(config('chatter.security.time_between_posts'));

        $last_discussion = Models::discussion()->where('user_id', '=', $user->id)->where('created_at', '>=', $past)->first();

        if (isset($last_discussion)) {
            return true;
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param string $category
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($category, $slug = null)
    {
        if (!isset($category) || !isset($slug)) {
            return redirect(config('chatter.routes.home'));
        }

        $discussion = Models::discussion()->where('slug', '=', $slug)->first();
        if (is_null($discussion)) {
            abort(404);
        }

        $discussion_category = Models::category()->find($discussion->chatter_category_id);
        if ($category != $discussion_category->slug) {
            return redirect(config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/'.$discussion_category->slug.'/'.$discussion->slug);
        }
        $posts = Models::post()->with('user')->where('chatter_discussion_id', '=', $discussion->id)->orderBy(config('chatter.order_by.posts.order'), config('chatter.order_by.posts.by'))->simplePaginate();

        $author = DB::connection('mysql6')->table('users')->where('id', '=', $posts[0]->user_id)->get();
        $chatter_editor = config('chatter.editor');

        $discussion->increment('views');

        return view('chatter::discussion', compact('discussion', 'posts', 'author','chatter_editor'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function lockDiscussion($id)
    {
        $discussion = Models::discussion()->findOrFail($id);
        if (!Auth::user()->hasRole('Administrator')) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/' . config('chatter.routes.home'));
        }
        $discussion->locked = 1;
        $discussion->save();
        toast('Locked successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function unlockDiscussion($id)
    {
        $discussion = Models::discussion()->findOrFail($id);
        if (!Auth::user()->hasRole('Administrator')) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/' . config('chatter.routes.home'));
        }
        $discussion->locked = 0;
        $discussion->save();
        toast('Unlocked successfully!','success','top-right');
        return back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discussion = Models::discussion()->findOrFail($id);
        if(Auth::user()->hasRole('Administrator') || Auth::user()->id == (int) $discussion->user_id) {
            return view('front.editDiscussion')->with([
                'discussion' => $discussion,
            ]);
        } elseif(Auth::user()->id !== $discussion->user_id){
            return view('front.main')->with('error', 'Unauthorized page');
        }

        return view('front.editDiscussion')->with([
            'discussion' => $discussion,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discussion = Models::discussion()->findOrFail($id);

        if (!$request->user()->hasRole('Administrator') || $request->user()->id !== (int) $discussion->user_id) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/' . config('chatter.routes.home'));
        } else

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:255',
        ], [
            'title.required' => trans('chatter::alert.danger.reason.title_required'),
            'title.min' => 'The minimum length is 5 characters.',
            'title.max' => 'The maximum length is 255 characters.']);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
            $discussion->title = $request->title;
            $discussion->save();
            toast('Updated successfully!','success','top-right');
        return redirect('/' . config('chatter.routes.home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discussion = Discussion::find($id);
        if (!Auth::user()->hasRole('Administrator') || Auth::user()->id !== (int) $discussion->user_id) {
            alert()->question('owo', 'What\'s this?');
            return redirect('/' . config('chatter.routes.home'));
        } else
        $discussion->delete();
        toast('Destroyed successfully!','success','top-right');
        return redirect('/' . config('chatter.routes.home'));
    }

    private function sanitizeContent($content)
    {
        libxml_use_internal_errors(true);
        // create a new DomDocument object
        $doc = new \DOMDocument();

        // load the HTML into the DomDocument object (this would be your source HTML)
        $doc->loadHTML($content);

        $this->removeElementsByTagName('script', $doc);
        $this->removeElementsByTagName('style', $doc);
        $this->removeElementsByTagName('link', $doc);

        // output cleaned html
        return $doc->saveHtml();
    }

    private function removeElementsByTagName($tagName, $document)
    {
        $nodeList = $document->getElementsByTagName($tagName);
        for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0;) {
            $node = $nodeList->item($nodeIdx);
            $node->parentNode->removeChild($node);
        }
    }

    public function toggleEmailNotification($category, $slug = null)
    {
        if (!isset($category) || !isset($slug)) {
            return redirect(config('chatter.routes.home'));
        }

        $discussion = Models::discussion()->where('slug', '=', $slug)->first();

        $user_id = Auth::user()->id;

        // if it already exists, remove it
        if ($discussion->users->contains($user_id)) {
            $discussion->users()->detach($user_id);

            return response()->json(0);
        } else { // otherwise add it
             $discussion->users()->attach($user_id);

            return response()->json(1);
        }
    }
}
