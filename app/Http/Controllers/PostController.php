<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\Model\User;
use App\Repository\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    protected $post;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostRepository $post)
    {
        $this->middleware('auth');
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 后台博客列表页
     */
    public function index()
    {
        if ($this->post->isSuperUser(Auth::user())) {
            $myPost = $this->post->paginate(10);
        } else {
            $myPost = $this->post->paginateBy('user_id', Auth::user()->id);
        }
        return view('post.index', ['myPost' => $myPost]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 后台博客页面编辑
     */
    public function edit(Request $request) {
        $posters = $this->post->getPoster(Auth::user());
        $id = $request->get('id') ?? '';
        if ($id) {
            $post = $this->post->find($id);
            if (!$post) {
                return view('error.error', ['message' => '没有找到该文章']);
            }
            if (!$this->post->checkPostUser($post, Auth::user())) {
                return view('error.error', ['message' => '没有权限']);
            }
            return view('post.post', ['post' => $post, 'posters' => $posters, 'default' => Auth::user()]);
        }
        return view('post.post', ['posters' => $posters, 'default' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 创建或更新博客
     */
    public function createOrUpdate(Request $request) {
        $data = $request->post();
        if (empty($data['id'])) {
            $this->post->create([
                'user_id' => $data['user_id'],
                'title' => $data['title'],
                'describe' => $data['describe'],
                'content' => $data['describe'],
            ]);
        }
        $this->post->update([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'describe' => $data['describe'],
            'content' => $data['describe'],
        ], $data['id']);

        return response()->redirectTo('post');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * 删除文章
     */
    public function delete(Request $request) {
        $id = $request->post('id') ?? '';
        if ($id) {
            $post = $this->post->find($id);
            if (!$post) {
                return view('error.error', ['message' => '没有找到该文章']);
            }
            $this->post->delete($id);
            return response()->redirectTo('post');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 搜索
     */
    public function search(Request $request) {
        $title = $request->post('title');
        $poster = $request->post('poster');
        $userId = User::where('name', 'like', $poster)->get();
        $poster = Post::where('user_id', $userId)->orWhere('title', 'like', $title)->paginate(10);
        return view('post.index', ['myPost' => $poster]);
    }
}
