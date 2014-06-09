<?php

class ForumController extends \BaseController {

	public function index()
	{
        return View::make('forum.index');
	}
}