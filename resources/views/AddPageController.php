<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddPageController extends Controller
{
    public function index() {
        $pages = \App\AddPage::with('submenu')->get();
        return view('backend/add_page.index', compact(['pages']));
    }

    public function show($id) {
        $page = \App\AddPage::with('submenu')->find($id);
        return view('backend/add_page.show', compact('page'));
    }


    public function create() {
        $menus = \App\Menu::get();
        return view('backend/add_page.create',compact('menus'));
    }

  public function store(Request $request) {
        $this->validate($request, [
//            'image' => 'required',
        ]);

        $image = $request->file('image');
        $imagePath = str_random(16) . '.' . $image->getClientOriginalExtension();
        $image->move('upload', $imagePath);
        $data = $request->except('_token');
        $data['image'] = 'upload/' . $imagePath;       
        $call_image = \App\AddPage::create($data);

        session()->flash('success', 'New Banner  created successfully.');
        return redirect()->back();
    }

    public function edit($id) {
        $menus = \App\Menu::get();
        $page = \App\AddPage::with('submenu')->find($id);
        return view('backend/add_page.update', compact('page','menus'));
    }

   public function update(Request $request, $id) {
        $this->validate($request, [
        ]);
        $data = $request->except('_token');
        $banner = \App\AddPage::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $coverPath = str_random(16) . '.' . $image->getClientOriginalExtension();
            $image->move('upload', $coverPath);
            $data['image'] = 'upload/' . $coverPath;
        }
        
        $banner->updateOld($data);
        session()->flash('success', 'About Us Updated successfully.');
        return redirect()->back();
    }

    public function destroy($id) {
        $page = \App\AddPage::find($id)->delete();
        session()->flash('success', 'AddPage deleted successfully.');
        return redirect()->back();
    }
}
