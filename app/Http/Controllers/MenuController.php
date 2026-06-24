<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('parent')->orderBy('order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $permissions = Permission::all();
        $parentMenus = Menu::whereNull('parent_id')->get();
        return view('admin.menus.create', compact('permissions', 'parentMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'item_type' => 'nullable|in:category,menu',
            'type' => 'nullable|in:article,chat,form,spreadsheet,link',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'permission_name' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'integer'
        ]);

        $data = $request->all();
        
        // Smart Ordering Logic
        if (!isset($data['order'])) {
            if ($request->item_type === 'category') {
                // If creating a top-level category, find where to insert it
                if ($request->filled('parent_id')) {
                    $referenceMenu = Menu::find($request->parent_id);
                    if ($referenceMenu) {
                        $data['order'] = $referenceMenu->order + 1;
                        Menu::where('parent_id', null)->where('order', '>=', $data['order'])->increment('order');
                    } else {
                        $data['order'] = Menu::whereNull('parent_id')->max('order') + 1;
                    }
                } else {
                    $data['order'] = Menu::whereNull('parent_id')->max('order') + 1;
                }
            } else {
                // If creating a child menu, put it at the bottom of that parent
                if ($request->filled('parent_id')) {
                    $data['order'] = Menu::where('parent_id', $request->parent_id)->max('order') + 1;
                } else {
                    $data['order'] = Menu::whereNull('parent_id')->max('order') + 1;
                }
            }
        }
        
        // If it's a category, override type
        if ($request->item_type === 'category') {
            $data['type'] = 'category';
            $data['url'] = '#';
            $data['parent_id'] = null; // Categories must be top level
        } else {
            // If it's a dynamic page (not a link), auto generate a placeholder URL
            if ($data['type'] !== 'link') {
                // The actual URL will be mapped to a dynamic route like /channels/{id}
                // We'll set it temporarily to '#' and update it after creation
                $data['url'] = '#';
            }
        }

        $menu = Menu::create($data);

        // Auto create Spatie Permissions for dynamic pages
        if ($menu->type !== 'category') {
            $viewPerm = 'view_menu_' . $menu->id;
            Permission::firstOrCreate(['name' => $viewPerm]);
            Permission::firstOrCreate(['name' => 'edit_menu_' . $menu->id]);
            
            // If permission_name is empty, default it to the generated view permission
            if (empty($menu->permission_name)) {
                $menu->update(['permission_name' => $viewPerm]);
            }
        }

        // If it's a dynamic page, update URL to its actual channel page using relative path
        if ($menu->type !== 'link' && $menu->type !== 'category') {
            $menu->update(['url' => route('dynamic-page.show', $menu->id, false)]);
        }

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $permissions = Permission::all();
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->get();
        return view('admin.menus.edit', compact('menu', 'permissions', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'integer'
        ]);

        $menu->update($request->all());

        return redirect()->back()->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('dashboard')->with('success', 'Menu deleted successfully.');
    }
}
