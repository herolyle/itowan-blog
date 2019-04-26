<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    protected $post;
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user, PostRepository $post)
    {
        $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 后台博客列表页
     */
    public function index() {
        $myPost =  $this->post->paginate(10);
        return view('post.index', ['myPost' => $myPost]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 后台博客页面编辑
     */
    public function edit(Request $request, $id = '') {
        $posters = $this->user->all();
        if ($id) {
            $post = $this->post->find($id);
            if (!$post) {
                return view('error.error', ['message' => '没有找到该文章']);
            }
            return view('post.post', ['post' => $post, 'posters' => $posters, 'default' => Auth::user()]);
        }
        return view('post.post', ['posters' => $posters, 'default' => Auth::user()]);
    }

    /**
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 创建或更新博客
     */
    public function createOrUpdate(PostRequest $request) {
        $data = $request->post();
        $postData = [
            'user_id' => $data['user_id'],
            'title' => $data['title'] ?? '',
            'describe' => $data['describe'] ?? '',
            'content' => $data['content'] ?? '',
        ];
        if (empty($data['id'])) {
            $this->post->create($postData);
        } else {
            $post = $this->post->find($data['id']);
            $post->update($postData);
        }
        return response()->redirectTo('post');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * 删除文章
     */
    public function delete(Request $request) {
        $id = $request->post('id') ?? '';
        $post = $this->post->find($id);
        if (!$post) {
            return view('error.error', ['message' => '没有找到该文章']);
        }
        $post = $this->post->find($id);
        $post->delete($id);
        return response()->redirectTo('post');
    }
}
