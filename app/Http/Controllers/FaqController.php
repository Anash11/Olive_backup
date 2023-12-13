<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('faq.index', compact('faqs'));
    }
    public function add()
    {
        return view('faq.add-faq');
    }
    public function store(Request $request)
    {
        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        return redirect('faq')->with('success', "Faq added successfully");

    }
    public function edit($id)
    {
        $faq = Faq::where('id', $id)->first();
        return view('faq.edit-faq', compact('faq'));
    }
    public function update(Request $request)
    {
        $faq = Faq::where('id', $request->id)->first();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status;
        $faq->update();
        return redirect('faq')->with('success', "Faq updated successfully");
        
    }
    public function delete($id)
    {
        $faq = Faq::where('id', $id)->first();
        $faq->delete();
        return redirect('faq')->with('success', "Faq deleted successfully");
    }
}
