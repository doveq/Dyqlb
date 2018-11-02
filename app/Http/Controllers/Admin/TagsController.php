<?php
/**
 * 标签管理
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Validation\Rule;

use App\Model\Tags;


class TagsController extends Controller
{

    /**
     * 显示标签页面
    */
    public function index(Request $request) {

        $data = [];
        $tags = new Tags;

        if ($request->has('tag')) {
            $tags = $tags->where('name', 'like', "%{$request->tag}%");
            $data['search']['tag'] = $request->tag;
        }

        $data['tags'] = $tags->orderBy('updated_at', 'desc')->get();

        return view('admin/tagsIndex', $data);
    }


    /**
     * 添加标签数据
     *
     * @param  Request  $request
     * @return
    */
    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|max:100|unique:tags',
        ]);

        $tags = new Tags;
        $tags->name = $request->name;

        $res = $tags->save();

        return redirect()->route('admin.prompt')
            ->with(['url' => route('admin.tags.index'), 'message' => '标签添加成功！']);
    }


    /**
     * 显示编辑页面
    */
    public function edit(Request $request) {

        $validatedData = $request->validate([
            'id' => 'required|numeric'
        ]);

        $tags = new Tags;
        $data['tags'] = $tags->find($request->id);

        return view('admin/tagsEdit', $data);
    }


    /**
     * 更新数据
    */
    public function update(Request $request) {

        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'name' => [
                'required',
                'max:100',
                Rule::unique('tags')->ignore($request->id), // 忽略指定id的唯一验证
            ]
        ]);

        $tags = Tags::find($request->id);
        $tags->name = $request->name;
        $tags->save();

        return redirect()->route('admin.prompt')
            ->with(['url' => route('admin.tags.edit', ['id' => $request->id]), 'message' => '标签修改成功！']);
    }


    /**
     * 删除
    */
    public function delete(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric'
        ]);

        $tags = Tags::find($request->id);
        $tags->forceDelete();

        return redirect()->route('admin.prompt')
            ->with(['url' => route('admin.tags.index'), 'message' => '标签删除成功！']);
    }


    /**
     * 判断标签是否存在
     *
     * @return json
    */
    public function isHas(Request $request) {
        $validatedData = $request->validate([
            'tag' => 'required'
        ]);

        $tags = Tags::where('name', $request->tag)->first();

        if (empty($tags->id)) {
            return response()->json([
                'status' => 0,
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'data' => [
                    'id' => $tags->id,
                    'name' => $tags->name,
                ]
            ]);
        }
    }


    /**
     * 获取标签json数据
     *
     * @return json
    */
    public function getJson(Request $request) {

        $tags = Tags::select('id', 'name')->orderBy('updated_at', 'desc')->get();
        return response()->json($tags);
    }

}
