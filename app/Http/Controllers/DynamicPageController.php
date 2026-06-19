<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    public function show(Menu $menu)
    {
        // Check permission if it's not a category and user is not admin
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasPermissionTo('view_menu_' . $menu->id)) {
            abort(403, 'Unauthorized action.');
        }

        return view('learning.channel', compact('menu'));
    }

    public function editContent(Menu $menu)
    {
        // Must be admin or have edit permission
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasPermissionTo('edit_menu_' . $menu->id)) {
            abort(403, 'Unauthorized action.');
        }

        return view('learning.edit-channel', compact('menu'));
    }

    public function updateContent(Request $request, Menu $menu)
    {
        // Must be admin or have edit permission
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasPermissionTo('edit_menu_' . $menu->id)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'nullable|string'
        ]);

        $menu->update([
            'content' => $request->input('content')
        ]);

        return redirect()->route('dynamic-page.show', $menu->id)->with('success', 'Content updated successfully.');
    }
}
