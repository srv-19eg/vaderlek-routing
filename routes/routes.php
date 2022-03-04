<?php
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/','ApiController@index');
SimpleRouter::get('/latest/days/{days}','ApiController@latestDays');
SimpleRouter::get('/latest/week','ApiController@latestWeeks');
SimpleRouter::get('/latest/weeks/{weeks}','ApiController@latestWeeks');
